<div class="tabs">

<div class="tabs-header">

	<!--TABS-->
	<div data-id="1"
	     class="tab active"
	     data-tooltip="Основное">Основное
	</div>
	<? $n = 2; ?>
	<? foreach ($this->tabs as $k=>$tab): ?>
	  <div data-id="<?= $n; ?>"
	       class="tab"
	       data-tooltip="<?= $k; ?>"><?= $k; ?></div>
		<? $n++; ?>
	<? endforeach; ?>

	<!--  BUTTONS  -->
	<div class="custom-catalog-item__buttons">

		 <? if ($this->delBttn): ?>
		  <div class="del">
					<? include TRASH ?>
		  </div>
		 <? endif; ?>

		 <? if ($this->saveBttn): ?>
		  <div class="save">
					<? include SAVE ?>
		  </div>
		 <? endif; ?>

		 <? if ($this->toListBttn): ?>
		  <a href="/adminsc/<?= $this->modelName; ?>/list"
		     class="to-list">
			  К списку
		  </a>
		 <? endif; ?>

	</div>
</div>

	<!--CONTENT-->
	<section class="show" data-id="1">
		<div class="custom-catalog-item"
		     data-table="<?= $this->tableClassName ?>"
		     data-model="<?= $this->modelName ?>"
		     data-id="<?= $this->item['id'] ?>"
		>


			<!--  TABLE  -->
				<? foreach ($this->fields as $fieldName => $data): ?>
			  <div class="row">
				  <div class="field"><?= $data['name'] ?></div>
				  :

						 <? if (in_array($data['data-type'], ['string', 'number'])): ?>
					 <div class="value"
									<?= $data['contenteditable']; ?>
									<?= "data-field={$fieldName}"; ?>>
									<?= $this->item[$fieldName] ?>
					 </div>
						 <? elseif (in_array($data['data-type'], ['select', 'multiselect'])): ?>
							 <?= $data['select']; ?>

						 <? elseif (in_array($data['data-type'], ['radio'])): ?>
							 <?= $data['html']; ?>

						 <? elseif (in_array($data['data-type'], ['date'])): ?>
							 <?= $data['html']; ?>
						 <? endif; ?>

			  </div>

				<? endforeach; ?>

		</div>
	</section>


	<? $n = 2; ?>
	<? foreach ($this->tabs as $k => $tab): ?>
	  <section data-id=<?=$n?>>
			 <?= $tab; ?>
	  </section>
		<? $n++; ?>
	<? endforeach; ?>

</div>