<?php


namespace app\Domain\Entity;


use app\Domain\Product\Image\AbstractProductImage;
use app\model\Product;
use app\Services\ImagickService;

class ProductMainImageEntity extends AbstractProductImage
{
    protected string $art;
    protected ImagickService $imagickService;
    protected $thumbDir = 'thumbs' . DIRECTORY_SEPARATOR;
    protected $maxImgHeight = 700;
    protected $maxImgWidth = 700;
    protected $quality = 60;
    protected $maxThumbHeight = 300;
    protected $maxThumbWidth = 300;
    protected $fullPath;

    public function __construct(Product $product, array $file = [])
    {
        parent::__construct($product, $file);
//        $this->art = $this->prepareArticle($this->product->art);
//        $this->fullPath = $this->art . '.' . $this->getExtension();
    }

//    protected function getPathWithExt($relOrAbs, $type = null): string
//    {
//        $type = $type ?? $this->getExtension();
//        return $this->$relOrAbs .
//            $this->art .
//            '.' . $type;
//    }
//
//    public function getArt()
//    {
//        return $this->art;
//    }
//
//
//
//    public function thumbnail()
//    {
//        $absPath = $this->getAbsolutePath();
//
//        $webpName = $this->absoluteThumbPath . $this->art . '.webp';
//        copy($absPath, $webpName);
//        $ima = new ImagickService($webpName);
//        $ima->img->setImageFormat("WEBP");
//        $ima->thumbnail(
//            $webpName,
//            $this->maxThumbWidth,
//            $this->maxThumbHeight,
//            $this->quality,
//        );
//
////		$ima->img->writeImage($webpName);
//        $ima->img->clear();
//        $ima->img->destroy();
//    }
//
//    public function getExtension(): string
//    {
//        if ($this->file) {
//            preg_match('~\..{2,4}$~', $this->file['name'], $matches);
//            return str_replace('.', '', $matches[0]);
//        }
//        return $this->getFromAcceptedTypes();
//    }
//
//    protected function getFromAcceptedTypes()
//    {
//        foreach ($this->acceptedTypes as $type) {
//            $fileName = $this->getPathWithExt('absolutePath', $type);
//
//            if (file_exists($fileName)) {
//                return $this->getPathWithExt('relativePath', $type);
//            }
//        }
//        return '';
//    }



}
