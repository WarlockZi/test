$(function () {

    function obj(self, action, pkey = 'id', pkeyVal) {
        return {
            token: $('#token').val(),
            url: '/adminsc',
            model: 'prop',
            table: 'props',
            action: action ? action : 'update',
            pkey: pkey,
            pkeyVal: pkeyVal ? pkeyVal : $(self).parent().parent().parent().data('prop'),
            values: {}
    }
    }
    ;

// изменение названия свойства / добавление
    $('.property-block').on('input', '.property input', function () {
        debugger;

        var name = this.value,
            name = name.trim(),
            id = $(this).parent().data('prop')
            ;

        var self = this;
        var Obj = new obj(self, 'update','id',id);
        Obj.values.name = name;
        if(this.parentNode.classList.contains('new')){
            var clone = this.cloneNode(true);
            var parent = this.parentNode;
            var el = this.parentNode.querySelector('.new');
            parent.insertBefore(clone,el);
            this.classList.remove('');
        };
        
//        debugger;

        setTimeout(function () {
            post(Obj.url, Obj)
        }, 800);
    });

    $('select.type').on('change', function () {
//        debugger;
        var selected = this[this.selectedIndex];
        var self = this;
        var Obj = new obj(self, 'update');
        Obj.values.type = selected.value;
//        debugger;
        post(Obj.url, Obj);

    })
// добавление значения 
    $('.property-block').on('input', '.value, .add-prop-val', function (event) {

        var url = '/adminsc',
            val = $(this).text(),
            id = $(this).parent().parent().parent().data('prop'),
            str = $(this).parent().find('span'),
            val = '',
            vals = new Set(str),
            dd = [];

        vals.forEach(function (item, same, set) {
            if (item.innerText)
                dd.push(item.innerText);
        });

        val = dd.join(',').trim(',');

            debugger;
        if (this.classList.contains('add-prop-val')) {
            var clone = this.cloneNode(true);
            clone.innerHTML = '';
            this.classList.remove('add-prop-val');
            var el = this.parentNode.querySelector('.new');
            var parent = this.parentNode;
            parent.insertBefore(clone, el);
        }

//        if (!val&&!'')
//            return false;

        var data = {
            token: $('#token').val(),
            model: 'prop',
            action: 'update',
            table: 'props',
            pkey: 'id',
            pkeyVal: id,
            values: {
                val: val,
            }
        };
        post(url, data);

    });




});