<?php

namespace app\model;

use app\model\Test;
use app\core\Base\Model;
use app\core\App;

//use Intervention\Image\ImageManagerStatic as Image;

class Product extends Model {

   public $table = 'products';

   protected function createImgPaths($num, $alias, $rate = 800, $sub, $ext, $isOnly) {
      $ext = $ext ?: 'jpg';
      $p['filename'] = $rate ? "{$alias}-{$rate}.{$ext}" : "{$alias}.{$ext}";
      $p['group'] = $_SERVER['DOCUMENT_ROOT'] . '/pic/' . $alias . '/' . $sub . '/';
      if ($num) {
         $p['toPath'] = $_SERVER['DOCUMENT_ROOT'] . '/pic/' . $alias . '/' . $sub . "/" . $num . "/";
      } else {
         $p['toPath'] = $_SERVER['DOCUMENT_ROOT'] . '/pic/' . $alias . '/' . $sub . "/1/";
      }
// если в группе несколько картинок, переименуем папки +1
// а текущий файл вставим на первое место
      $i = 1;
      if (!$isOnly && is_dir($p['toPath']) && !$num) {
         $files = scandir($p['group']);
         foreach ($files as $file) {
            if ($file == "." || $file == "..")
               continue;
            if (is_dir($p['group'] . $i)) {
               $i++;
               $p['toPath'] = $_SERVER['DOCUMENT_ROOT'] . '/pic/' . $alias . '/' . $sub . "/{$i}" . '/';
            }
         }
      }
      $p['to'] = $p['toPath'] . $p['filename'];
      $p['rel'] = $alias . '/' . $sub . '/' . $num . '/';
      $p['num'] = $i;
      return $p;
   }

   public function uploadIMG($alias, $sub, $isOnly, $file) {
      $toExt = 'webp';
      $quality = 75;
      $sizes = [0, 80, 300, 700];

      foreach ($sizes as $size) {
         if (!$size) {
            $ps = $this->createImgPaths(null, $alias, null, $sub, null, $isOnly);
            if (!is_dir($ps['toPath'])) {
               mkdir($ps['toPath'], 0777, true);
            }
            move_uploaded_file($file['tmp_name'], $ps['to']);
         } else {
            $pX = $this->createImgPaths($ps['num'], $alias, $size, $sub, $toExt, $isOnly);

            $new_image = new picture($ps['to']);
            $new_image->autoimageresize($size, $size);
            $new_image->imagesave($toExt, $pX['to'], $quality, 0777);
         }
      }
      return $pX['rel'];
   }

   public function getProductImg($id) {
      $sql = "SELECT * FROM pic WHERE `model` = 'product' AND `modelId` = {$id}";
      $arr = $this->findBySql($sql);
      if ($arr) {
         foreach ($arr as $i => $img) {
            $ar[$img['sub']][$i]['path'] = $img['path'];
            $ar[$img['sub']][$i]['title'] = $img['title'];
            $ar[$img['sub']][$i]['alt'] = $img['alt'];
         }
         return $ar;
      }
      return false;
   }

