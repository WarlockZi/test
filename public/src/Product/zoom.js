import { $ } from "../common";

export const zoom = () => {
  let zoom = $(".zoom").first();
  if (zoom) {
    zoom.onmousemove = function (e) {
      let offsetX = 0;
      let offsetY = 0;
      let zoomer = e.currentTarget;

      let width = zoomer.clientWidth;
      let height = zoomer.clientHeight;

      zoomer.style.scale = "2";
      // zoomer.style.scale = "" + width * 1.5;
      // zoomer.style.height = "" + height * 1.5;

      e.offsetX ? (offsetX = e.offsetX) : (offsetX = e.touches[0].pageX);
      e.offsetY ? (offsetY = e.offsetY) : (offsetY = e.touches[0].pageY);
      let x = (offsetX / zoomer.offsetWidth) * 100;
      let y = (offsetY / zoomer.offsetHeight) * 100;
      zoomer.style.backgroundPosition = x + "% " + y + "%";
    };
    zoom.onmouseleave = function (e) {
      let zoomer = e.currentTarget;
      zoomer.style.scale = "1";
    };
  }
};
