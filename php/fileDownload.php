<?php
require 'db.php';

if (isset($_GET['file_id'])) {
    $id = $_GET['file_id'];

    $result = mysqli_query($connection, "SELECT * FROM ideas_img WHERE id=$id");

    $file = mysqli_fetch_assoc($result);
    $filepath = '../img/uploads/rationals/' .$file['file'].'.'.$file['extension'];

    if (file_exists($filepath)) {
        header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename=' . basename($filepath));
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Content-Length: ' . filesize($filepath));
        readfile($filepath);

    } else {
        die('Файл не был найден');
    }
}
?>
