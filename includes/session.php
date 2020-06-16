<html>
<head>
  <title>Рацпредложения</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <link rel="stylesheet" href="css/style.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
  <link  href="https://cdnjs.cloudflare.com/ajax/libs/fotorama/4.6.4/fotorama.css" rel="stylesheet">
  <script src="https://cdnjs.cloudflare.com/ajax/libs/fotorama/4.6.4/fotorama.js"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
  <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
</head>

<?php
require 'php/db.php';

 if (isset ($_SESSION['logged_user'])) {
    $sesid = $_SESSION['logged_user'][0];
    $sesFather = $_SESSION['logged_user'][1];
    $sesName = $_SESSION['logged_user'][2];
    $sesFamily = $_SESSION['logged_user'][3];
    $sesDep = $_SESSION['logged_user'][4];
    $sesMail = $_SESSION['logged_user'][5];
    $sesPhone = $_SESSION['logged_user'][6];
    $sesRole = $_SESSION['logged_user'][7];
    $sesPos = $_SESSION['logged_user'][8];
    $dep = mysqli_fetch_assoc(mysqli_query($connection, "SELECT name FROM departments WHERE id = $sesDep"));
    $pos = mysqli_fetch_assoc(mysqli_query($connection, "SELECT name FROM positions WHERE id = $sesPos"));

   if ($sesRole == 1) {
     include("includes/header2.php");
  } elseif ($sesRole == 2) {
    include("includes/header3.php");
  } else {
    include("includes/header1.php");
}
} else {
    include("includes/header.php");
}


 ?>

 <body>
