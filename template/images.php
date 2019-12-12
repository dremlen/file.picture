<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/config/path.php');
$path = $_SERVER['DOCUMENT_ROOT'] . UPLOAD;
delFiles($path);

$listFiles = scandir($_SERVER['DOCUMENT_ROOT'] . UPLOAD);
$files = array_filter($listFiles, function($file) {
    $blackList = ['.', '..'];
    return (!in_array($file, $blackList));
});
?>

<form method="post">
    <?php
    foreach ($files as $file) : ?>
        <div>
            <img src="<?= UPLOAD . $file ?>" alt="<?= $file ?>" width="100px" height="75px">
            <label>
                <input type="checkbox" name="delete[]" value="<?= $file ?>">Ометить что-бы удалить
            </label>
        </div>

    <?php endforeach ?>
    <input type="submit" name="del" value="Удалить">
</form>