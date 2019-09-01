<div class="adm-submenu">



</div>


<div class="adm-content">
    <div class="breadcrumbs-adm">
        <a href  = "/adminsc">Admin</a>
        <a href  = "/adminsc/settings">Настройки</a>
        <div>Настройка свойств</div>
    </div>

    <div class="column">
        <div class="prop-head ">

            <div class="parent-prop">Настройка свойств</div>

        </div>


        <div class="property-block">
            <input type="hidden" id="token" value="<?= $_SESSION['token'] ?>">
            <? foreach ($catProps as $key): ?>
            
                <div class="property" data-prop = '<?= $key['id'] ?>'>
                    <input size="35" type="text" value="<?= $key['name'] ?>">

                    <div class="prop">

                        <div class="val column">
                            <? foreach ($key['val'] as $k): ?>
                                <span class="value" data-id = "<?= $key['id'] ?>" contenteditable="true">
                                    <?= $k ?>
                                </span>
                            <? endforeach; ?>
                            <span class="add-prop-val value" contenteditable></span>
                            <div class="new"></div>
                        </div>

                        <div class="left-set">

                            <select class="type">
                                <option value="select"<?= $key['type'] == 'select' ? 'selected' : '' ?>>выбор одного значения</option>
                                <option value="multi"<?= $key['type'] == 'multi' ? 'selected' : '' ?>>выбор нескольких значений</option>
                                <option value="string" <?= $key['type'] == 'string' ? 'selected' : '' ?>>строка</option>

                            </select>

                        </div>

                    </div>

                </div>
            <? endforeach; ?>
                <div class="property new" data-prop = '<?= $key['id'] ?>'>
                    <input size="35" type="text" >

                    <div class="prop">

                        <div class="val column">
                            <? foreach ($key['val'] as $k): ?>
                                <span class="value" data-id = "<?= $key['id'] ?>" contenteditable="true">
                       
                                </span>
                            <? endforeach; ?>
                            <span class="add-prop-val value" contenteditable></span>
                            <div class="new"></div>
                        </div>

                        <div class="left-set">

                            <select class="type">
                                <option value="select"<?= $key['type'] == 'select' ? 'selected' : '' ?>>выбор одного значения</option>
                                <option value="multi"<?= $key['type'] == 'multi' ? 'selected' : '' ?>>выбор нескольких значений</option>
                                <option value="string" <?= $key['type'] == 'string' ? 'selected' : '' ?>>строка</option>

                            </select>

                        </div>

                    </div>

                </div>
        </div>



    </div>


    <div class="adm-save-cansel">
        <button>
            сохранить
        </button>
        <button>
            отменить
        </button>
    </div>

</div>