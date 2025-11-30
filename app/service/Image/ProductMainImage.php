<?php


namespace app\service\Image;


use app\model\Product;
use app\service\Fs\FS;
use Exception;
use Intervention\Image\Drivers\Imagick\Decoders\BinaryImageDecoder;
use Intervention\Image\Drivers\Imagick\Driver;
use Intervention\Image\Encoders\PngEncoder;
use Intervention\Image\Encoders\WebpEncoder;
use Intervention\Image\ImageManager;
use Imagick;

class ProductMainImage extends BaseImage
{
    private $optimizer;
    protected int $quality = 70;
    protected int $maxWidth = 550;
    protected int $maxHeight = 550;
    public string $destinationPath = '';
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

        if (!extension_loaded('imagick')) {
            response()->json(['popup'=>'ext not loaded']);
        }

        $class = 'Imagick';
        if (!class_exists($class)) {
            response()->json(['popup'=>'no class Imagick']);
        }


//        $result = $this->optimizer->driver()->supports('webp');
//        $result ? error_log('******* can read webp *******')
//            : error_log('******* can not read webp ************');


//        error_log('******* scaled down' . $from);

        $extension = strtolower($this->file->getClientOriginalExtension());

        switch ($extension) {
            case 'jpg':
            case 'jpeg':
                $image = $this->optimizer->read($from);
                $image = $image->scaleDown(width: $this->maxWidth);
                $image->toJpeg($this->quality)->save($this->absDestinationPath);
                break;

            case 'png':
                $image       = $this->optimizer->read($from);
                $image       = $image->scaleDown(width: $this->maxWidth);
                $compression = round(9 - ($this->quality / 100 * 9));
                $encoder     = new PngEncoder($compression);
                $image->encode($encoder)->save($this->absDestinationPath);
                break;

            case 'webp':
                error_log('********** try to read  ********');
                $webpBinary = file_get_contents($from);

                $decoder = new BinaryImageDecoder();
                $image = $decoder->decode($webpBinary);

//                $image   = $this->optimizer->read($webpBinary);
                error_log('********** read ********');
                $image   = $image->scaleDown(width: $this->maxWidth);
                $encoder = new WebpEncoder($this->quality);
                $image->encode($encoder)->save($this->absDestinationPath);
                error_log('********* saved webp' . $from);

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

    public function makeThumb(int $quality = 0, int $sideWidth = 0): self
    {
        return $this;
    }

    public function getNameFromArt(): string
    {
        $art = str_replace(['/', '//', '\\', '\\\\', '.', '{', '}', '$'], '_', $this->product['art']);
//       мб такая строка "/var/www/vitexopt/data/www/vitexopt.ru/storage/app/pic/product/\xd0\x9f\xd0\x9d\xd0\x94-8_19_2\xd1\x80-\xd0\x91-\xd0\xa1_450.jpg"
        $art = trim(strip_tags($art));
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
        $dir = FS::resolve(ROOT, $this->basePath . $this->productImageDir);

        if (!is_dir($dir)) {
            error_log(' dir  ------' . $dir . ' ----- is not dir');
        }
        if (!is_writable($dir)) {
            error_log(' dir  ------' . $dir . ' ----- not writable');
        }
        $name = $this->nameFromArt;
        $type = $this->getType();
        $path = "$dir$name.$type";
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
        if (file_exists($path)) {
            unlink($path);
        }
    }
}