   public function updateProductIMG($arr) {

      if (!$_FILES || !$_FILES['file']) {
         exit('Файл не передан на сервер!');
      }
      extract($arr);
      $file = $_FILES['file'];
      $hash = hash_file('md5', $file['tmp_name']);
      $path = '/' . $model . '/' . $alias . '/' . $picType . '/';


      if ($isOnly) {// у данной продукции есть картинка, но не такая
         $sql = "SELECT * FROM `pic` WHERE `model` = ? AND `sub` = ? AND `modelId` = ?";
         $params = [$model, $picType, $pkeyVal];
         $thisProductHasSomePic = $this->findBySql($sql, $params);
         if (isset($thisProductHasSomePic[0])) {// у продукта уже есть картинка
            if ($newPath = $this->uploadIMG($alias, $picType, $isOnly, $file)) {
               if ($hash !== $thisProductHasSomePic[0]['hash']) { // и отличается от вставляемой
                  $sql = "UPDATE `pic` SET `hash` = ?, `path` = ? WHERE `id` = ?";
                  $params = [$hash, $thisProductHasSomePic[0]['path'], $thisProductHasSomePic[0]['id']];
                  $this->insertBySql($sql, $params);
               }
            }
         } else {
            if ($newPath = $this->uploadIMG($alias, $picType, $isOnly, $file)) {
               $sql = "INSERT INTO `pic` (`alias`, `path`, `hash`, `model`, `sub`, `modelId`)  VALUES (?, ?, ?, ?, ?, ?)";
               $params = [$alias, $newPath, $hash, $model, $picType, $pkeyVal];
               $this->insertBySql($sql, $params);
            }
         }
      } else { // множественная картинка
         $sql = "SELECT * FROM `pic` WHERE `hash` = ? AND `model` = ? AND `sub` = ? AND `modelId` = ?";
         $params = [$hash, $model, $picType, $pkeyVal];
         $thisProductHasThisPic = $this->findBySql($sql, $params);
         if (!$thisProductHasThisPic) { /// у данного товара еще нет такой картинки картинки
            if ($newPath = $this->uploadIMG($alias, $picType, $isOnly, $file)) {
               $sql = "INSERT INTO `pic` (`alias`, `path`, `hash`, `model`, `sub`, `modelId`)  VALUES (?, ?, ?, ?, ?, ?)";
               $params = [$alias, $newPath, $hash, $model, $picType, $pkeyVal];
               $this->insertBySql($sql, $params);
               exit($newPath);
            }
         } else {
            exit('Такая картинка уже есть!');
         }// иначе у данного товара уже есть такая картинка-не делаем ничего
         if ($newPath = $this->uploadIMG($alias, $picType, $isOnly, $file)) {
            $sql = "INSERT INTO `pic` (`alias`, `path`, `hash`, `model`, `sub`, `modelId`)VALUES (?, ?, ?, ?, ?, ?)";
            $params = [$alias, $newPath, $hash, $model, $picType, $pkeyVal];
            $this->insertBySql($sql, $params);
            exit($newPath);
         }
         exit($newPath);
      }
   }

   public function delProductImg($arr) {
      extract($arr);
      $sql = "SELECT * FROM pic WHERE `model` = ? AND `modelId` = ? AND `path`= ? AND `sub`= ?";
      $params = [$model, $pkeyVal, $delPath, $sub];
      $res = $this->findBySql($sql, $params);
      if (count($res) > 0) {
         $dir = ROOT . '/pic/' . $delPath;
         if (is_dir($dir)) {
            $res1 = Model::removeDirectory($dir);
         }
      }
      $sql = "DELETE FROM pic WHERE `model` = ? AND `modelId` = ? AND `path`=? AND `sub`= ?";
      $params = [$model, $pkeyVal, $delPath, $sub];
      $res = $this->insertBySql($sql, $params);
      exit($delPath);
   }

   public function getProductParents($parentId) {

      if ($parentId) {
         $sql = 'SELECT * FROM category WHERE id = ?';
         $params = [$parentId];
         $parent = $this->findBySql($sql, $params)[0];
         return $parent;
      }
   }

   public function getSale() {
      $sql = 'SELECT * FROM products WHERE sale = ?';
      $params = [1];
      $products = $this->findBySql($sql, $params);
      return $products;
   }

   public function isProduct($url) {

      if ($product = $this->findOne($url, 'alias')) {
         $product['parents'][] = $this->getProductParents($product['parent']);
         while ($last = end($product['parents'])['parent']) {
            $product['parents'][] = $this->getProductParents($last);
         }
         App::$app->cache->set('product' . $url, $product, 30);
      };
      if (!$product) {
         return FALSE;
      };
      return $product;
   }

   public function productsCnt() {

      $sql = 'SELECT COUNT(*) FROM PRODUCTS';
      $arr = $this->findBySql($sql)[0];
      return $arr['COUNT(*)'];
   }

   public function getProducts($categoryId) {

      $param = [$categoryId];
      $sql = 'SELECT * FROM products WHERE parent = ?';
      $products = $this->findBySql($sql, $param);
      return $products;
   }

   public function getProduct($productId) {

      $param = [$productId];
      $sql = 'SELECT * FROM products WHERE id = ? LIMIT 1';
      $product = $this->findBySql($sql, $param);
      return $product[0];
   }

//   public function getProductProps($category) {
//      if (is_array($category)) {
//         $props = [];
//         if (isset($category['parentProps'])) {
//            $props = array_merge($category['parentProps'],$props);
//         }
//         if (isset($category['children']['categories'])) {
//            while ($category['children']['categories']){
//               $props = array_merge($category['parentProps'],$props);
//            }
//         }
//         return $props;
//      }
//   }
}

class picture {

   private $image_file;
   public $image;
   public $image_type;
   public $image_width;
   public $image_height;

