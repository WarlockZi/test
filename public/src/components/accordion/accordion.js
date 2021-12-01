import './accordion.scss'
import {$} from '../../common'

$('label').on('click', handle)

function handle(e) {

  let checkbox = e.target.previousSibling
  let parent = checkbox.parentNode.parentNode

  // if (checkbox.checked) {
    let ul = checkbox.nextSibling.nextSibling
    slideDown(ul, 3, 2 )

  // } else {
    Array.from(parent.children).map((el) => {
        let elArr = Array.from(el.children)
        elArr.map((ch) => {
          if (ch.type && ch.type === 'checkbox' && ch.checked) {
            let ul = ch.nextSibling.nextSibling
            slideUp(ul, 3, 2, function () {
              ch.checked = false
            })
          }
        })
      }
    )
  // }


}

function slideDown(el, dur, step, callback) {
  let height = el.offsetHeight
  let counter = height;
  el.style.height = "auto"
  // let interval = setInterval(
  //   function () {
  //     counter += step;
  //     if (counter < height) {
  //       el.style.height = counter + "px";
  //     } else {
  //       el.style.height = height + "px";
  //       clearInterval(interval);
  //       if (callback) {
  //         callback()
  //       }
  //     }
  //   }, dur);
}

function slideUp(el, dur, step, callback) {

  let height = el.offsetHeight
  let counter = height;

  let interval = setInterval(
    function () {
      counter -= step;
      if (counter > 0) {
        el.style.height = counter + "px";
      } else {
        el.style.height = 0;
        clearInterval(interval);
        if (callback) {
          callback()
        }
      }
    }, dur);
}



//
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
//
//     var adder = height / 10; //the height is global variable
//
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
//
// }


