<?php


namespace app\service\Image;


use app\model\Product;
use app\service\Fs\FS;
use app\service\Image\ImageProcessor\ImageOptimizer;
use Exception;
use Throwable;

class ProductMainImage extends BaseImage
{
    private ImageOptimizer $optimizer;

    public function __construct(
        protected array $product, //иначе не видит контейнер при загрузке через DI in ProductActions
        protected  $file,
        protected       $productImageDir = 'product',
        protected       $thumbDir = 'thumbs',
    )
    {
        parent::__construct();
        $this->optimizer = new ImageOptimizer(70, $this->maxWidth, $this->maxHeight);
    }

    /**
     * @throws Exception
     */
    private function getAbsProductMainImageDir(): string
    {
        $dir = FS::resolve(ROOT . $this->basePath . $this->productImageDir);
        try {
            is_readable($dir);
            return $dir;
        } catch (Throwable $exception) {
            throw new Exception("Директория основной картинки продукта не существует. -" . $exception);
        }
    }

    public function makeThumb(int $quality = 0, int $sideWidth = 0): self
    {
        return $this;
    }

    private function getNameFromArt(): string
    {
        $art = str_replace(['/', '//', '\\', '\\\\'], '_', $this->product['art']);
        $art = $this->decodeBase64Filename($art); // мб такая строка "/var/www/vitexopt/data/www/vitexopt.ru/storage/app/pic/product/\xd0\x9f\xd0\x9d\xd0\x94-8_19_2\xd1\x80-\xd0\x91-\xd0\xa1_450.jpg"
        return trim(strip_tags($art));
    }
    public static function getFileNameFromArt(Product $product): string
    {
        $art = str_replace(['/', '//', '\\', '\\\\', '.','{','}','$'], '_', $product['art']);
        return trim(strip_tags($art));
    }
    private function decodeBase64Filename($filename): bool
    {
        return json_decode('"' . $filename . '"');
    }


    private function getFileName(): string
    {
        $name = $this->getNameFromArt();
        return $name . '.' . $this->file['extension'];
    }
    /**
     * @throws Exception
     */
    public function getUploadFileTo(): string
    {
        $dir  = $this->getAbsProductMainImageDir();
        $name = $this->getNameFromArt();
        $type = $this->getType();
        $path = "$dir$name.$type";
        return $path;
    }
    /**
     * @throws Exception
     */
    public function getRelativePath(): string
    {
        $dir  = FS::resolve($this->basePath . $this->productImageDir);;
        $name = $this->getNameFromArt();
        $type = $this->getType();
        $path = "$dir$name.$type";
        return FS::invertSlashes($path);
    }

    public function delFileWithDifferentExt(): string
    {
        $art = $this->getAbsoluteImage();
        foreach ($this->extensions as $ext) {
            $relFile = $this->relativePath . $art . ".{$ext}";
            $file    = FS::platformSlashes(ROOT . $relFile);
            if (file_exists($file)) {
                return $relFile;
            }
        }
        return $this->relNoImage;
    }

    /**
     * @throws Exception
     */
    public function save(): self
    {
        $from = $this->file->getRealPath();
        $to   = $this->getUploadFileTo();
        try {
            $this->deletePreviousFile();
            $f = $this->optimizer->optimize($from, $to);
            return $this;
        } catch (Throwable $exception) {
            throw new Exception("Попытка загрузки файла за пределы разрешенной директории");
        }
    }

    /**
     * @throws Exception
     */
    public function deletePreviousFile(): void
    {
        $dir  =  $this->getAbsProductMainImageDir();
        $name = $this->getNameFromArt();
        foreach ($this->acceptedTypes as $ext) {
            $path = "$dir$name.$ext";
            if (file_exists($path)) {
                unlink($path);
                break;
            }
        }
    }

    public function reduceQuality(int $quality = 70): void
    {
        $this->processor->reduceQuality($quality);

        $imageService->img->writeImage();
        $imageService->img->clear();
        $imageService->img->destroy();
    }

    public function thumbnail()
    {
        $absPath = $this->getAbsolutePath();

        $webpName = $this->absoluteThumbPath . $this->art . '.webp';
        copy($absPath, $webpName);
        $ima = new ImagickService($webpName);
        $ima->img->setImageFormat("WEBP");
        $ima->thumbnail(
            $webpName,
            $this->maxThumbWidth,
            $this->maxThumbHeight,
            $this->quality,
        );

//		$ima->img->writeImage($webpName);
        $ima->img->clear();
        $ima->img->destroy();
    }



}
