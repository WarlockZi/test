<?php

namespace app\model;


class Image extends Model
{
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


	public function imagesave($image_type = 'jpeg', $image_file = NULL, $image_compress = 100, $image_permiss = '')
	{
		if ($image_file == NULL) {
			if ($image_type === 'gif') {
				header("Content-type: image/gif");
			} elseif ($image_type === 'jpeg') {
				header("Content-type: image/jpeg");
			} elseif ($image_type === 'png') {
				header("Content-type: image/png");
			} elseif ($image_type === 'webp') {
				header("Content-type: image/webp");
			}
		}

		if ($image_type === 'gif') {
			imagegif($this->image, $image_file);
		} elseif ($image_type === 'jpeg') {
			imagejpeg($this->image, $image_file, $image_compress);
		} elseif ($image_type === 'png') {
			imagepng($this->image, $image_file);
		} elseif ($image_type === 'webp') {
			imagewebp($this->image, $image_file);
		}

		if ($image_permiss) {
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


	public function uploadIMG($alias, $sub, $isOnly, $file, $sizes)
	{
		$arr = extract($this->getImgParams());
		$fname = substr($file['name'], 0, strlen($file['name']) - 4);
		foreach ($sizes as $size) {
			if (!$size) {
				$ps = $this->createImgPaths($alias, $fname, null, null, $isOnly);
				move_uploaded_file($file['tmp_name'], $ps['to']);
			} else {
				$toExt = $quality = $ps = '';
				$pX = $this->createImgPaths($alias, $fname, $size, $toExt, $isOnly);
				$new_image = new picture($ps['to']);
				$new_image->autoimageresize($size, $size);
				$new_image->imagesave($toExt, $pX['to'], $quality, 0777);
			}
		}
		return $pX['rel'];
	}

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
		$types = [
			1 => 'gif',
			2 => 'jpeg',
			3 => 'png',
			4 => 'swf',
			5 => 'psd',
			6 => 'bmp',
			7 => 'tiffi',
			8 => 'tiffm',
			9 => 'jpc',
			10 => 'jp2',
			11 => 'jpx',
			12 => 'jb2',
			13 => 'swc',
			14 => 'iff',
			15 => 'wbmp',
			16 => 'xbm',
			17 => 'ico',
		];

		$this->image_type = $types[$image_info] ?? null;
	}

}
