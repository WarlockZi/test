import {$} from "../../common.js";


document.addEventListener(
   'scroll',
   (event) => {
      const header = $('.header').first()
      window.scrollY > 30 ? header.classList.add('short') : header.classList.remove('short')

      const badges = $('.user-content .banner__text')
      const firstBadge = badges[0]
      // window.scrollY > 0
      //    ? (
      //       firstBadge.style.transform = 'translate(1px,1px)',
      //          firstBadge.style.opacity = '1'
      //    )
      //    : (
      //       firstBadge.style.transform = 'translate(0px,0px)',
      //          firstBadge.style.background = 'initial'
      //    )


   },
   {passive: true}
);