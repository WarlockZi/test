<? use app\view\widgets\Accordion\Accordion;

$menu = new Accordion([

	'models' => \app\model\Test::findAllWhere('enable', 1),
	'class' => 'test-edit',
	'label_after' => "",
	'link' => "/adminsc/test/do/",
	'parentFieldName'=>'parent',

]);
echo $menu->output(); ?>