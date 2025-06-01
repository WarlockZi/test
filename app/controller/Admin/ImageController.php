<?php

namespace app\controller\Admin;

use app\model\Image;
use app\repository\ImageRepository;
use app\service\Response;
use app\view\Image\ImageView;

class ImageController extends AdminscController
{
    public string $model = Image::class;

    public function __construct()
    {
        parent::__construct();
    }

    public function actionIndex(): void
    {
        $list = ImageView::index();
        $this->setVars(compact('list'));
    }

    public function actionDetach(): void
    {
        if ($post = $this->ajax) {
            $morphedClass = '\app\model\\' . ucfirst($post['morphedType']);
            $morphed      = $morphedClass::find($post['morphedId']);
            $relation     = $morphed->getTable();

            Image::find($post['morphId'])
                ->$relation()
                ->wherePivot('slug', $post['slug'])
                ->detach($morphed->id);

            response()->json(['success' => 'ok']);
        }
    }


    public function actionAttachMany()
    {
        if (!$_POST) Response::exitWithPopup('нет данных');
        if (!$_FILES) Response::exitWithPopup('нет файлов');
        $morphed = $_POST['morphed'];
        $morph   = $_POST['morph'];
        $images  = [];

        foreach ($_FILES as $file) {
            ImageRepository::validate($file);

            $image = ImageRepository::firstOrCreate($file, $morph);
            if ($image->wasRecentlyCreated) {
                ImageRepository::saveToFile($image, $file);
            }
            $images[] = $image;
        }

        $srcs = ImageRepository::sync($images, $morphed, $morph['slug'], 'many', false);
        if ($srcs) {
            response()->json($srcs);
        }
        Response::exitWithPopup("Уже есть");
    }

    public function attachOne()
    {
        if (!$_POST) Response::exitWithPopup('нет данных');
        if (!$_FILES) Response::exitWithPopup('нет файлов');
        $morphed = $_POST['morphed'];
        $morph   = $_POST['morph'];

        if (count($_FILES) > 1) Response::exitWithPopup('Можно только один файл');
        $file = $_FILES[0];

        ImageRepository::validateSize($file);
        ImageRepository::validateType($file);

        $image = ImageRepository::firstOrCreate($file, $morph);
        if ($image->wasRecentlyCreated) {
            ImageRepository::saveToFile($image, $file);
        }

        $res = ImageRepository::sync($image, $morphed, $morph['slug'], 'one', true);
        if ($res) {
            response()->json($res);
        }
        Response::exitWithPopup("Уже есть такая картинка");

    }
}
