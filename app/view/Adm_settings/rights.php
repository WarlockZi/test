<div class="adm-content">

	<div class="rights-table">

			<div class="id head">ID</div>
			<div class="name head">Наименование</div>
			<div class="description head">Описание</div>
			<div class="head"></div>
			<div class="head"></div>


<?foreach($rights as $right):?>

		<div class="id"><?=$right['id']?></div>
		<div class="name" contenteditable><?=$right['name']?></div>
		<div class="description" contenteditable><?=$right['description']?></div>
		<div class="save">Save</div>
		<div class="del">Delete</div>

<?endforeach;?>
<!--		<div class="right new">-->
			<div class="id"></div>
			<div class="name" contenteditable></div>
			<div class="description" contenteditable></div>
			<div class="save">Save</div>
			<div class="del">Delete</div>
<!--		</div>-->
	</div>



</div>