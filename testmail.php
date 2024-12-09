<?php



if (mail("vvoronik@yandex.ru", "заголовок", "текст")) {
    echo 'Отправлено';
} else {
    echo 'Не отправлено';
}