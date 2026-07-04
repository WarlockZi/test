import { $ } from "../../common";
import "./hoist.scss";

const hoist = $(".hoist").first();
if (hoist)
  hoist.addEventListener("click", function () {
    const scrollToTop = () => {
      const htmlBugOffset = 4;
      const c =
        document.documentElement.scrollTop - htmlBugOffset ||
        document.body.scrollTop;
      if (c > 0) {
        window.requestAnimationFrame(scrollToTop);
        window.scrollTo({
          top: c - c / 9,
          // behavior: "smooth",
        });
      }
    };
    scrollToTop();
  });
