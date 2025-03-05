<section>
    <div class="container">
        <h1>C целью ускорения процесса обучения Компания Витекс предоставляет
            возможность изучить ассортимент, технику продаж, правила и стандарты с помощью системы тестирования.</h1>

        <hr/>
        <a href="<?= '/adminsc/test/do' ?>">Проходить тесты</a>

        <ul>

            <? foreach ($tests as $test): ?>
                <li>
                    <a href="/adminsc/test/do/<?= $test->id ?>"><?= $test->name; ?></a>
                </li>
            <? endforeach; ?>
        </ul>

    </div>
</section>