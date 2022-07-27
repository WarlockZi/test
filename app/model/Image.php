<?php

namespace app\model;


class Image extends Model
{
	public $table = 'images';
	public $model = 'image';

	private $image_file;
	public $image;
	public $image_type;
	public $image_width;
	public $image_height;

	protected $filable = [
		'hash' => '',
		'path' => '',
		'name' => '',
		'tag' => '',
		'size' => '',
		'type' => '',
		'relatedTo' => ''
	];



	public function __construct($image_file = '')
	{
		if (!$image_file) return;
		$this->image_file = $image_file;
		$image_info = getimagesize($this->image_file);
		$this->image_width = $image_info[0];
		$this->image_height = $image_info[1];
		$this->setImageType($image_info[2]);
		$this->fotoimage();
	}

	public static function getImg($path)
	{
		if (is_readable(ROOT . $path)) {
			return $path;
		} else {
			return '/pic/srvc/nophoto-min.jpg';
		}
	}

	public function imagesave($image_type = 'jpeg', $image_file = NULL, $image_compress = 100, $image_permiss = '')
	{
		if ($image_file == NULL) {
			switch ($image_type) {
				case 'gif':
					header("Content-type: image/gif");
					break;
				case 'jpeg':
					header("Content-type: image/jpeg");
					break;
				case 'png':
					header("Content-type: image/png");
					break;
				case 'webp':
					header("Content-type: image/webp");
					break;
			}
		}
		switch ($image_type) {
			case 'gif':
				imagegif($this->image, $image_file);
				break;
			case 'jpeg':
				imagejpeg($this->image, $image_file, $image_compress);
				break;
			case 'png':
				imagepng($this->image, $image_file);
				break;
			case 'webp':
				imagewebp($this->image, $image_file);
				break;
		}
		if ($image_permiss != '') {
			chmod($image_file, $image_permiss);
		}
		imagedestroy($this->image);
	}

	protected function createImgPaths($alias, $fname, $ext, $isOnly, $rate = 800)
	{
		$ext = $ext ?: 'jpg';
		$p['filename'] = $rate ? "{$fname}-{$rate}.{$ext}" : "{$fname}.{$ext}";
		$p['group'] = $_SERVER['DOCUMENT_ROOT'] . "/pic/{$alias}/";
		$p['to'] = $p['group'] . $p['filename'];
		$p['rel'] = "{$alias}/{$fname}";
		return $p;
	}

//	public function uploadIMG($alias, $sub, $isOnly, $file,$sizes)
//	{
//		$arr = extract($this->getImgParams());
//		$fname = substr($file['name'], 0, strlen($file['name']) - 4);
//		foreach ($sizes as $size) {
//			if (!$size) {
//				$ps = $this->createImgPaths($alias, $fname, null, null, $isOnly);
//				move_uploaded_file($file['tmp_name'], $ps['to']);
//			} else {
//				$pX = $this->createImgPaths($alias, $fname, $size, $toExt, $isOnly);
//				$new_image = new picture($ps['to']);
//				$new_image->autoimageresize($size, $size);
//				$new_image->imagesave($toExt, $pX['to'], $quality, 0777);
//			}
//		}
//		return $pX['rel'];
//	}

	private function fotoimage()
	{
		if ($this->image_type === 'gif') {
			$this->image = imagecreatefromgif($this->image_file);
		} elseif ($this->image_type === 'jpeg') {
			$this->image = imagecreatefromjpeg($this->image_file);
		} elseif ($this->image_type === 'png') {
			$this->image = imagecreatefrompng($this->image_file);
		}
	}

	public function autoresize($new_w, $new_h)
	{
		$difference_w = 0;
		$difference_h = 0;
		if ($this->image_width < $new_w && $this->image_height < $new_h) {
			$this->resize($this->image_width, $this->image_height);
		} else {
			if ($this->image_width > $new_w) {
				$difference_w = $this->image_width - $new_w;
			}
			if ($this->image_height > $new_h) {
				$difference_h = $this->image_height - $new_h;
			}
			if ($difference_w > $difference_h) {
				$this->resizewidth($new_w);
			} elseif ($difference_w < $difference_h) {
				$this->resizeheight($new_h);
			} else {
				$this->resize($new_w, $new_h);
			}
		}
	}

	public function percentreduce($percent)
	{
		$new_w = $this->image_width * $percent / 100;
		$new_h = $this->image_height * $percent / 100;
		$this->resize($new_w, $new_h);
	}

	public function resizewidth($new_w)
	{
		$new_h = $this->image_height * ($new_w / $this->image_width);
		$this->resize($new_w, $new_h);
	}

	public function resizeheight($new_h)
	{
		$new_w = $this->image_width * ($new_h / $this->image_height);
		$this->resize($new_w, $new_h);
	}

	public function resize($new_w, $new_h)
	{
		$new_image = imagecreatetruecolor($new_w, $new_h);
		imagecopyresampled($new_image, $this->image, 0, 0, 0, 0, $new_w, $new_h, $this->image_width, $this->image_height);
		$this->image_width = $new_w;
		$this->image_height = $new_h;
		$this->image = $new_image;
	}

	protected function setImageType($image_info)
	{
		switch ($image_info) {
			case 1:
				$this->image_type = 'gif';
				break; //1: IMAGETYPE_GIF
			case 2:
				$this->image_type = 'jpeg';
				break; //2: IMAGETYPE_JPEG
			case 3:
				$this->image_type = 'png';
				break; //3: IMAGETYPE_PNG
			case 4:
				$this->image_type = 'swf';
				break; //4: IMAGETYPE_SWF
			case 5:
				$this->image_type = 'psd';
				break; //5: IMAGETYPE_PSD
			case 6:
				$this->image_type = 'bmp';
				break; //6: IMAGETYPE_BMP
			case 7:
				$this->image_type = 'tiffi';
				break; //7: IMAGETYPE_TIFF_II (порядок байт intel)
			case 8:
				$this->image_type = 'tiffm';
				break; //8: IMAGETYPE_TIFF_MM (порядок байт motorola)
			case 9:
				$this->image_type = 'jpc';
				break; //9: IMAGETYPE_JPC
			case 10:
				$this->image_type = 'jp2';
				break; //10: IMAGETYPE_JP2
			case 11:
				$this->image_type = 'jpx';
				break; //11: IMAGETYPE_JPX
			case 12:
				$this->image_type = 'jb2';
				break; //12: IMAGETYPE_JB2
			case 13:
				$this->image_type = 'swc';
				break; //13: IMAGETYPE_SWC
			case 14:
				$this->image_type = 'iff';
				break; //14: IMAGETYPE_IFF
			case 15:
				$this->image_type = 'wbmp';
				break; //15: IMAGETYPE_WBMP
			case 16:
				$this->image_type = 'xbm';
				break; //16: IMAGETYPE_XBM
			case 17:
				$this->image_type = 'ico';
				break; //17: IMAGETYPE_ICO
			default:
				$this->image_type = '';
				break;
		}
	}

}
