<?php

namespace app\service\Sync\Load;

use app\model\Product;
use app\model\ProductProperty;
use app\service\ShortLink\ShortlinkService;
use app\service\Slug\SlugService;
use Carbon\Carbon;
use Illuminate\Database\Capsule\Manager as Capsule;
use Throwable;

class LoadProductsBatching extends LoadService
{
    private array $existing = [];
    private array $deleted = [];
    private array $created = [];

    // Размер батча для пакетной обработки
    private const BATCH_SIZE = 500;

    public function __construct()
    {
        parent::__construct();
        $this->setImportFile();
    }

    private function setImportFile(): void
    {
        $file = ROOT . env('SYNC_PATH') . 'unzipped/loaded/' . env('SYNC_IMPORT_FILE');
        $this->logger->write("--- xml file - $file ---");
        $xml               = simplexml_load_file($file);
        $importData        = json_decode(json_encode($xml), true);
        $this->productData = $importData['Каталог']['Товары']['Товар'];
    }

    public function load(): void
    {
        try {
            // Получаем соединение с БД
            $connection = Capsule::connection();

            // Отключаем события модели для ускорения
            Product::unsetEventDispatcher();
            ProductProperty::unsetEventDispatcher();

            // Начинаем транзакцию
            $connection->beginTransaction();

            $this->updateOrCreateProductsBatch();
            $this->deleteNonexisted();

            // Коммитим транзакцию
            $connection->commit();

        } catch (Throwable $exception) {
            // Откатываем транзакцию при ошибке
            if ($connection->inTransaction()) {
                $connection->rollBack();
            }
            throw $exception;
        }
    }

    private function deleteNonexisted(): void
    {
        if (empty($this->existing)) {
            return;
        }

        // Один запрос вместо множества
        $toDelete = Product::whereNotIn('1s_id', $this->existing)
            ->pluck('1s_id')
            ->toArray();

        if (empty($toDelete)) {
            return;
        }

        $this->deleted[] = $toDelete;

        // Массовое удаление
        Product::whereIn('1s_id', $toDelete)->delete();
        ProductProperty::whereIn('product_1s_id', $toDelete)->delete();
    }

    private function updateOrCreateProductsBatch(): void
    {
        $productsToInsert = [];
        $productsToUpdate = [];
        $propertiesToInsert = [];
        $propertiesToUpdate = [];

        // Получаем все существующие товары одним запросом
        $existingProducts = Product::withTrashed()
            ->pluck('id', '1s_id')
            ->toArray();

        // Получаем все существующие свойства одним запросом
        $existingProperties = ProductProperty::all()
            ->keyBy('product_1s_id')
            ->toArray();

        foreach ($this->productData as $good) {
            $this->existing[$good['Ид']] = $good['Ид'];

            $productData = $this->prepareProductData($good);
            $propertyData = $this->preparePropertyData($good);

            $productId = $existingProducts[$good['Ид']] ?? null;

            if ($productId) {
                // Обновление существующего
                $productsToUpdate[] = [
                    'id' => $productId,
                    'data' => $productData
                ];

                if (isset($existingProperties[$good['Ид']])) {
                    $propertiesToUpdate[] = [
                        'id' => $existingProperties[$good['Ид']]['id'],
                        'data' => $propertyData
                    ];
                } else {
                    $propertiesToInsert[] = $propertyData;
                }
            } else {
                // Вставка нового
                $productsToInsert[] = $productData;
                $propertiesToInsert[] = $propertyData;
                $this->created[] = $productData['name'];
            }

            // Пакетная обработка
            if (count($productsToInsert) >= self::BATCH_SIZE) {
                $this->processBatch(
                    $productsToInsert,
                    $productsToUpdate,
                    $propertiesToInsert,
                    $propertiesToUpdate
                );

                $productsToInsert = [];
                $productsToUpdate = [];
                $propertiesToInsert = [];
                $propertiesToUpdate = [];
            }
        }

        // Обрабатываем остаток
        if (!empty($productsToInsert) || !empty($productsToUpdate)) {
            $this->processBatch(
                $productsToInsert,
                $productsToUpdate,
                $propertiesToInsert,
                $propertiesToUpdate
            );
        }
    }

    private function processBatch(
        array &$productsToInsert,
        array &$productsToUpdate,
        array &$propertiesToInsert,
        array &$propertiesToUpdate
    ): void {
        $connection = Capsule::connection();

        // Массовая вставка товаров
        if (!empty($productsToInsert)) {
            Product::insert($productsToInsert);
        }

        // Массовое обновление товаров
        if (!empty($productsToUpdate)) {
            foreach ($productsToUpdate as $update) {
                Product::where('id', $update['id'])->update($update['data']);
            }
        }

        // Массовая вставка свойств
        if (!empty($propertiesToInsert)) {
            ProductProperty::insert($propertiesToInsert);
        }

        // Массовое обновление свойств
        if (!empty($propertiesToUpdate)) {
            foreach ($propertiesToUpdate as $update) {
                ProductProperty::where('id', $update['id'])->update($update['data']);
            }
        }
    }

    private function prepareProductData(array $good): array
    {
        $g['1s_id']          = $good['Ид'];
        $g['category_1s_id'] = $good['Группы']['Ид'];
        $g['art']            = $good['Артикул'] ? trim($good['Артикул']) : '';
        $g['name']           = $good['Наименование'];
        $g['print_name']     = $good['ЗначенияРеквизитов']['ЗначениеРеквизита'][3]['Значение'] ?? '';
        $g['slug']           = $this->setSlug($g);
        $g['deleted_at']     = null;
        $g['updated_at']     = Carbon::now()->toDateTimeString();
        $g['created_at']     = Carbon::now()->toDateTimeString();

        return $g;
    }

    private function preparePropertyData(array $good): array
    {
        $txt = !empty($good['Описание']) ? str_replace("\n", '<br>', $good['Описание']) : '';
        $shortLink = ShortlinkService::getValidShortLink();

        return [
            'product_1s_id' => $good['Ид'],
            'short_link' => $shortLink,
            'txt' => $txt,
            'created_at' => Carbon::now()->toDateTimeString(),
            'updated_at' => Carbon::now()->toDateTimeString(),
        ];
    }

    private function setSlug($g): string
    {
        return SlugService::getValidProductSlug($g);
    }
}