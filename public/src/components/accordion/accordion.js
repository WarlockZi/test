import './accordion.scss'
import {$} from '../../common'

$('label').on('click', handle)

function handle(e) {

  let checkbox = e.target.previousSibling
  let parent = checkbox.closest('ul')
  let ul = checkbox.nextSibling.nextSibling

  if (checkbox.checked) {
    slideUp(ul, 0,)
  } else {
    parent.style.height = "auto"
    slideDown(ul, 0)
    closeSiblings(parent)

  }
}

function slideDown(el, interval, callback) {

  let siblings = el.children
  let exactSiblings = Array.from(siblings).reduce(
    (acc, el, index) => {
      return el.tagName === 'LI' ? acc + el.scrollHeight : null
    }, 0
  )

  let height = exactSiblings
  let counter = 0;
  let step = height / 30
  let int = setInterval(
    function () {
      counter += step;
      if (counter < height) {
        el.style.height = counter + "px";
      } else {
        el.style.height = height + "px";
        clearInterval(int);
        if (callback) {
          callback()
        }
      }
    }, interval);
}

function slideUp(el, interval, callback) {

  let parent = el.parentNode.parentNode
  let height = el.offsetHeight
  let heightToDistractFromParent = height
  let step = height / 30
  let counter = height;
  let pCounter = parent.offsetHeight;
  let pInitHeight= parent.offsetHeight;

  let int = setInterval(
    function () {
      el.style.display = `block`
      counter -= step;
      pCounter -= step
      if (counter > 0) {
        el.style.height = counter + "px";
        parent.style.height = pCounter + "px"
      } else {
        el.style.height = 0;
        clearInterval(int);
        parent.style.height = pInitHeight
        if (callback) {
          callback()
        }
      }
    }, interval, heightToDistractFromParent);
}

function closeSiblings(parent) {
  Array.from(parent.children).map((el) => {
      let elArr = Array.from(el.children)
      elArr.map((ch) => {
        if (ch.type && ch.type === 'checkbox' && ch.checked) {
          let ul = ch.nextSibling.nextSibling
          slideUp(ul, 0, function () {
            ch.checked = false
          })
        }
      })
    }
  )
}

// var adder = height / 10; //the height is global variable
//
// //iteratively increase the height
// interval = setInterval(function () {
//     counter += adder;
//     if (counter < height) {
//         a.style.height = counter + "px";
//     } else {
//         a.style.height = height + "px";
//         clearInterval(interval);
//     }
// }, duration);

// //#3 the slideDown
// function slideDown(a, b) {
//     var adder = height / 10; //the height is global variable
//     //iteratively increase the height
//     interval = setInterval(function () {
//         counter += adder;
//         if (counter < height) {
//             a.style.height = counter + "px";
//         } else {
//             a.style.height = height + "px";
//             b.disabled = 0;
//             b.innerHTML = "slideUp";
//             //enable easing button
//             ease.disabled = 0;
//             clearInterval(interval);
//         }
//     }, duration);
// }