   public function imagesave($image_type = 'jpeg', $image_file = NULL, $image_compress = 100, $image_permiss = '') {
      if ($image_file == NULL) {
         switch ($image_type) {
            case 'gif': header("Content-type: image/gif");
               break;
            case 'jpeg': header("Content-type: image/jpeg");
               break;
            case 'png': header("Content-type: image/png");
               break;
            case 'webp': header("Content-type: image/webp");
               break;
         }
      }
      switch ($image_type) {
         case 'gif': imagegif($this->image, $image_file);
            break;
         case 'jpeg': imagejpeg($this->image, $image_file, $image_compress);
            break;
         case 'png': imagepng($this->image, $image_file);
            break;
         case 'webp': imagewebp($this->image, $image_file);
            break;
      }
      if ($image_permiss != '') {
         chmod($image_file, $image_permiss);
      }
      imagedestroy($this->image);
   }

   public function __construct($image_file) {
      $this->image_file = $image_file;
      $image_info = getimagesize($this->image_file);
      $this->image_width = $image_info[0];
      $this->image_height = $image_info[1];
      switch ($image_info[2]) {
         case 1: $this->image_type = 'gif';
            break; //1: IMAGETYPE_GIF
         case 2: $this->image_type = 'jpeg';
            break; //2: IMAGETYPE_JPEG
         case 3: $this->image_type = 'png';
            break; //3: IMAGETYPE_PNG
         case 4: $this->image_type = 'swf';
            break; //4: IMAGETYPE_SWF
         case 5: $this->image_type = 'psd';
            break; //5: IMAGETYPE_PSD
         case 6: $this->image_type = 'bmp';
            break; //6: IMAGETYPE_BMP
         case 7: $this->image_type = 'tiffi';
            break; //7: IMAGETYPE_TIFF_II (порядок байт intel)
         case 8: $this->image_type = 'tiffm';
            break; //8: IMAGETYPE_TIFF_MM (порядок байт motorola)
         case 9: $this->image_type = 'jpc';
            break; //9: IMAGETYPE_JPC
         case 10: $this->image_type = 'jp2';
            break; //10: IMAGETYPE_JP2
         case 11: $this->image_type = 'jpx';
            break; //11: IMAGETYPE_JPX
         case 12: $this->image_type = 'jb2';
            break; //12: IMAGETYPE_JB2
         case 13: $this->image_type = 'swc';
            break; //13: IMAGETYPE_SWC
         case 14: $this->image_type = 'iff';
            break; //14: IMAGETYPE_IFF
         case 15: $this->image_type = 'wbmp';
            break; //15: IMAGETYPE_WBMP
         case 16: $this->image_type = 'xbm';
            break; //16: IMAGETYPE_XBM
         case 17: $this->image_type = 'ico';
            break; //17: IMAGETYPE_ICO
         default: $this->image_type = '';
            break;
      }
      $this->fotoimage();
   }

   private function fotoimage() {
      switch ($this->image_type) {
         case 'gif': $this->image = imagecreatefromgif($this->image_file);
            break;
         case 'jpeg': $this->image = imagecreatefromjpeg($this->image_file);
            break;
         case 'png': $this->image = imagecreatefrompng($this->image_file);
            break;
      }
   }

   public function autoimageresize($new_w, $new_h) {
      $difference_w = 0;
      $difference_h = 0;
      if ($this->image_width < $new_w && $this->image_height < $new_h) {
         $this->imageresize($this->image_width, $this->image_height);
      } else {
         if ($this->image_width > $new_w) {
            $difference_w = $this->image_width - $new_w;
         }
         if ($this->image_height > $new_h) {
            $difference_h = $this->image_height - $new_h;
         }
         if ($difference_w > $difference_h) {
            $this->imageresizewidth($new_w);
         } elseif ($difference_w < $difference_h) {
            $this->imageresizeheight($new_h);
         } else {
            $this->imageresize($new_w, $new_h);
         }
      }
   }

   public function percentimagereduce($percent) {
      $new_w = $this->image_width * $percent / 100;
      $new_h = $this->image_height * $percent / 100;
      $this->imageresize($new_w, $new_h);
   }

   public function imageresizewidth($new_w) {
      $new_h = $this->image_height * ($new_w / $this->image_width);
      $this->imageresize($new_w, $new_h);
   }

   public function imageresizeheight($new_h) {
      $new_w = $this->image_width * ($new_h / $this->image_height);
      $this->imageresize($new_w, $new_h);
   }

   public function imageresize($new_w, $new_h) {
      $new_image = imagecreatetruecolor($new_w, $new_h);
      imagecopyresampled($new_image, $this->image, 0, 0, 0, 0, $new_w, $new_h, $this->image_width, $this->image_height);
      $this->image_width = $new_w;
      $this->image_height = $new_h;
      $this->image = $new_image;
   }

   public function __destruct() {

   }

}
