<? use app\view\widgets\Accordion\Accordion;

$menu = new Accordion([

	'model' => new \app\model\Test,
	'models' => \app\model\Test::findAllWhere('enable', 1),
	'class' => 'test-edit',
	'label_after' => "",
	'link' => "/adminsc/test/do/",
	'parentFieldName'=>'parent',

]);
echo "<div class='accordion_wrap'>".
	$menu->output().
	"</div>";
; ?>