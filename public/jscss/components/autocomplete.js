// import {get} from "../common";
var result = document.querySelector('.result-search');
var Arr = ['HTML', 'CSS', 'PHP', 'Javascript', 'Dart', 'Python', 'Swift', 'Java', 'C++', 'Go', 'SASS', 'C#', 'LESS', 'Perl', 'Ruby']

// auto complete function
async function autoComplete(Arr, Input) {

    let response = await fetch('/search?q=' + Input);
    return await response.json();

}

export default window.getValue = async function (val) {

    // if no value
    if (!val) {
        result.innerHTML = '';
        return
    }

    // search goes here
    var data = await autoComplete(Arr, val);
    debugger;

    // append list data
    var res = '<ul>';
    data.forEach(e => {
        res += '<li>' +
            `<a href = '${e.url}'>`+
            `<img src='/pic/${e.pic}' alt='${e.value}'>`+
            e.value+
            '</a></li>';
    })
    res += '</ul>';
    result.innerHTML = res;
}


