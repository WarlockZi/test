<? use app\view\widgets\Accordion\Accordion;

$models = \app\model\Test::findAll();

$menu = new Accordion([
	'model' => new \app\model\Test,
	'models' => $models,
	'parentFieldName' => 'parent',
	'class' => 'test-edit',
	'label_after' => ICONS . "/edit.svg",
	'link' => '/adminsc/question/edit/',
	'link_label_after' => '/adminsc/test/edit/',

]);
echo $menu->output(); ?>

