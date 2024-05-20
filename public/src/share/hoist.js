import {$, scrollToTop} from "../common";
import "./hoist.scss";

let hoist = $('.hoist').first();
if (hoist) hoist.onclick = function () {
    scrollToTop();
};