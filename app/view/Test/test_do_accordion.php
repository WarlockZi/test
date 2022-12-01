<? use app\view\widgets\Accordion\Accordion;

$menu = new Accordion([

	'model' => \app\model\Test::class,
	'models' => \app\model\Test::where('enable', 1)->get()->toArray(),
	'class' => 'test-edit',
	'label_after' => "",
	'link' => "/adminsc/test/do/",
	'parentFieldName'=>'parent',

]);
?>
<div class='accordion_wrap'>
	<?=$menu->html??'';?>
</div>
