<main>
  <div class="column">
    <h1>Наши реквизиты</h1>

    <p class="topmargin1">ИП Медведева Е.Г.</p>
    <p>ИНН:352507425251     ОГРНИП    318352500067259</p>
		<?$adress = \app\controller\Address::postCodeDecorator(\app\controller\Address::$factAddress);?>

    <p>Адрес фактический: <?=$adress?></p>
    <p>Адрес для почты: <?=$adress?></p>
    <p>р/с   40802810812000015141  </p>
    <p>Вологодское отделение №8638 ПАО Сбербанк г. Вологда</p>
    <p>БИК 041909644</p>
    <p>к/с 30101810900000000644 </p>

    <p class="topmargin1">ОКВЭД    46.46.2</p>
    <p>ОКПО      0140618716</p>
    <p>ОКАТО   19401000000</p>
    <p>ОКТМО  19701000001</p>
    <p>ОКОГУ   4210014</p>
    <p>ОКОПФ  50102</p>
    <p>ОКФС     16</p>

    <p class="topmargin1"></p>


  </div>
</main>

<style>
     main{
      max-width: 800px;
      margin: auto;

  }
</style>