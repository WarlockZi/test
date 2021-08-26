import '../normalize.scss'
import {validate} from "../common";

// import '../components/test-pagination/test-pagination'

import '../components/header/header'
import '../components/footer/footer.scss'

import './test-edit.scss'
import './show'
import '../Test/test_edit_theme_2'
import '../Admin/admin.scss'

import '../components/popup.scss'
import {$, tooltip} from '../common'
import {_question} from "./model/question";

// Default SortableJS
import Sortable from 'sortablejs';

let el = $('.questions').el[0];
let sortable = Sortable.create(el, {
    animation: 150,
    onEnd: function (/**Event*/evt) {
        debugger
        evt.oldIndex;  // element's old index within old parent
        evt.newIndex;  // element's new index within new parent

    },
});

let questions = $('.questions>.question-edit').el
if (!questions.length) {
    _question.showFirst()
}

$('.question__text').on('click', function (e) {
    let text = e.target
    let parent = text.parentNode.parentNode
    let answers = $(parent).find('.question__answers')
    answers.classList.toggle('height')
    answers.classList.toggle('scale')

    text.classList.toggle('rotate')
})

// check('/image/create')

///// question sort input validate
$('.question__sort').on('change', validate.sort)



