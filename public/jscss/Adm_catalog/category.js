$(function () {

    function obj(action) {
        return {
            token: $('#token').val(),
            url: '/adminsc',
            model: 'category',
            table: 'category',
            action: action ? action : 'update',
            pkey: 'id',
            pkeyVal: 'nul',
            values: {}
        }
    }
    ;
// изменение  / добавление названия значения 
    $('.category-update-btn').on('click', function () {

        var Obj = new obj('update');
        Obj.pkeyVal = $('#id').text();

        Obj.values.name = $('#name').text();
        Obj.values.alias = $('#alias').text();
        Obj.values.title = $('#title').text();
        Obj.values.keywords = $('#keywords').text();
        Obj.values.description = $('#description').text();
        Obj.values.core = $('#core').text();
        Obj.values.text = $('#text').text();
        var props = $('.properties select option:selected');
//      debugger;
        var prop = [];

        for (let val of props) {
            if (val.value)
                prop.push(val.value);
        }
        prop = uniq(prop);
        Obj.values.props = prop.join(',');
//      debugger;
        setTimeout(function () {
            post(Obj.url, Obj)
        }, 800);
    });



// создание нового селекта
    $('.properties.column').on('change', '.new-prop', function () {
        let val = $(this).find('option:selected').val();
        let clone = $(this).clone(true);
        $(this).removeClass('new-prop');
        $(clone).find('option[value = ' + val + ']').remove();
//      debugger;
        $('.properties.column option[value= ' + val + ']').not($(this).find('option:selected')).remove();
        $(clone).insertBefore($('.add-property'));
    });
    
// создание нового селекта
    $('.properties.column').on('change', '.new-prop', function () {
        let val = $(this).find('option:selected').val();
        let clone = $(this).clone(true);
        $(this).removeClass('new-prop');
        $(clone).find('option[value = ' + val + ']').remove();
//      debugger;
        $('.properties.column option[value= ' + val + ']').not($(this).find('option:selected')).remove();
        $(clone).insertBefore($('.add-property'));
    });

});
