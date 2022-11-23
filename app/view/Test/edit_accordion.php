<? use app\view\widgets\Accordion\Accordion;

$menu = new Accordion([
	'model' => \app\model\Illuminate\Test::class,
	'models' => \app\model\Illuminate\Test::all()->toArray(),
	'parentFieldName' => 'parent',
	'class' => 'test-edit',
	'label_after' => ICONS . "/edit.svg",
	'link' => '/adminsc/question/edit/',
	'link_label_after' => '/adminsc/test/edit/',

]);
echo $menu->html; ?>

