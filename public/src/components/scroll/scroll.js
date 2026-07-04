export default function scroll() {
  let prevScrollpos = window.pageYOffset;

  /* Get the header element and it's position */
  const header = document.querySelector("header");
  const headerBottom = header.offsetTop + header.offsetHeight;

  window.onscroll = function () {
    const currentScrollPos = window.pageYOffset;

    /* if we're scrolling up, or we haven't passed the header,
         show the header at the top */
    if (prevScrollpos > currentScrollPos || currentScrollPos < headerBottom) {
      header.style.top = "0";
    } else {
      /* otherwise we're scrolling down & have passed the header so hide it */
      header.style.top = "-7.2rem";
    }

    prevScrollpos = currentScrollPos;
  };
}
