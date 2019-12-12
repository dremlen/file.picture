<?php
include($_SERVER['DOCUMENT_ROOT'] . '/functions.php');

$maxSizeFile = 5;
$countFiles = 5;
$allowedTypeFile = ['jpeg', 'jpg', 'png'];
$writeList = ['image/jpeg', 'image/jpg', 'image/png'];
if (isset($_POST['upload'])) {
    // Делаем обработку более удобной   
    foreach ($_FILES['myFile'] as $key => $value) {
        foreach ($value as $k => $v) {
            $_FILES['myFile'][$k][$key] = $v;
        }
        // удаляем старые ключи
        unset($_FILES['myFile'][$key]);
    }
    // Загружаем все картинки по порядку
    foreach ($_FILES['myFile'] as $k => $v) {
        // Загружаем по одному файлу
        $fileName = $_FILES['myFile'][$k]['name'];
        $fileTmpName = $_FILES['myFile'][$k]['tmp_name'];
        $errorCode = $_FILES['myFile'][$k]['error'];
        // Проверяем количество файлов
        if (checkCountFiles($countFiles) === NULL) {
            //Проверяем ошибку загрузки
            if (checkDownloadError($errorCode, $fileTmpName) === NULL) {
                // Создадим ресурс FileInfo
                $fi = finfo_open(FILEINFO_MIME_TYPE);
                // Получим MIME-тип
                $mime = (string) finfo_file($fi, $fileTmpName);
                // Проверим ключевое слово image (image/jpeg, image/png и image/jpg)
                if (!in_array($mime, $writeList)) {
                    return (include_once($_SERVER['DOCUMENT_ROOT'] . '/template/errors/errorType.php'));
                }
                // Зададим ограничения для картинок
                $limitBytes  = 1024 * 1024 * $maxSizeFile;
                if (filesize($fileTmpName) > $limitBytes) {
                    return (include_once($_SERVER['DOCUMENT_ROOT'] . '/template/errors/errorSize.php'));
                }
                // Переместим картинку с расширением в папку /upload
                if (!move_uploaded_file($fileTmpName, $_SERVER['DOCUMENT_ROOT'] . UPLOAD . $fileName)) {
                    return ($_SERVER['DOCUMENT_ROOT'] . '/template/errors/errorUploadFile.php');
                }
            } 
            $success = include_once($_SERVER['DOCUMENT_ROOT'] . '/template/success.php');
        }
    }
}

?>

<form enctype="multipart/form-data" method="post" action="">
    <div>
        <span>Загрузите файл: </span>
        <p><input type="file" name="myFile[]" multiple accept="<?php foreach ($writeList as $value) {
            echo $value . ',';
        } ?>"></p>
    </div>
    <div>
        <input type="submit" name="upload" value="загрузить">
    </div>
</form>