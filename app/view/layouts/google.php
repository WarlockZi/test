<? if ($_ENV['DEV'] !== '1'): ?>
    <!-- Google tag (gtag.js) -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-04HQG70W2B"></script>
    <script>
       window.dataLayer = window.dataLayer || [];

       function gtag() {
          dataLayer.push(arguments);
       }

       gtag('js', new Date());

       gtag('config', 'G-04HQG70W2B');
    </script>
<? endif; ?>