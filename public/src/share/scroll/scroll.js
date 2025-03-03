export default function scroll() {

   var prevScrollpos = window.pageYOffset;

   /* Get the header element and it's position */
   var headerDiv = document.querySelector("header");
   var headerBottom = headerDiv.offsetTop + headerDiv.offsetHeight;

   window.onscroll = function() {
      var currentScrollPos = window.pageYOffset;

      /* if we're scrolling up, or we haven't passed the header,
         show the header at the top */
      if (prevScrollpos > currentScrollPos  || currentScrollPos < headerBottom){
         headerDiv.style.top = "0";
      }
      else{
         /* otherwise we're scrolling down & have passed the header so hide it */
         headerDiv.style.top = "-7.2rem";
      }

      prevScrollpos = currentScrollPos;
   }

}
