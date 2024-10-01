<section>
    <div class="container">
        <h1>C целью ускорения процесса обучения Компания Витекс предоставляет
            возможность изучить ассортимент, технику продаж, правила и стандарты с помощью системы тестирования.</h1>

        <hr/>
        <a href="<?= '/adminsc/test/do' ?>">Проходить тесты</a>

       <? foreach ($tests as $test): ?>
           <a href="/adminsc/test/do/<?= $test->id ?>"><?= $test->name; ?></a>
       <? endforeach; ?>

    </div>
</section>