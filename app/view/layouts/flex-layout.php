<!DOCTYPE html>
<html lang="ru">
  <!--FLEX-LAYOUT-->
  <head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="robots" content="noindex,nofollow" />
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <? $this::getMeta() ?>
    <link rel="shortcut icon" href="<?= PROJ ?>/public/favicon.ico">
    <link 	href="<?= PROJ ?>/public/css/<?= $vars['css'] ?>?<?= time() ?>" rel="stylesheet">
    <meta name="theme-color" content="#ff2929"/>
  </head>


  <body>
    <div class="wrap">

      <header>


        <div class="top-strip">
          <div>

            +7 921 715 24 64 </div>


          <div class="user-menu">

            <? if (isset($_SESSION['id']) && !$_SESSION['id']): ?>
               <a class = "enter-button" href="/user/login"> Вход</a>
            <? else: ?>

               <div class = "user-button">
                 <div>
                   <span><?
                       if (isset($user)) {
                          echo $user['surName'] . ' ' . $user['name'] . ' ' . $user['middleName'];
                       }
                       ?></span>
                   <svg version="1.1" xmlns="http://www.w3.org/2000/svg" width="30" height="16" viewBox="0 0 16 16">
                   <path fill="#757575" d="M1 3h14v2h-14zM1 7h14v2h-14zM1 11h14v2h-14z"></path>
                   </svg>
                 </div>
                 <div class="nav">
                   <a  href="/user/edit" >Редактировать свой профиль</a>
                   <? if (isset($user)): ?>                                          }?>
                      <?
                      $arr = $user['rights'];
                      if (in_array('3', $arr)):
                         ?>
                         <a href="/adminsc">Admin</a>
                      <? endif; ?>
                      <? if (in_array('1', $arr)): ?>
                         <a href="/test/edit/1">Ред. закрытые тесты</a>
                         <a href="/freetest/edit/41">Ред. открытые  тест</a>
                      <? endif; ?>
                      <? if (in_array('2', $arr)): ?>
                         <a href="/test/1">Закрытый тест</a>
                         <a href="/freetest/41">Открытый тест</a>
                      <? endif; ?>
                   <? endif; ?>

                   <? if (isset($user)): ?>
                      <a href="/test/contacts">
                        <svg version="1.1" xmlns="http://www.w3.org/2000/svg" width="18" height="10" viewBox="0 0 20 20">
                        <path fill="#e30000" d="M18 2c1.105 0 2 0.895 2 2v0 12c0 1.105-0.895 2-2 2v0h-16c-1.105 0-2-0.895-2-2v0-12c0-1.1 0.9-2 2-2h16zM13.63 11.1l6.37 4.9v-2l-5.12-3.9 5.12-4.1v-2l-10 8-10-8v2l5.12 4.1-5.12 3.9v2l6.37-4.9 3.63 2.9 3.63-2.9z"></path>
                        </svg>
                        Напишите нам
                      </a>

                      <a href="/user/logout">
                        <svg width="16" height="8" xmlns="http://www.w3.org/2000/svg" xmlns:svg="http://www.w3.org/2000/svg" viewBox="-5 0 16 8">
                        <title>lock 1</title>
                        <rect stroke="#e30000" stroke-opacity="0" id="svg_2" height="4.582587" width="4.582587" y="3.349051" x="0.267697" stroke-linecap="null" stroke-linejoin="null" stroke-dasharray="null" stroke-width="null" fill="#e30000"/>
                        <path stroke="#e30000" fill-opacity="0" id="svg_17" d="m0.813005,3.42179c0.127532,-4.291629 3.592734,-3.018688 3.527173,-1.091092" stroke-linecap="null" stroke-linejoin="round" stroke-dasharray="null" fill="#e30000"/>
                        </svg>
                        Выход</a>
                   <? endif; ?>
                 </div>
               </div>



            <? endif; ?>

          </div>
        </div>


        <div class="header">

          <a class="logo" href= "/">
            <svg width="235" height="45" version="1.1" viewBox="0 0 140.93602 25.903431" xmlns="http://www.w3.org/2000/svg" xmlns:cc="http://creativecommons.org/ns#" xmlns:dc="http://purl.org/dc/elements/1.1/" xmlns:rdf="http://www.w3.org/1999/02/22-rdf-syntax-ns#" xmlns:xlink="http://www.w3.org/1999/xlink">
            <defs>
            <path id="a4bgr29v3" d="m473.35 105.73c5.3 0.04 0.86 0.08-9.88 0.08s-15.1-0.04-9.65-0.08c5.44-0.07 14.23-0.07 19.53 0z"/>
            <path id="c1VGvvv2Z" d="m0.1 55.82c16.91-27.81 27.48-45.2 31.71-52.15 1.55-2.55 4.32-4.11 7.31-4.12 2.41-0.01 8.45-0.03 18.1-0.06-16.26 26.9-26.43 43.71-30.5 50.44-2.21 3.66-6.18 5.89-10.46 5.89h-16.16z"/>
            <path id="gUAoYJIok" d="m424.85 71.92c0.08 1.99 0.08 5.3 0 7.33-0.03 1.99-0.11 0.34-0.11-3.68s0.08-5.68 0.11-3.65z"/>
            <path id="d1QYQspoc" d="m572.98 2.18h21.38c3.48 0 5.45 3.98 3.35 6.74-6.21 8.16-23.24 30.55-30.33 39.87-0.36 0.49-1.07 0.53-1.49 0.09-3.46-3.64-11.32-11.91-14.35-15.1-1.68-1.76-1.75-4.51-0.17-6.36 2.88-3.36 10.09-11.78 21.61-25.24z"/>
            <path id="c2Sj5L9Of" d="m150.96 2.18c3.49 0 6.65 2.09 8.01 5.31 3.56 8.41 12.46 29.44 26.7 63.09 13.97-32.77 22.71-53.25 26.2-61.44 1.8-4.22 5.95-6.96 10.53-6.96h11.07c3.87 0 6.49 3.96 4.98 7.52-8.16 19.23-29.74 70.1-37.98 89.5-1.71 4.04-5.67 6.66-10.06 6.66h-8.6c-4.22 0-8.03-2.49-9.72-6.36-8.5-19.46-31.06-71.1-39.52-90.47-1.41-3.23 0.96-6.85 4.48-6.85h13.91z"/>
            <path id="a22pvJeVTv" d="m251 6.99c0-2.65 2.15-4.81 4.81-4.81h17.37c2.87 0 5.21 2.33 5.21 5.21v94.93c0 1.96-1.59 3.54-3.54 3.54h-19.68c-2.3 0-4.17-1.86-4.17-4.16v-94.71z"/>
            <path id="b3VxPr9vMy" d="m324.94 24.35h-30.96c-2.92 0-5.29-2.37-5.29-5.29v-10.53c0-3.35 2.71-6.07 6.06-6.07 18.45 0.01 69.02 0.01 87.79 0.01 2.46 0 4.46 1.99 4.46 4.45v13.76c0 2.03-1.65 3.67-3.68 3.67h-32.57v77.34c0 2.46-2 4.46-4.46 4.46h-17.25c-2.26 0-4.1-1.84-4.1-4.11v-77.69z"/>
            <path id="f2bkoof7Mq" d="m398.29 8.6c0-3.39 2.75-6.14 6.14-6.14h78.75c3.12 0 5.65 2.53 5.65 5.65v9.04c0 3.38-2.75 6.13-6.13 6.14-7.72 0.01-27.03 0.04-57.92 0.1v20.06h48.33c2.77 0 5.01 2.24 5.01 5.01v10.52c0 2.96-2.4 5.35-5.35 5.35h-47.99c-0.25 13.5-0.25 20.38 0 20.63 0.23 0.23 20.08 0.24 59.55 0.02 2.48-0.01 4.5 1.99 4.5 4.47v12.2c0 2.48-2.01 4.5-4.49 4.5h-81.55c-2.48 0-4.5-2.02-4.5-4.5v-93.05z"/>
            <path id="bbT7DNVUa" d="m530.34 52.96c-18.36-23.66-29.83-38.45-34.42-44.36-1.94-2.5-0.16-6.14 3-6.14h19.33c2.46 0 4.8 1.12 6.34 3.05 16.12 20.13 58.99 73.63 74.34 92.8 2.53 3.16 0.28 7.84-3.76 7.84h-16.27c-2.21 0-4.3-0.98-5.72-2.68-3.53-4.21-12.33-14.72-26.43-31.55-13.1 15.91-21.28 25.86-24.56 29.83-2.29 2.78-5.7 4.4-9.3 4.4h-16.87c-2.01 0-3.17-2.3-1.98-3.92 4.84-6.57 16.94-22.99 36.3-49.27z"/>
            <path id="b1d9vAIQqx" d="m53.8 106.64c16.91-27.82 27.48-45.2 31.71-52.16 1.55-2.55 4.32-4.11 7.31-4.12 2.41-0.01 8.44-0.03 18.1-0.05-16.27 26.89-26.43 43.7-30.5 50.43-2.21 3.66-6.18 5.9-10.46 5.9h-16.16z"/>
            <path id="b22YyPyZK" d="m0.1 109c32.99-53.38 53.6-86.75 61.85-100.1 3.25-5.26 9-8.46 15.18-8.46h33.79c-34.57 53.96-56.17 87.69-64.81 101.18-2.95 4.6-8.04 7.38-13.5 7.38h-32.51z"/>
            </defs>
            <g transform="matrix(.23439 0 0 .23439 .18676 .23738)">
            <use width="100%" height="100%" fill="#8d8d8d" xlink:href="#a4bgr29v3"/>
            <use width="100%" height="100%" fill="#8d8d8d" xlink:href="#c1VGvvv2Z"/>
            <use width="100%" height="100%" fill="#8d8d8d" xlink:href="#gUAoYJIok"/>
            <use width="100%" height="100%" fill="#ff2929" xlink:href="#d1QYQspoc"/>
            <use width="100%" height="100%" fill="#4e4e4e" xlink:href="#c2Sj5L9Of"/>
            <use width="100%" height="100%" fill="#4e4e4e" xlink:href="#a22pvJeVTv"/>
            <use width="100%" height="100%" fill="#4e4e4e" xlink:href="#b3VxPr9vMy"/>
            <use width="100%" height="100%" fill="#4e4e4e" xlink:href="#f2bkoof7Mq"/>
            <use width="100%" height="100%" fill="#4e4e4e" xlink:href="#bbT7DNVUa"/>
            <use width="100%" height="100%" fill="#8d8d8d" xlink:href="#b1d9vAIQqx"/>
            <use width="100%" height="100%" fill="#ff2929" xlink:href="#b22YyPyZK"/>
            </g>
            </svg>
            <span class="logo-desc">Спецодежда, спецобувь, средства<br> индивидуальной защиты СИЗ оптом</span>
          </a>


        </div>

      </header>


      <?= $content ?>


      <div class = "page-buffer"></div>

    </div>

    <footer>
      <p>Copyright © <? echo date('Y') ?></p>
      <p>Created by VORONIKLAB</p>
    </footer>

    <script type="text/javascript">var PROJ = '<?= PROJ ?>';</script>
    <script src="<?= PROJ ?>/public/js/jq.js"></script>
    <? if (isset($js)): ?>
       <script src="<?= $js ?>"></script>
    <? else: ?>
       <script src="<?= PROJ ?>/public/js/scripts.js"></script>
    <? endif; ?>

    <!-- Yandex.Metrika counter -->
    <script type="text/javascript" >
           (function (m, e, t, r, i, k, a) {
              m[i] = m[i] || function () {
                 (m[i].a = m[i].a || []).push(arguments)
              };
              m[i].l = 1 * new Date();
              k = e.createElement(t), a = e.getElementsByTagName(t)[0], k.async = 1, k.src = r, a.parentNode.insertBefore(k, a)
           })
           (window, document, "script", "https://mc.yandex.ru/metrika/tag.js", "ym");

           ym(7715905, "init", {
              clickmap: true,
              trackLinks: true,
              accurateTrackBounce: true,
              webvisor: true
           });
    </script>
    <noscript><div><img src="https://mc.yandex.ru/watch/7715905" style="position:absolute; left:-9999px;" alt="" /></div></noscript>
    <!-- /Yandex.Metrika counter -->

  </body>
</html>