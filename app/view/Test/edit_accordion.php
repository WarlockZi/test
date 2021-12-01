<? use app\view\widgets\Accordion\Accordion;

$menu = new Accordion([
	'model' => 'test',
	'class' => 'accordion',
]);
echo $menu->output();
?>