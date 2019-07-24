

<main>
  <div class="site">
    <nav class="breadcrumbs">
        <?= $breadcrumbs ?>
    </nav>
    <div class="categories row">

      <div class="filters column">
        <?if ($categories):?>
        <input name = "subcat" class="filter" id="subcat" type="checkbox">
        <label for="subcat">подкатегории
          <? $parent = array_pop($categories) ?>
          <? foreach ($categories as $category): ?>
          <div class="subcat">
            <a href="/<?= $category['name']; ?>"><?= $category['alias']; ?></a>
          </div>
          <? endforeach; ?>
        </label>
        <?endif;?>

      </div>


      <div class="right-block">
        <div class="products">
          <? foreach ($products as $product): ?>
          <? if ($product['act'] == 'Y'): ?>
          <div class="product column">

            <?
            $arr = explode('/', $product['durl']);
            $prodLink = array_pop($arr);
            $prodLink = array_pop($arr);
            ?>

            <a  href="/<?= $prodLink; ?>">
              <div class="action-labels">

              </div>
              <div class="pic-container">
                <div class="pic">
                  <img src="/pic<?= $product['dpic'] ?: '/srvc/nophoto-min.jpg' ?>" alt="">
                </div>
              </div>

              <div class="price-block">
                <span class="final price" editable>550 р </span>
                <span class="price strikethrough">500 р</span>
              </div>

              <div class="item-title">
                  <?= $product['name']; ?>
              </div>




            </a>


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


          </div>
          <? endif; ?>
          <? endforeach; ?>

        </div>

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