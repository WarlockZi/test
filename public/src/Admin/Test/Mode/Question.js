import {$} from '../../../common.js'
import Model from "./Model.js";

class Question extends Model {

  constructor(target = null) {
    super()

    this.name = 'question'
    this.className = '.question-edit'
    this.emptySelector = '.empty .question-edit'

    this.testSelector = '.questions[data-test-id]'
    this.sortSelector = '.sort'
    this.textSelector = '.text'
    this.picqSelector = ''

    this.model = {}
    this.row =
      target.closest(this.className)??
      target.parentNode.querySelector(this.emptySelector)
    // debugger
    this.fullfill(this.row)
    this.target = target
    return this
  }

  async changeParent() {
    this.model.id = this.getId()
    let opt = this.target.options[this.target.selectedIndex]
    this.model.test_id = opt.dataset['questionParentId']

    let res = await this.updateOrCreate(this.model)
    if (res) {
      this.row.remove()
    }
  }

  showAnswers() {
    let answers = $(this.row).find('.question__answers')
    answers.classList.toggle('height')
    answers.classList.toggle('scale')
    this.target.classList.toggle('rotate')
  }

  find(id) {
    this.fullfill(this.getElById(id))
  }

  fullfill(target){
    let el = this.target = target.closest(this.className)??null
    let sort = +$(el).find(this.sortSelector).innerText>0
      ?+$(el).find(this.sortSelector).innerText
      :this.sort
    this.model.id = el.dataset.id??null
    this.model.sort = sort
    this.model.qustion = $(el).find(this.textSelector).innerText.trim()??null
    this.model.test_id = this.getTest_id()??null
    this.model.picq = null
  }

  get delDomSelector() {
    return `${this.className}[data-id='${this.id}']`
  }

  get test() {
    if (this.target) return this.target.closest(this.testSelector)
    return null
  }

  get sort() {
    return this.test.querySelectorAll(this.className).length ?? null
  }

  getTest_id() {
    if (this.target) return this.target.closest(this.testSelector).dataset.testId
    return null
  }

  async create() {
    debugger
    await this.createOnServer()
    this.render()
  }

  async createOnServer() {
    let res = await super.updateOrCreate(this.model)
    this.id = res.arr.id
  }

  render() {
    let empty = this.empty
    $(empty).find('.sort').innerText = this.model.sort
    empty.dataset.id = this.id
    this.target.before(empty)
  }

  async update() {
    let res = await super.updateOrCreate(this.model)
  }
}

export default function question(target) {return new Question(target)}