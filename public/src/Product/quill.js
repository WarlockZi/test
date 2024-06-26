import {$, post} from "../common";
import Quill from "quill";
import "quill/dist/quill.core.css";
import 'quill/dist/quill.snow.css';
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
        : {toolbar:false}

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
  }
  function formatDelta(delta) {
    return JSON.stringify(delta.ops, null, 2)
  }

  function updateContent(delta) {
    let tfs = this.getContents();
    let json = JSON.stringify(tfs)
    update(json)
  }
  function setContent(quill, delta) {
    let innertext = textarea.innerText;
    if (isJsonString(innertext)) {
      let text = JSON.parse(innertext);
      quill.setContents(text)
    } else {
      // let text = fromText(delta, quill,innertext);
    }
  }

  // function fromText(delta, quill,txt) {
  //   let t = quill.getContents(txt)
  //   let arr = delta.ops[0].insert.split('\n').map((line) => {
  //     delta.insert(line)
  //     return line
  //   })
  // }

  async function update(txt) {
    let id = $('[data-field="id"]').first()
    id = +id.innerText
    let data = {id, txt}
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