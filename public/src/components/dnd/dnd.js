import {post, $} from '../../common'

// import './dnd.scss'

export function dnd(holderClass = '', url = '', imageable_id, appendTo, replace) {

  appendTo = $(appendTo)[0]
  let holder = $(holderClass)
  let acceptedTypes = [
    'image/png',
    'image/jpeg',
    'image/gif'
  ];

  [].forEach.call(holder, function (h) {

    h.ondragenter = function (e) {
      e.preventDefault()
      this.classList.toggle('hover')
      return false
    }
    h.ondragleave = function (e) {
      e.preventDefault()
      this.classList.toggle('hover')
      return false
    }
    h.ondragover = function (e) {//без ondragover не работает drop
      e.preventDefault()
      return false;
    }
    h.ondrop = function (e) {
      e.preventDefault()
      let files = e.dataTransfer.files
      readfiles(files, imageable_id)
      previewfiles(files, this, appendTo, replace)
    }
  })

  async function readfiles(files, imageable_id) {
    let formData = new FormData()
    for (var i = 0; i < files.length; i++) {
      formData.append(i, files[i], files[i]['name'])
    }
    formData.append('imageable_id', imageable_id)

    let res = await fetch(url, {
      method: 'POST',
      body: formData
    })

  }


  function previewfiles(files, el, appendTo, replace) {

    [].forEach.call(files, (file) => {
      if (!validateType(file)) return

      let reader = new FileReader();
      reader.onload = function ({target}) {
        if (replace) {
          if (appendTo.querySelector('img')) {
            appendTo.querySelector('img').remove()
          }
        }
        let image = new Image()
        image.src = target.result
        // let del = document.createElement('div')
        // del.innerText = 'x'
        // del.dataset.tag = 'delMainImg'
        // del.dataset.id = 'delMainImg'

        appendTo.appendChild(image)
        appendTo.appendChild(del)
      }

      reader.readAsDataURL(file)

    }, appendTo)

  }

  function validateType(file) {
    return acceptedTypes.includes(file.type)
  }


}
