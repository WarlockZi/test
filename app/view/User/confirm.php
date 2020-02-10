<section>

    <div class="wrap">


            <a class="list" href="/user/edit" >Редактировать свой профиль</a>

            <? if (in_array('2', $rightId)): ?>
                <a class="list" href="<?= PROJ ?>/1">Проходить закрытые тесты</a>
            <? endif; ?>

            <? if (in_array('2', $rightId)): ?>
                <a class="list" href="<?= PROJ ?>/Freetest/1">Проходить открытые тесты</a>
            <? endif; ?>
    </div>



</section>