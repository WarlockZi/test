<?php

namespace app\service\ImageService;

interface IImage
{
    public function setCompressionQuality();

    public function resizeImage();

    public function writeImage();

    public function getImageHeight();

}
