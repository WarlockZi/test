import {post, $} from '../../common'

export default function quill() {

  window.onload = function () {

    let selector = '#mytextarea'
    let textarea = $(selector)[0]
    let text = textarea.innerText

    var toolbarOptions = [
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

    var options = {
      modules: {
        toolbar: toolbarOptions
      },
      placeholder: 'Compose an epic...',
      // theme: 'bubble'
      theme: 'snow'
    };

    var quill = new Quill(selector, options);

    quill.setContents(JSON.parse(text));

    quill.on('text-change', function (delta, oldDelta, source) {
      console.log(delta, oldDelta, source)
    })

    textarea.style.background = '#fff'

    let button = $('#button')[0]
    button.addEventListener('click', function () {

        let productId = $(`.item_wrap[data-model='product']`)[0].dataset.id
        let description = JSON.stringify(quill.getContents())

        post('/adminsc/product/adddescription',
          {
            description,
            'id': productId
          }
        )
      }
    )

  }
}


