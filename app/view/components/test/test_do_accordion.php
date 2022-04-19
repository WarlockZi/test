<? use app\view\widgets\Accordion\Accordion;

$menu = new Accordion([
	'sql' => "SELECT * FROM test WHERE `enable`=1",
	'class' => 'accordion test-edit',
	'label_after' => "",
	'link' => "/adminsc/test/do/",

]);
echo $menu->output(); ?>