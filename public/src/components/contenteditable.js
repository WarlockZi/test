import {$, popup, post} from '../common'

export default function contenteditable() {
  let customList = $('.custom-list')[0]
  let contenteditable = $('[contenteditable]')

  const debouncedHandle =
    debounce(handleInput.bind(null, customList, contenteditable), 1000);

  if (customList && contenteditable) {
    $(customList).on('keyup', debouncedHandle)
    $(customList).on('blur', handleInput.bind(null, customList, contenteditable))
  }

  function handleInput(customList, contenteditable, e) {
    let el = e.target
    let modelName = customList.dataset['model']
    let model = makeServerModel(el, modelName)
    // let isContEditable = $(contenteditable).find(el)
    // if (isContEditable) {
      save(model)
    // }
  }

  async function save(model) {
    let url = `/adminsc/${model.modelName}/update`
    let res = await post(url, model.model)
    res = JSON.parse(res)
    if (res.msg === 'updated') {
      popup.show('Сохранено!')
    }
  }

  function debounce(callee, timeoutMs) {
    return function perform(...args) {
      let previousCall = this.lastCall;
      this.lastCall = Date.now();
      if (previousCall && this.lastCall - previousCall <= timeoutMs) {
        clearTimeout(this.lastCallTimer);
      }
      this.lastCallTimer = setTimeout(() => callee(...args), timeoutMs);
    };
  }

  function makeServerModel(el, modelName) {
    let field = el.dataset['field']
    return {
      model: {
        token: $(),
        id: el.dataset.id,
        [field]: el.innerText
      },
      modelName
    }
  }
}

