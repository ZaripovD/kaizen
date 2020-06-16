<?php

require('php/db.php');
$logo = mysqli_fetch_assoc(mysqli_query($connection, "SELECT * FROM organization_img"));
$name = mysqli_fetch_assoc(mysqli_query($connection, "SELECT * FROM organization"));
