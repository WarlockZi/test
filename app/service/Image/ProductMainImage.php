<?php


namespace app\service\Image;


use app\model\Product;
use app\service\FS;
use app\service\Image\TODO\ImagickService;

class ProductMainImage
{

    public function __construct(
        protected ProductImageService $imageService,
        protected Product             $product,
        protected array               $file = [],
        protected string              $art = '',
        protected                     $thumbDir = 'thumbs' . DIRECTORY_SEPARATOR,
        protected                     $fullPath = '',
        protected                     $maxImgHeight = 700,
        protected                     $maxImgWidth = 700,
        protected                     $quality = 60,
        protected                     $maxThumbHeight = 300,
        protected                     $maxThumbWidth = 300,
        protected string              $relativePath = '',
        protected string              $absolutePath = '',
        private readonly string       $relNoImage = PIC_SERVICE . "nophoto-min.jpg",
        protected string              $absoluteThumbPath = '',
        protected array               $acceptedTypes = ['jpg', 'jpeg', 'png', 'webp', 'gif'],
        protected array               $types = [
            "image/jpg" => "jpg",
            "image/jpeg" => "jpeg",
            "image/png" => "png",
            "image/webp" => "webp",
        ],

    )
    {

        $this->fullPath = $this->art . '.' . $this->getExtension();
    }

    public function setProduct(Product $product): self
    {
        $this->product = $product;
        return $this;
    }

    public function setFile(array $file): self
    {
        $this->file = $file;
        return $this;
    }

    public function deletePreviousFile(): void
    {
        foreach ($this->acceptedTypes as $ext) {
            $fileName = "{$this->absolutePath}{$this->product->art}.{$ext}";
            if (file_exists($fileName)) {
                unlink($fileName);
            }
        }
    }

    private function getDestination(): string
    {
        $absPath = $this->imageService->getAbsolutePath();

        $extension = pathinfo($this->file['name'], PATHINFO_EXTENSION);
        $art       = $this->imageService->getArt($this->product);
        $name      = $art . ".{$extension}";

        return $absPath . $name;
    }

    public function init(array $file, Product $product): self
    {
        $this->file    = $file;
        $this->product = $product;
        return $this;
    }

    public function save(): string
    {
        $uploadDir = $this->imageService->getAbsolutePath();

        $absolutePath = realpath($uploadDir);

        if ($absolutePath === false) {
            die("Указанная директория не существует");
        }

        if (isset($_FILES['file'])) {
            $tmpName  = $_FILES['file']['tmp_name'];
            $fileName = basename($_FILES['file']['name']);

            $targetPath = $absolutePath . DIRECTORY_SEPARATOR . $fileName;

            // Проверяем, что файл перемещается в разрешенную директорию
            if (str_starts_with(realpath(dirname($targetPath)), $absolutePath)) {
                move_uploaded_file($tmpName, $targetPath);
                return $targetPath;

            } else {
                echo "Попытка загрузки файла за пределы разрешенной директории";
            }
        }
        return '';
    }

//    public function save(): string
//    {
//        $this->deletePreviousFile();
////        $destination_path = $this->getDestination();
////        if (move_uploaded_file($this->file['tmp_name'], $destination_path)) {
//            return $this->imageService->getRelativeImage($product);
//        }
//        return '';
////		$mainImage->thumbnail();
//    }

    protected function getPathWithExt($relOrAbs, $type = null): string
    {
        $type = $type ?? $this->getExtension();
        return $this->$relOrAbs .
            $this->art .
            '.' . $type;
    }

    public function getExtension(): string
    {
        if ($this->file) {
            preg_match('~\..{2,4}$~', $this->file['name'], $matches);
            return str_replace('.', '', $matches[0]);
        }
        return $this->getFromAcceptedTypes();
    }

    protected function getFromAcceptedTypes(): string
    {
        foreach ($this->acceptedTypes as $type) {
            $fileName = $this->getPathWithExt('absolutePath', $type);

            if (file_exists($fileName)) {
                return $this->getPathWithExt('relativePath', $type);
            }
        }
        return '';
    }

    public function reduceQuality(int $quality = null): void
    {
        $quality      = $quality ?? $this->quality;
        $imageService = new ImagickService($this->getAbsolutePath());
        $q            = $imageService->img->getImageCompressionQuality();
        if ($q > $quality) {
            $imageService->img->setImageCompressionQuality($quality);
            $imageService->img->writeImage();
            $imageService->img->clear();
            $imageService->img->destroy();
        }
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

    public function getAbsoluteImage(Product $product): string
    {
        if ($this->getImageAbsolutePath($product)) {
            return $this->getAbsoluteImage($product);
        }
        return FS::platformSlashes(ROOT . $this->relNoImage);
    }


}
