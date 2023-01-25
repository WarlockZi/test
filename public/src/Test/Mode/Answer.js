import {$} from '../../common'
import Model from "./Model";

class Answer extends Model {

  constructor(target) {
    super()

    this.name = 'answer'
    this.className = '.answer'
    this.emptySelector = '.empty .answer'
    this.questionSelector = '.question-edit'
    this.questionsSelector = '.questions'

    this.answerSelector = '.text'
    this.correct_answerSelector = 'input'
    this.sortSelector = '.sort'
    this.picaSelector = ''

    this.model = {}
    this.target = target
    this.row =
      target.closest(this.className) ??
      target.closest(this.questionsSelector).querySelector(this.emptySelector)

    this.fullfill()

    return this
  }

  fullfill() {
    let el = this.getEl()
    debugger
    this.model.id = this.getId() ?? 0
    this.model.answer = $(el).find(this.answerSelector).innerText.trim()?? ''
    this.model.question_id = this.getQuestion_id() ?? null
    this.model.correct_answer = +$(el).find(this.correct_answerSelector).checked ?? 0
    this.model.pica = null
  }


  find(id) {
    debugger
    let el = this.getElById(id)
    this.model.id = id;
    this.model.answer = $(el).find(this.answerSelector).innerText
    this.model.question_id = this.question.dataset.id
    this.model.correct_answer = +$(el).find(this.correct_answerSelector).checked
    this.model.pica = null
    return this
  }

  get delDomSelector() {
    return `.answer[data-id='${this.id}']`
  }

  get sort() {
    return this.question.querySelectorAll(this.className).length + 1 ?? null
  }

  get question() {
    if (this.target) return this.target.closest(this.questionSelector)
    return null
  }

  getQuestion_id() {
    return this.target.closest(this.questionSelector).dataset.id
  }

  async create() {
    debugger
    await this.createOnServer()
    this.render()
  }

  async createOnServer() {
    let res = await super.updateOrCreate()
    this.id = res.arr.id
  }

  render() {
    let empty = this.empty
    $(empty).find('.sort').innerText = this.sort
    empty.dataset.id = this.id
    this.target.before(empty)
  }

  async update() {
    let answer = this.getEl()
    let res = await super.updateOrCreate(answer.model)
  }

}

export default function answer(target) {
  return new Answer(target)
}