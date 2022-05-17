<? use app\view\widgets\Accordion\Accordion;

$models = \app\model\Test::findAllWhere('enable', '1');

$menu = new Accordion([
	'models' => $models,
	'parentFieldName' => 'parent',
	'class' => 'test-edit',
	'label_after' => ICONS . "/edit.svg",
	'link' => '/adminsc/test/edit/',
	'$link_label_after' => '/adminsc/test/update/',

]);
echo $menu->output(); ?>

