<div class="filter-wrap">
    <div class="filter-badge-title">Фильтры</div>
        <?= $filterService->getFilterPanel(); ?>
</div>
<?= $filterService->getUserFilterString(); ?>
<?= $productsTable; ?>
