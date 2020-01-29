<section >


    <? if (isset($result) && $result): ?>
        <p class="result">Данные отредактированы!</p>
    <? endif; ?>
    <?php if (isset($errors) && is_array($errors)): ?>
        <ul>
            <?php foreach ($errors as $error): ?>
                <li> - <?php echo $error; ?></li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>

    <form class="form-container" action="#" method="post">
        <div class="form-title">Редактирование данных</div>

        <input class="form-input" placeholder="Имя" name="name" value="<?= $user['name'] ?>"/>

        <input class="form-input" placeholder="Фамилия" name="surName" value="<?= $user['surName'] ?>"/>

        <input class="form-input" placeholder="Отчество" name="middleName" value="<?= $user['middleName'] ?>"/>

        <input class="form-input" placeholder="День рождения:" name="birthDate" type="date"
               value="<?= $user['birthDate'] ?>"/>

        <input class="form-input" placeholder="Телефон" name="phone" value="<?= $user['phone'] ?>"/>

        <input class="form-input" placeholder="email" name="email" type="email" value="<?= $user['email'] ?>" required/>

        <input type="submit" name="submit" class="form-input submit" value="Сохранить"/>
    </form>
    <style>

        /*************************
        *******     Forms  ******
        **************************/
        .result{
            display: block;
            margin: 0;
            padding: 25px;
            background-color: #c9ffd5;
            text-align: center;
        }
        .form-container {
            display: flex;
            flex-flow: column wrap;
            padding: 35px 30px 15px 30px;
            background: #eee;
            width: 300px;
            margin: 3% auto;
            align-items: stretch;
        }

        .form-title {
            font-weight: bold;
            font-size: 120%;
            text-align: center;
            color: #949494;
            margin-bottom: 20px;
        }

        .form-input {
            background: #f7f7f7;
            border-radius: 0;
            border-bottom: 1px solid #ccc;
            border-left: 0;
            border-top: 0;
            border-right: 0;
            flex: 1;
            margin: 10px 0;
            padding: 12px;
            width: 100%;
            box-sizing: border-box;
            color: #757575;
        }


        .submit {
            padding: 14px;
            background: rgba(0, 0, 0, 0.15);
            text-align: center;
            font-weight: 600;

        }

        .submit:hover {
            background: #adadad;
            color: #fff;
        }


        .bottom {
            display: flex;
            align-items: center;
        }

        .bottom li {
            flex: 1;
            text-align: center;
            display: flex;
        }

        .bottom li a {
            color: #949494;
            flex-basis: 100%;
            padding: 10px 3px;
        }

        .bottom li a:hover {
            color: #fff;
            background-color: #ccc;
        }

    </style>


</section>