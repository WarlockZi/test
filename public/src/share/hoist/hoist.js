import {$, scrollToTop} from "../../common";
import "./hoist.scss";

const hoist = $('.hoist').first();
if (hoist) hoist.onclick = function () {
    scrollToTop();
};