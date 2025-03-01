<?php

namespace app\Services\ImageService;

interface IImage
{
public function setCompressionQuality();
public function resizeImage();
public function writeImage();
public function getImageHeight();

}
