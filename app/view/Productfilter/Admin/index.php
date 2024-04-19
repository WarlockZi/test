<form action="/adminsc/productfilter" method="POST">

    <div class="filter-containers">

        <div class="filter-container">
            <div class="filter-title">
                Единицы :
            </div>
            <select name="units" id="units">
                <option value="0"></option>
                <option value="no_base_unit">Без базовой единицы</option>
                <option value="no_dop_units">Без доп единиц</option>
            </select>
        </div>
        <div class="filter-container">
            <div class="filter-title">
                Основная картинка :
            </div>
            <select name="main_image" id="main_image">
                <option value="0"></option>
                <option value="no_main_image">Без основной картинки</option>
                <option value="with_main_image">С основной картинкой</option>
            </select>
        </div>
        <div class="filter-container">
            <div class="filter-title">
                Наличие :
            </div>
            <select name="instore" id="instore">
                <option value="0"></option>
                <option value="instore">В наличии</option>
                <option value="not_instore">Не в наличии</option>
            </select>
        </div>

    </div>
    <button type="submit" class="submit">Искать</button>
</form>
