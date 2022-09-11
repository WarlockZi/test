<? use app\view\widgets\Accordion\Accordion;

$menu = new Accordion([

	'model' => \app\model\Illuminate\Test::class,
	'models' => \app\model\Illuminate\Test::where('enable', 1)->get()->toArray(),
	'class' => 'test-edit',
	'label_after' => "",
	'link' => "/adminsc/test/do/",
	'parentFieldName'=>'parent',

]);
echo "<div class='accordion_wrap'>".
	$menu->output().
	"</div>";
; ?>