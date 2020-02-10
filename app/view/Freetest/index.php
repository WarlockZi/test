<section>
  <div class= "container-do-test">

    <div class = 'test-menu-wrap'>
      <?
      new vendor\widgets\menu\Menu([
          'tpl' => ROOT . "/vendor/widgets/menu/menu_tpl/do_freetest_menu.php",
          'cache' => 60,
          'sql' => "SELECT * FROM freetest WHERE enable = '1'"
      ]);
      ?>
    </div>

    <div class= "content"> 


      <p>контент</p>



    </div> 

</section>