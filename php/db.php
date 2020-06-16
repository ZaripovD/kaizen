<?php

session_start();
error_reporting(0);
$connection = mysqli_connect("localhost", "root", "", "kaizen");
mysqli_query($connection, "SET NAMES 'utf8");
mysqli_query($connection, "SET CHARACTER SET 'utf8'");

$errors = array();
$data = $_POST;

$org = mysqli_query($connection, "SELECT * FROM organization");
$chiefAdm = mysqli_query($connection, "SELECT * FROM chiefs WHERE department = 1");
$deps = mysqli_query($connection, " SELECT * FROM departments");
$sph = mysqli_query($connection, " SELECT * FROM spheres");

$monthsName = [
		'янв', 'фев', 'март',
		'апр', 'май', 'июнь',
		'июль', 'авг', 'сен',
		'окт', 'ноя', 'дек'
	];
