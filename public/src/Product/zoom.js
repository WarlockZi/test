import {$} from "../common";

export const zoom = () => {

  let zoom = $('.zoom').first();
  if (zoom) {

    zoom.onmousemove = function (e) {
      let offsetX = 0;
      let offsetY = 0;
      var zoomer = e.currentTarget;

      e.offsetX ? offsetX = e.offsetX : offsetX = e.touches[0].pageX;
      e.offsetY ? offsetY = e.offsetY : offsetY = e.touches[0].pageY;
      let x = offsetX / zoomer.offsetWidth * 100;
      let y = offsetY / zoomer.offsetHeight * 100;
      zoomer.style.backgroundPosition = x + '% ' + y + '%';
    }


  }
}

