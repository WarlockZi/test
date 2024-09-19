document.addEventListener(
   'scroll',
   (event) => {
      const adminPanel = document.querySelector('.admin-panel');
      if (!adminPanel) return false

      if (window.scrollY > 30) {
         adminPanel.style.position = 'fixed';
         adminPanel.style.top = '0';
      }

      if (window.scrollY < 20) {
         adminPanel.style.position = 'relative';
         adminPanel.style.top = '0';
      }
   },
   {
      passive: true
   }
)
;