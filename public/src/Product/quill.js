import {$, post} from "../common";

export const quill = () => {
  let quillSelector = '.detail-text';
  let textarea = $(quillSelector)[0];

  if (textarea) {
    createQuill()
  }

  function getOptions() {
    const isAdmin = window.location.pathname.split('/').includes('adminsc')
    const toolbar =
      isAdmin ?
        {
          toolbar: [
            ["bold", "italic", "underline", "blockquote"],
            [{align: "justify"}, {align: "center"}, {align: "right"}],
            // ['link', 'image'],
          ]
        }
        : false

    return {
      debug: "warn",
      modules:
      toolbar,
      placeholder: 'Compose an epic...',
      readOnly: !isAdmin,
      theme: 'snow' //'bubble'
    };
  }

  function createQuill() {
    let quill = new Quill(quillSelector, getOptions());
    let delta = quill.getContents();
    setContent(quill, delta)
    quill.on(Quill.events.TEXT_CHANGE, updateContent.bind(quill));
    // quill.on('text-change', updateContent.bind(null, delta, quill));
  }
  function formatDelta(delta) {
    return JSON.stringify(delta.ops, null, 2)
  }

  function fromPs(delta, quill){
    const contents = quill.getContents();
    if (delta) {
      return  formatDelta(delta)
    }
    return  formatDelta(contents)
    // let delt =  delta.getContents()
    // let arr = delta.ops[0].insert.split('\n').map((line) => {
    //   return line
    // })
    // delta.ops[0].insert = arr
    // return arr
  }

  function updateContent(delta, quill) {
    let d = fromPs(delta, this)
    let tfs = this.getContents();
    let json = JSON.stringify(tfs)
    // update(json)
  }
  function setContent(quill, delta) {
    let innertext = textarea.innerText;
    if (isJsonString(innertext)) {
      let text = JSON.parse(innertext);
      quill.setContents(text)
    } else {
      let text = fromText(delta, quill,innertext);
      // quill.setContents(text)
    }
  }

  function fromText(delta, quill,txt) {
    let t = quill.getContents(txt)
    let arr = delta.ops[0].insert.split('\n').map((line) => {
      delta.insert(line)
      return line
    })
  }

  async function update(json) {
    let id = $('[data-field="id"]').first()
    id = +id.innerText
    let data = {id, json}
    let res = await post(
      '/adminsc/product/updateOrCreate',
      data
    )
  }


  function isJsonString(str) {
    try {
      JSON.parse(str);
    } catch (e) {
      return false;
    }
    return true;
  }
}