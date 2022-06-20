<? use app\view\widgets\Accordion\Accordion;

$models = \app\model\Test::findAll();

$menu = new Accordion([
	'model' => new \app\model\Test,
	'models' => $models,
	'parentFieldName' => 'parent',
	'class' => 'test-edit',
	'label_after' => ICONS . "/edit.svg",
	'link' => '/adminsc/test/edit/',
	'link_label_after' => '/adminsc/test/update/',

]);
echo $menu->output(); ?>

