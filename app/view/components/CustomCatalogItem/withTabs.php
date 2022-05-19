<div class="item_header">

	<div class="tabs_wrap">
    <? include ROOT . '/app/view/components/CustomCatalogItem/tabs.php' ?>
		<div class="page-title"><?= $this->pageTitle ?></div>
	</div>
</div>


<div class="item_content">

	<section class="show" data-id="1">

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
          <?= $data['html']; ?>

        <? elseif (in_array($data['data-type'], ['radio'])): ?>
          <?= $data['html']; ?>

        <? elseif (in_array($data['data-type'], ['date'])): ?>
          <?= $data['html']; ?>
        <? endif; ?>
			</div>
    <? endforeach; ?>
	</section>


  <? $n = 2; ?>
  <? foreach ($this->tabs as $k => $tab): ?>
		<section
				tab
				data-field="<?=$tab['field'];?>"
				data-id=<?= $n ?>>
				<?=$tab['html'];?>
		</section>
    <? $n++; ?>
  <? endforeach; ?>

<!--	<div class="buttons_wrap">-->
    <? include ROOT . '/app/view/components/CustomCatalogItem/buttons.php' ?>
<!--	</div>-->

</div>
