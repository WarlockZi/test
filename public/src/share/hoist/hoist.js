import {$, scrollToTop} from "../../common";
import "./hoist.scss";

const hoist = $('.hoist').first();
if (hoist) hoist.addEventListener('click', function () {
   scrollToTop();
})