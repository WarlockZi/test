<section class="container">

        <h3>Личный кабинет</h3>

            <a class="list" href="/user/edit" >Редактировать свой профиль</a>
            <? if (in_array('3', $user['rights'])): ?>
                <a class="list" href="/adminsc">Admin</a>
            <? endif; ?>
            <? if (in_array('1', $user['rights'])): ?>
                <a class="list" href="/test/edit/1">Редактировать тесты</a></li>
            <? endif; ?>
            <? if (in_array('2', $user['rights'])): ?>
                <a class="list" href="/test/1">Проходить тесты</a>
            <? endif; ?>

</section>
<style>
    /*************************
    *******      Cabinet  ******
    **************************/
    .container{
        max-width: 500px;
        margin: 0 auto;
    }

    .wrap h3{
        margin: 5px 0;
        font-weight: bold;
        font-size: 120%;
        text-align: center;
        color: #949494;
        margin-bottom: 20px;
    }
    .wrap .list{
        display: flex;
        justify-content: flex-start;
        padding: 10px;
        /*border: 1px solid #eee;*/
    }
    .wrap .list:hover{
        background:#f6f6f6;
    }
</style>

<script src="/public/build/cabinet.js">

</script>