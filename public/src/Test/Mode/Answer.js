import {$, post, trimStr} from '../../common'
import Model from "./Model";

export default class Answer extends Model {

  constructor() {
    super()

    this.name = 'answer'
    this.className = '.answer'
    this.emptySelector = '.empty .answer'
    this.questionSelector = '.question-edit'

    this.answerSelector = '.text'
    this.correct_answerSelector = 'input'
    this.picaSelector = ''

    this.model = {}
    this.model.id = 0
    this.model.answer = null
    this.model.question_id = null
    this.model.correct_answer = null
    this.model.pica = null

    this.target = null
  }

  find(id) {
    if (!id) return false
    let el = $(this.className).filter(
      (el) => {
        return el.dataset.id === id
      })[0];
    this.model.id = id;
    debugger
    this.model.answer = $(el).find(this.answerSelector).innerText
    this.model.question_id = this.question.dataset.id
    this.model.correct_answer = +$(el).find(this.correct_answerSelector).checked
    this.model.pica = null
    return this
  }

  getId(target) {
    return target.closest(this.className).dataset.id
  }

  get delDomSelector() {
    return `.answer[data-id='${this.id}']`
  }

  get empty() {
    return $(this.emptySelector)[0].cloneNode(true)
  }

  get sort() {
    return this.question.querySelectorAll(this.className).length + 1 ?? null
  }

  get question() {
    if (this.target) return this.target.closest(this.questionSelector)
    return null
  }

  getQuestion_id(target) {
    return target.closest(this.questionSelector).dataset.id
  }

  async create(target) {
    this.target = target
    await this.createOnServer()
    this.render()
  }

  async createOnServer() {
    this.model.question_id = this.getQuestion_id(this.target)
    let res = await super.createOnServer(this.model)
    this.id = res.arr.id
  }

  render() {
    let empty = this.empty
    $(empty).find('.sort').innerText = this.sort
    empty.dataset.id = this.id
    this.target.before(empty)
  }

  async update(target) {
    this.target = target
    let answer = this.find(this.getId(target))
    let res = await super.updateOrCreate(answer.model)
  }

}