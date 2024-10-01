default
<?php
if (isset($errors) && is_array($errors)) {

    foreach ($errors as $error) {
        echo $error . '<br>';
    };
}
?>

<?= $content ?? ''; ?>