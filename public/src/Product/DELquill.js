import {$, post} from "../common";
import Quill from "quill";
import "quill/dist/quill.core.css";
import 'quill/dist/quill.snow.css';
export const quilld = () => {

debugger
  const quillSelector = '.detail-text';
  const textarea = $(quillSelector)[0];
  if (textarea) {
    createQuill()
  }

  function getOptions() {
    const isAdmin = window.location.pathname.split('/').includes('adminsc')
    const toolbar =
      isAdmin
         ?
        {toolbar: [
            ["bold", "italic", "underline", "blockquote"],
            [{align: "justify"}, {align: "center"}, {align: "right"}],
          ]}
        : {toolbar:false}

    return {
      debug: "warn",
      modules:
      toolbar,
      placeholder: 'Нет информации...',
      readOnly: !isAdmin,
      theme: 'snow' //'bubble'
    };
  }

  function createQuill() {
    const quill = new Quill(quillSelector, getOptions());
    const delta = quill.getContents();

    setContent(quill, delta)
    quill.on(Quill.events.TEXT_CHANGE, updateContent.bind(quill));
  }
  function formatDelta(delta) {
    return JSON.stringify(delta.ops, null, 2)
  }

  function updateContent(delta) {
    const tfs = this.getContents();
    const json = JSON.stringify(tfs)
    this.update(json)
  }
  function setContent(quill, delta) {
    const innertext = textarea.innerText;
    if (isJson(innertext)) {
      const text = JSON.parse(innertext);
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

  // async function update(txt) {
  //   let id = $('[data-field="id"]').first()
  //   id = +id.innerText
  //   const data = {id, txt}
  //   const res = await post(
  //     '/adminsc/product/updateOrCreate',
  //     data
  //   )
  // }


}