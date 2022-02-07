<div class="adm-content">

	<div class="rights-table">

			<div class="id head">ID</div>
			<div class="name head">Наименование</div>
			<div class="description head">Описание</div>
			<div class="head"></div>
			<div class="head"></div>


<?foreach($rights as $right):?>
<?$data = 'data-id='.$right['id'];?>

		<div <?=$data?> class="id"><?=$right['id']?></div>
		<div <?=$data?> class="name" contenteditable><?=$right['name']?></div>
		<div <?=$data?> class="description" contenteditable><?=$right['description']?></div>
		<div <?=$data?> class="save">Save</div>
		<div <?=$data?> class="del">Delete</div>

<?endforeach;?>
<!--		<div class="right new">-->
			<div data-id="new" class="id"></div>
			<div data-id="new" class="name" contenteditable></div>
			<div data-id="new" class="description" contenteditable></div>
			<div data-id="new" class="save">Save</div>
			<div data-id="new" class="del">Delete</div>
<!--		</div>-->
	</div>



</div>