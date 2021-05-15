
$('.product.column, .edit::before').hover(
    function () {
//   debugger;
        $(this).toggleClass('edit');
        let id = $(this).data('id');
        $(this).prop('href', '/adminsc/catalog/product?id=' + id);

    },
);

$('.breadcrumbs').on('click',
    function (e) {
        var el = e.target,
            attr = el.getAttribute('data-id')


        if (attr) {
            if (el.href) {
                el.href = '/adminsc/catalog/category?id=' + el.getAttribute('data-id');

            } else {
                window.location = '/adminsc/catalog/category?id=' + el.getAttribute('data-id');
            }
        }
    }
)






