<?php

/** функция проверяет разрешенное количество файлов
 * @param количество файлов
 * @return ошибку или NULL 
 */
function checkCountFiles($countFiles)
{
    if (count($_FILES['myFile']) > $countFiles) {
        return (include_once($_SERVER['DOCUMENT_ROOT'] . '/template/errors/errorCountFile.php'));
    } 
}

/**
 * @param ошибка с массива $_FILES
 * @param имя файла с массива $$_FILES
 * @return ошибку или NULL
 */
function checkDownloadError($errorCode, $fileTmpName)
{
    if (!empty($errorCode) || !is_uploaded_file($fileTmpName)) {
        return (include_once($_SERVER['DOCUMENT_ROOT'] . '/template/errors/errorUpload.php'));
    }
}

/** удаляет файлы из папки
 * @param путь к папке
 */
function delFiles($path)
{
    if (isset($_POST['del']) && !empty($_POST['delete'])) {
        for ($i = 0; $i < count($_POST['delete']); $i++) {
            if (file_exists($path . $_POST['delete'][$i])) {
                unlink($path . $_POST['delete'][$i]);
            }
        }
        unset($_POST['delete']);
    }
}

