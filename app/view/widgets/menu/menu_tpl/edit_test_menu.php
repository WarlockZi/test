<?= isset($cat['childs']) ? '<li class = "vert-menu__list">' : '<li>' ?>

<div class="test-params" data-testid="<?= $cat['id'] ?>">
  <svg version="1.1" xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16">
    <path fill="#fff" d="M1 3h14v2h-14zM1 7h14v2h-14zM1 11h14v2h-14z"></path>
  </svg>
</div>
<a href=
<?= isset($cat['childs']) ? "#" : PROJ . "/test/edit/" . $cat['id'] ?>
   ><?= $cat['test_name'] ?>
</a>
<? if (isset($cat['childs'])): ?>
    <ul class = "vert-menu__drop">
      <?= $this->getMenuHtml($cat['childs']); ?>
    </ul>
<? endif ?>
</li>