<?
ob_start();

use app\core\Icon;
use app\view\Property\PropertyFormView;


?>
    <div class="properties" custom-list>

        <div class="column">
            <div class="title">Свойства</div>

            <div class="head">
                <div class="name">Свойство</div>

                <div class="del"><?= Icon::trashIcon() ?></div>
                <div class="edit"><?= Icon::edit() ?></div>
            </div>

            <div class="rows">
                <div class="none">
                    <div class="row">
                        <?= PropertyFormView::newPropertySelector($category); ?>
                        <div class="del">X</div>
                        <div class="edit"><?= Icon::edit() ?></div>
                    </div>
                </div>
                <? foreach ($category->properties as $property): ?>
                    <div class="row">
                        <?= PropertyFormView::selector($category, $property) ?>
                        <div class="del">X</div>
                        <div class="edit"><?= Icon::edit() ?></div>
                    </div>
                <? endforeach; ?>
            </div>

            <div class="add-property">+</div>

        </div>
    </div>
<? return ob_get_clean(); ?>