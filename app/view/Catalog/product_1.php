<main class="column">

  <div class="breadcrumbs">
      <?= $breadcrumbs ?>
  </div>
      <H1 id = 'name'><?= $product['name']; ?></H1>
  <div class="product row">
    <div class="card-left">



      <div class="image">
          <? if (!DEBU): ?>
           <div class="vert-thumbs">
             <div class="thumb-small">
               Вид1
             </div>
             <div class="thumb-small">
               Вид2
             </div>
             <div class="thumb-small">
               Вид3
             </div>
             <div class="thumb-small">
               Вид4
             </div>
           </div>
        <? endif; ?>
        <img src="/pic<?= $product['dpic']; ?>" alt="<?= $product['name']; ?>">
      </div>

      <div class="horiz-thumbs">
          <? if (!DEBU): ?>
           <div class="thumb">
             Расцв етка 1
           </div>
           <div class="thumb">
             Расцв етка 2
           </div>
        <? endif; ?>

      </div>

      <div class="prod-info-wrap">
        <div class="info-tag">Информация о товаре</div>
        <div class="dtxt">
            <?= $product['dtxt'] ?>
        </div>
        <!--<span>Больше информации о товаре »</span>-->
      </div>
      <h3 class="may-also-like-wrap">
        <span>Вам также может понравится</span>
        <div class="may-also-like-title">

          <div class="thumb-big"></div>
          <div class="thumb-big"></div>
          <div class="thumb-big"></div>
          <div class="thumb-big"></div>

        </div>
      </h3>

      <div class="cust-questions-wrap">
        <div class="info-tag">Вопросы покупателей</div>
        <div class="info">
          <p>Есть вопросы по данному продукту? Задайте их здесь. </p>
          <p>Вы получите уведомление на указанный email, когда ответ будет готов. </p>
        </div>
      </div>

      <div class="cust-questions-wrap">
        <div class="info-tag">Оставьте свой отзыв</div>
        <ol>
          <li><span>Вам понравился продукт</span></li>
          <li><span>Напишите свой отзыв</span></li>
          <li><span>Расскажите нам немного о себе</span>
            <input type="text">
            <input type="text">
            <input type="text">
          </li>


        </ol>

      </div>
      <div class="note">
        Внимание: предоставляя отзыв вы подтверждаете и гарантируете, что вам исполнилось 18 лет. Ваш отзыв будет рассмотрен в течение 5 дней.
      </div>
    </div>

    <div class="card-right">



    </div>

  </div>






</div>

<div class="also-viewed">


</div>

</main>


