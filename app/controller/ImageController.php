<?php

namespace app\controller;

use app\model\Image;
use app\Repository\ImageRepository;
use app\view\Image\ImageView;

class ImageController extends AppController
{
  public $model = Image::class;

  public function __construct(array $route)
  {
    parent::__construct($route);
  }

  public function actionIndex()
  {
    $list = ImageView::list();
    $this->set(compact('list'));
  }

  private static function checkRequiredArgs(array $args, Controller $context): array
  {
    if (isset($args['morphed_type']))
      $context->exitWithPopup('Нет смежной таблицы');
    if (isset($args['morphed_id']))
      $context->exitWithPopup('Нет id из смежной таблицы');
    if (isset($args['morph_id']))
      $context->exitWithPopup('Нет id картинки');
    return [$args['morphed'], $args['morph']];
  }

  public function actionAddMorph()
  {
    if (!$_POST) $this->exitWithPopup('нет данных');
    if (!$_FILES) $this->exitWithPopup('нет файлов');
    [$morphed, $morph] = self::checkRequiredArgs($_POST, $this);

    foreach ($_FILES as $file) {
      ImageRepository::fileValidate($file);
      $hash = hash_file('md5', $file['tmp_name']);
      $ext = ImageRepository::getExt($file['type']);
      if (!$ext) continue;

      $im = Image::where('hash', $hash)
        ->where('size', $file['size'])
        ->first();
      if (!$im) {
        ImageRepository::saveIfNotExist($file, $morphed['type']);
      }
      $modelNameSpace = 'app\\model\\';
      $modelName = $modelNameSpace . ucfirst($morphed['type']);
      $model = $modelName::find($morphed['id']);
      $function = $morphed['type'];
      $im->$function()->sync($model);
    }
    exit();
  }

}
