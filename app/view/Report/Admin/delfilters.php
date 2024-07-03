<form action="/adminsc/report/filter" method="post" class="list-filter">

    <div class="filter">
        <div class="title">По наличию</div>
        <select name="instore" id="instore">
            <option></option>
            <option value="instore">в наличии</option>
            <option value="notinstore">не в наличии</option>
        </select>
        <div class="flex">
            сохранять

            <input type="checkbox" id="">
        </div>
    </div>


    <div class="filter">
        <div class="title">Отгружаемость</div>
        <select name="baseIsShippable" id="base-is-shippable">
            <option value=""></option>
            <option value="1">базовая = отгружаемой</option>
            <option value="0">базовая <> отгружаемой</option>
        </select>
    </div>

    <div class="filter">
        <div class="title">Удаленные</div>
        <select name="deleted" id="deleted">
            <option></option>
            <option value="1" selected>С удаленными</option>
            <option value="0">Без удаленных</option>
        </select>
    </div>
    <div class="filter">
        <div class="title">В матрице</div>
        <select name="inmatrix" id="inmatrix">
            <option></option>
            <option value="1" selected>В матрице(*)</option>
            <option value="0">Не в матрице</option>
        </select>
    </div>
    <div class="filter">
        <div class="title">Картинка</div>
        <select name="image" id="image">
            <option></option>
            <option value="1">С картинкой</option>
            <option value="0">Без картинки</option>
        </select>
    </div>
    <div class="filter">
        <div class="title">Количество</div>
        <select name="take" id="take">
            <option></option>
            <option value="20" selected>выбрать 20</option>
            <option value="40">выбрать 40</option>
        </select>
    </div>

    <div class="filter">
        <div class="title">Категория</div>
        <?= \app\Repository\CategoryRepository::reportProductSelector(); ?>
    </div>

    <button class="btn btn-primary" type="submit">Фильтровать</button>
</form>
