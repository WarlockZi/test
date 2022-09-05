import {$} from '../../common'

export default function tyny() {

  let tiny = $('[tiny]')
  if (tiny) {
    let script = document.createElement('script')
    script.src = "https://cdn.tiny.cloud/1/vmwh6wx8yqbbpeqrkm691ltxy7bx3x90ez9iqlop0mt9uqwl/tinymce/6/tinymce.min.js"
    script.onload = function () {
      tinymce.init({
        toolbar_items_size: 'small',
        skin_url: '/public/src/components/tiny',
        selector: '#mytextarea',
        toolbar_mode: 'floating',
        // inline: true,
        preview_styles: 'font-size color',
        statusbar: false,
        menubar: false,

        height: 100,
        content_style: 'p{margin:2px 0} body { font-family:Helvetica,Arial,sans-serif; font-size:12px }',
        plugins: [ 'autoresize',
          'a11ychecker', 'advlist', 'advcode', 'advtable', 'autolink', 'checklist', 'export',
          'lists', 'link', 'image', 'charmap', 'preview', 'anchor', 'searchreplace', 'visualblocks',
          'powerpaste', 'fullscreen', 'formatpainter', 'insertdatetime', 'media', 'table', 'help', 'wordcount'
        ],
        toolbar: 'save |undo redo | formatpainter casechange blocks | bold italic backcolor | ' +
          'alignleft aligncenter alignright alignjustify | ' +
          'bullist numlist checklist outdent indent | removeformat | a11ycheck code table help'
      });
      // let text = t.value()

    }
    script.setAttribute('referrerpolicy', 'origin')
    let head = $('head')[0]
    head.appendChild(script)




  }

}
