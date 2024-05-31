import {post, $} from '../../common'

export default function quill() {

  window.onload = function () {
    const selector = '#detail-text'
    // let selector = '#mytextarea'
    let textarea = $(selector)[0]
    if (!textarea) return false

    let toolbarOptions = [
      ['bold', 'italic', 'underline', 'strike'],        // toggled buttons
      ['blockquote'],

      // [{ 'header': 1 }, { 'header': 2 }],               // custom button values
      [{'list': 'ordered'}, {'list': 'bullet'}],
      [{'script': 'sub'}, {'script': 'super'}],      // superscript/subscript
      [{'indent': '-1'}, {'indent': '+1'}],          // outdent/indent
      // [{ 'direction': 'rtl' }],                         // text direction

      [{'size': ['small', false, 'large', 'huge']}],  // custom dropdown
      // [{ 'header': [1, 2, 3, 4, 5, 6, false] }],

      [{'color': []}, {'background': []}],          // dropdown with defaults from theme
      [{'font': []}],
      [{'align': []}],

      ['clean']                                         // remove formatting button
    ];

    let options = {
      modules: {
        toolbar: toolbarOptions
      },
      placeholder: 'Compose an epic...',
      // theme: 'bubble'
      theme: 'snow'
    };

    let text = textarea.innerText.trim()

    let quill = new Quill(selector, options);

    debugger
    try {
      const json = JSON.parse(text);
      quill.setContents(json)
    } catch (e) {
      quill.insertText(0, text)
    }

    textarea.style.background = '#fff'

    let button = $('#button')[0]
    button.addEventListener('click', function () {

        let productId = $(`.item-wrap[data-model='product']`)[0].dataset.id
        let txt = JSON.stringify(quill.getContents())

        post('/adminsc/product/updateOrCreate',
          {
            txt,
            'id': productId
          }
        )
      }
    )

  }
}


