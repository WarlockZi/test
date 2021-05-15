window.onload = function () {

    switch (window.location.pathname) {
        case '/adminsc/catalog':
        case '/adminsc/catalog/category':
        case '/adminsc/catalog/product':
        case '/adminsc/catalog/products':
            document.querySelector('.module.catalog').classList.add('activ')
            break;
        case '/adminsc/crm':
        case '/adminsc/crm/users':
            document.querySelector('.module.crm').classList.add('activ')
            break;
        case '/adminsc/settings':
        case '/adminsc/Sitemap':
        case '/adminsc/settings/pics':
        case '/adminsc/settings/prop':
        case '/adminsc/settings/props':
            document.querySelector('.module.settings').classList.add('activ')
            break;
        case '/adminsc':
            document.querySelector('.module.home').classList.add('activ')
            break;
    }

    function clearCache() {
        async function clearCache() {
            let response = await fetch('/adminsc/clearCache')
            let result = await response.text();
        }

        clearCache().catch(alert);
    }

    const uniq = (array) => Array.from(new Set(array))

}


// }


//
/////////////////////////////////
//////// PRODUCTS /////////////
///////////////////////////////

// $('.product.column, .edit::before').hover(
//     function () {
// //   debugger;
//         $(this).toggleClass('edit');
//         let id = $(this).data('id');
//         $(this).prop('href', '/adminsc/catalog/product?id=' + id);
//
//     },
//     function () {
//         $(this).toggleClass('edit');
//     }
// );



