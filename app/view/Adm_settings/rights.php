<div class="adm-content">

	<div class="rights-table">
		<div class="right head">
			<div class="id">ID</div>
			<div class="name">Наименование</div>
			<div class="description">Описание</div>
			<div>Save</div>
			<div>Delete</div>
		</div>

<?foreach($rights as $right):?>
	<div class="right">
		<div class="id"><?=$right['id']?></div>
		<div class="name" contenteditable><?=$right['name']?></div>
		<div class="description" contenteditable><?=$right['description']?></div>
		<div class="save">Save</div>
		<div class="del">Delete</div>
	</div>
<?endforeach;?>
		<div class="right">
			<div class="id"></div>
			<div class="name" contenteditable></div>
			<div class="description" contenteditable></div>
			<div class="save">Save</div>
			<div class="del">Delete</div>
		</div>
	</div>



</div>