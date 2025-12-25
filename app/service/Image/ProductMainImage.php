<?php


namespace app\service\Image;


use app\model\Product;
use app\service\Fs\FS;
use Exception;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager;

class ProductMainImage extends BaseImage
{
    private ImageManager $optimizer;
    protected int $quality = 70;
    protected int $maxWidth = 550;
    protected int $maxHeight = 550;
    public string $destinationPath = '';
    protected string $absDestinationPath;
    protected string $productImageDir = 'product';
    protected string $thumbDir = 'thumbs';
    protected string $fileNameFromArt = '';
    protected string $nameFromArt = '';

    public function __construct(
        protected array $product, //иначе не видит контейнер при загрузке через DI in ProductActions
        protected       $file,
    )
    {
        parent::__construct();

        $this->optimizer       = new ImageManager(new Driver());
        $this->nameFromArt     = $this->getNameFromArt();
        $this->fileNameFromArt = $this->getFileName();
    }

    /**
     * @throws Exception
     */
    public function save(): self
    {

        $from = $this->file->getRealPath();

        $this->absDestinationPath = $this->getAbsoluteDestinationPath();
        $this->destinationPath    = $this->getRelativeDestinationPath();

        $this->deletePreviousFile();

        $extension = strtolower($this->file->getClientOriginalExtension());
        $image     = $this->optimizer->read($from);
        $image     = $image->scaleDown(width: $this->maxWidth);

        switch ($extension) {
            case 'jpg':
            case 'jpeg':
                $image->toJpeg($this->quality)->save($this->absDestinationPath);
                break;
            case 'png':
                $compression = (int)round(9 - ($this->quality / 100 * 9));
                $image->save(
                    $this->absDestinationPath, [
                        'interlaced' => true,
                        'quality' => $compression,
                    ]
                );
                break;

            case 'webp':
                $image
                    ->toWebp(quality: $this->quality)
                    ->save($this->absDestinationPath);
                break;
        }
        return $this;

    }

    public function getImageFileName(): string
    {
        return $this->fileNameFromArt;
    }

    /**
     * @throws Exception
     */
    private function getAbsProductMainImageDir(): string
    {
        $dir = FS::resolve(ROOT . $this->basePath . $this->productImageDir);
        if (!is_readable($dir)) throw new Exception("Директория основной картинки продукта не существует.");
        return $dir;
    }


    public function getNameFromArt(): string
    {
        $art = str_replace(['/', '//', '\\', '\\\\', '.', '{', '}', '$'], '_', $this->product['art']);
        $art = trim(strip_tags($art));
        return $art;
    }

    public static function getFileNameFromArt(Product $product): string
    {
        $art = str_replace(['/', '//', '\\', '\\\\', '.'], '_', $product['art']);
        return trim(strip_tags(mb_convert_encoding($art, 'ASCII')));
    }

    private function getFileName(): string
    {
        $name = $this->nameFromArt;
        return $name . '.' . $this->file->getClientOriginalExtension();
    }

    public function getRelativeDestinationPath(): string
    {
        $dir = FS::resolve($this->basePath . $this->productImageDir);;
        $name = $this->fileNameFromArt;
        $path = "$dir$name";
        return FS::invertSlashes($path);
    }

    public function getAbsoluteDestinationPath(): string
    {
        $dir = FS::resolve(ROOT, $this->basePath . $this->productImageDir);

        if (!is_dir($dir)) error_log(' dir  ------' . $dir . ' ----- is not dir');

        if (!is_writable($dir)) error_log(' dir  ------' . $dir . ' ----- not writable');

        $path = $dir.$this->fileNameFromArt;
        return $path;
    }


    /**
     * @throws Exception
     */
    public function deletePreviousFile(): void
    {
        $dir      = $this->getAbsProductMainImageDir();
        $fileName = $this->product['own_properties']['main_image'];

        $path = "$dir$fileName";
        if (is_readable($path) && !is_dir($path)) {
            unlink($path);
        }
    }

    public function makeThumb(int $quality = 0, int $sideWidth = 0): self
    {
        return $this;
    }

    private function decodeBase64Filename($filename): bool
    {
        return json_decode('"' . $filename . '"');
    }
    //    /**
//     * @throws Exception
//     */
//    public function getUploadFileTo(): array
//    {
//        $safeUpload = (new SafeImageFileUploadService())->safeUpload($this->file, $this->productImageDir);
//        return $safeUpload;
//    }
}
