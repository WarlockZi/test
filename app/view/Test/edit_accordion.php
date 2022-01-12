<? use app\view\widgets\Accordion\Accordion;

$menu = new Accordion([
	'model' => 'test',
	'class' => 'accordion test-edit',
]);
echo $menu->output(); ?>

