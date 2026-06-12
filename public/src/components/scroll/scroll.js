export default function scroll() {
  let prevScrollpos = window.pageYOffset;

  /* Get the header element and it's position */
  const headerDiv = document.querySelector("header");
  const headerBottom = headerDiv.offsetTop + headerDiv.offsetHeight;

  window.onscroll = function () {
    const currentScrollPos = window.pageYOffset;

    /* if we're scrolling up, or we haven't passed the header,
         show the header at the top */
    if (prevScrollpos > currentScrollPos || currentScrollPos < headerBottom) {
      headerDiv.style.top = "0";
    } else {
      /* otherwise we're scrolling down & have passed the header so hide it */
      headerDiv.style.top = "-7.2rem";
    }

    prevScrollpos = currentScrollPos;
  };
}
