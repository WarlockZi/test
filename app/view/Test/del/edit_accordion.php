<?
use app\view\widgets\Accordion\Accordion;
use \app\model\Test;

$menu = new Accordion([
	'model' => Test::class,
	'models' => Test::all()->toArray(),
	'parentFieldName' => 'test_id',
	'class' => 'test-edit',
	'label_after' => ICONS . "/edit.svg",
	'link' => '/adminsc/question/edit/',
	'link_label_after' => '/adminsc/test/edit/',

]);
echo $menu->html; ?>

