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
         adminPanel.style.position = 'fixed';
         adminPanel.style.top = '0';
      }

      if (window.scrollY < 20) {
         adminPanel.style.position = 'relative';
         // adminPanel.style.top = '0';
      }
   },
   {
      passive: true
   }
);