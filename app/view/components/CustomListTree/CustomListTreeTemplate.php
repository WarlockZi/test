<div class="custom-list-tree__wrapper">
	<select class="custom-list-tree">

		 <? if ($this->initialOption): ?>
		  <option value=""></option>
		 <? endif; ?>


		 <?= isset($item['childs']) ? '<li class = "sub">' : '<li>' ?>
		<option value="<?= $item['id'] ?>">
		  <?= $item['test_name'] ?>
		</option>
		 <? if (isset($item['childs'])): ?>
		  <ul>
					<?= $this->getMenuHtml($item['childs']); ?>
		  </ul>
		 <? endif ?>
		</li>

	</select>

</div>
