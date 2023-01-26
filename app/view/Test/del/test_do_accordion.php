<?

use app\view\widgets\Accordion\Accordion;
use \app\model\Test;

$menu = new Accordion([

  'models' =>
    Test::where('enable', 1)
      ->where('test_id', 0)
      ->with('childrenRecursive')
      ->get()
      ->toArray(),
  'class' => 'test-edit',
  'label_after' => "",
  'link' => "/test/do/",
  'parentFieldName' => 'test_id',

]);
?>
<div class='accordion_wrap'>
  <?= $menu->html ?? ''; ?>
</div>
