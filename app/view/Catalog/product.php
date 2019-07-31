<main class="main">
  <div class="site">
    <div class="breadcrumbs">
        <?= $breadcrumbs ?>
    </div>
    <div class="badge">

      <div class="card">
        <div class="card-left">
          <div class = "row">
            <H1><?= $product['name']; ?></H1>
            <div class = "art"><?= $product['art']; ?></div>
          </div>


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

          <!--</div>-->
            <img src="/pic<?= $product['dpic']; ?>" alt="<?= $product['name']; ?>">

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
            <span>Больше информации о товаре »</span>
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


      </div>



      <div class="card-right">
        <div class="desc">
<!--            <p>Описание товара</p>
          <p><?= $product['dtxt']; ?></p>-->
          <span class="rating">Рейтинг</span>
          <div class="star-rating">
            <div class="star-rating__wrap">
              <input class="star-rating__input" id="star-rating-5" type="radio" name="rating" value="5">
              <label class="star-rating__ico fa fa-star-o fa-lg" for="star-rating-5" title="5 out of 5 stars"></label>
              <input class="star-rating__input" id="star-rating-4" type="radio" name="rating" value="4">
              <label class="star-rating__ico fa fa-star-o fa-lg" for="star-rating-4" title="4 out of 5 stars"></label>
              <input class="star-rating__input" id="star-rating-3" type="radio" name="rating" value="3">
              <label class="star-rating__ico fa fa-star-o fa-lg" for="star-rating-3" title="3 out of 5 stars"></label>
              <input class="star-rating__input" id="star-rating-2" type="radio" name="rating" value="2">
              <label class="star-rating__ico fa fa-star-o fa-lg" for="star-rating-2" title="2 out of 5 stars"></label>
              <input class="star-rating__input" id="star-rating-1" type="radio" name="rating" value="1">
              <label class="star-rating__ico fa fa-star-o fa-lg" for="star-rating-1" title="1 out of 5 stars"></label>
            </div>
          </div>
          <span class="review">Отзывы</span>
          <input type="submit" class="add-to-cart" value="Хочу узнать цену">
          <span class="share">
            <span class="share-title">Поделиться</span>
            <svg viewBox="-200 -150 2100 2100" class="f" fill="#fff" preserveAspectRatio="xMidYMid meet" height="100" width="1000" role="img" aria-labelledby="title"><title>Facebook</title><path d="M1343 12v264h-157q-86 0-116 36t-30 108v189h293l-39 296h-254v759h-306v-759h-255v-296h255v-218q0-186 104-288.5t277-102.5q147 0 228 12z" fill="#fff"></path></svg>
          </span>

        </div>
      </div>


    </div>

    <div class="also-viewed">


    </div>
  </div>
</div>
<svg xmlns="http://www.w3.org/2000/svg" style="display: none">
<symbol id="star" viewBox="-4 -6 48 48" >
  <title>Star</title>
  <polygon stroke-width="3" points="20,0,25.877852522924734,11.909830056250525,39.02113032590307,13.819660112501051,29.510565162951536,23.090169943749473,31.755705045849467,36.180339887498945,20,30,8.24429495415054,36.180339887498945,10.489434837048465,23.090169943749476,0.9788696740969272,13.819660112501055,14.122147477075266,11.909830056250527"></polygon>
</symbol>
</svg>
</main>


