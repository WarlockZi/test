<? use app\view\widgets\Accordion\Accordion;

$menu = new Accordion([
	'model' => 'test',
	'class' => 'accordion test-edit',
	'label_after' => ICONS . "/edit.svg",
	'link' => '/adminsc/test/update/',

]);
echo $menu->output(); ?>

