<form action="/adminsc/report/filter" method="post" class="product-filter">

    <select name="instore" id="instore">
        <option value="">По наличию</option>
        <option value="instore">в наличии</option>
        <option value="notinstore">не в наличии</option>
    </select>

<!--    <select name="mainImg" id="main-image">-->
<!--        <option value=""></option>-->
<!--        <option value="with-img">c картинкой</option>-->
<!--        <option value="no-img">без картинки</option>-->
<!--    </select>-->

    <select name="baseIsShippable" id="base-is-shippable">
        <option value="">Отгружаемость</option>
        <option value="1">базовая = отгружаемой</option>
        <option value="0">базовая <> отгружаемой</option>
    </select>

    <select name="deleted" id="deleted">
        <option value="">Удаленные</option>
        <option value="20" selected>С удаленнми</option>
        <option value="40">Без удаленных</option>
    </select>

    <select name="take" id="take">
        <option value="">Все</option>
        <option value="20">выбрать 20</option>
        <option value="40">выбрать 40</option>
    </select>

    <button class="btn btn-primary" type="submit">Фильтровать</button>
</form>

<?=$productList;?>

