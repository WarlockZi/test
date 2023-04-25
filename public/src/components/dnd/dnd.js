export default function Dnd(cb, el, holderClass = '[dnd]') {
  el.ondragenter = function (e) {
    e.preventDefault();
    this.classList.toggle('hover');
    return false
  };
  el.ondragleave = function (e) {
    e.preventDefault();
    this.classList.toggle('hover');
    return false
  };
  el.ondragover = function (e) {//без ondragover не работает drop
    e.preventDefault();
    return false;
  };
  el.ondrop = function (e) {
    e.preventDefault();
    cb(e.dataTransfer.files, e.target)
  }
}