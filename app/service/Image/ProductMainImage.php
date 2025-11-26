<?php


namespace app\service\Image;


use app\model\Product;
use app\service\Fs\FS;
use Exception;
use Intervention\Image\Drivers\Imagick\Driver;
use Intervention\Image\ImageManager;
use Throwable;

class ProductMainImage extends BaseImage
{
    private $optimizer;
    protected int $quality = 70;
    protected int $maxWidth = 550;
    protected int $maxHeight = 550;
    protected string $destinationPath = '';
    protected string $absDestinationPath;

    public function __construct(
        protected array $product, //иначе не видит контейнер при загрузке через DI in ProductActions
        protected       $file,
        protected       $productImageDir = 'product',
        protected       $thumbDir = 'thumbs',
        protected       $fileNameFromArt = '',
        protected       $nameFromArt = '',
    )
    {
        parent::__construct();

        $this->optimizer       = new ImageManager(new Driver());
        $this->fileNameFromArt = $this->getFileName();
        $this->nameFromArt = $this->getNameFromArt();
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
        $image     = $this->optimizer->read($from);
        $image     = $image->scaleDown(width: $this->maxWidth);
        $extension = strtolower($this->file->getClientOriginalExtension());
        error_log($this->absDestinationPath);

        switch ($extension) {
            case 'jpg':
            case 'jpeg':
                $image->toJpeg($this->quality)->save($this->absDestinationPath);
                break;

            case 'png':
                // PNG uses compression level (0-9) instead of quality
                $compression = round(9 - ($this->quality / 100 * 9));
                $image->toPng($compression)->save($this->absDestinationPath);
                break;

            case 'webp':
                $image->toWebp($this->quality)->save($this->absDestinationPath);
                break;

            default:
                $image->save($this->absDestinationPath, quality: $this->quality);
        }
        return $this;

    }

    public function getImageFileName()
    {
        return $this->fileNameFromArt;
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

    public function getNameFromArt(): string
    {
        $art = str_replace(['/', '//', '\\', '\\\\', '.', '{', '}', '$'], '_', $this->product['art']);
//        $art = $this->decodeBase64Filename($art); // мб такая строка "/var/www/vitexopt/data/www/vitexopt.ru/storage/app/pic/product/\xd0\x9f\xd0\x9d\xd0\x94-8_19_2\xd1\x80-\xd0\x91-\xd0\xa1_450.jpg"
        $enc =  mb_detect_encoding($art);
        error_log('**** enc0 ******** '. $enc . ' ***********');
        $art =  trim(strip_tags(mb_convert_encoding($art, 'ASCII')));
        error_log('************ '. $art . ' ***********');
        $enc =  mb_detect_encoding($art);
        error_log('**** enc1 ******** '. $enc . ' ***********');
        return $art;
    }

    public static function getFileNameFromArt(Product $product): string
    {
        $art = str_replace(['/', '//', '\\', '\\\\', '.'], '_', $product['art']);
        return trim(strip_tags(mb_convert_encoding($art, 'ASCII')));
    }

    private function decodeBase64Filename($filename): bool
    {
        return json_decode('"' . $filename . '"');
    }


    private function getFileName(): string
    {
        $name = $this->nameFromArt;
        return $name . '.' . $this->file->getClientOriginalExtension();
    }

    /**
     * @throws Exception
     */
    public function getUploadFileTo(): array
    {
        $safeUpload = (new SafeImageFileUploadService())->safeUpload($this->file, $this->productImageDir);
        return $safeUpload;
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
        $dir = FS::resolve($this->basePath . $this->productImageDir);;
        $name = $this->nameFromArt;
        $type = $this->getType();
        $path = ROOT . "$dir$name.$type";
        return $path;
    }


    /**
     * @throws Exception
     */
    public function deletePreviousFile(): void
    {
        $dir  = $this->getAbsProductMainImageDir();
        $name = $this->nameFromArt;

        foreach ($this->acceptedTypes as $ext) {
            $path = "$dir$name.$ext";
            if (file_exists($path)) {
                unlink($path);
                break;
            }
        }
    }

}
