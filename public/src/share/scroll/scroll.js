document.addEventListener(
   'scroll',
   (event) => {
      const adminPanel = document.querySelector('.admin-panel');
      if (!adminPanel) return false

      // $(document).scroll(function (e) {
      //    $(window).scrollTop() > 50 ? $('header').addClass('fixed') : $('header').removeClass('fixed');
      //    $(window).scrollTop() > 50 ? $('.top').addClass('top-active') : $('.top').removeClass('top-active');
      // });
      if (window.scrollY > 30) {
         adminPanel.classList.add('fixed');
         // adminPanel.style.position = 'fixed';
         // adminPanel.style.top = '0px';
         setTimeout(()=>{adminPanel.style.top = '0';},1)
         ;
      }

      if (window.scrollY < 20) {
         adminPanel.classList.remove('fixed');
         // adminPanel.style.position = 'relative';
         // adminPanel.style.top = '0';
      }
   },
   {
      passive: true
   }
);