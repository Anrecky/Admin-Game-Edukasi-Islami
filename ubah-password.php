<?php

$DATABASE_HOST = 'localhost';
$DATABASE_USER = 'root';
$DATABASE_PASS = '';
$DATABASE_NAME = 'db_game';

$con = mysqli_connect($DATABASE_HOST, $DATABASE_USER, $DATABASE_PASS, $DATABASE_NAME);
if (mysqli_connect_errno()) {

    exit('Failed to connect to MySQL: ' . mysqli_connect_error());
}

$id = 1;
$username = "admin";
$password = "admin123";
$hash = password_hash($password, PASSWORD_DEFAULT);

$sql = "UPDATE tbl_admin SET username='$username', password='$hash' WHERE id=$id";

if ($con->query($sql) === TRUE) {
    echo "Berhasil mengubah data";
} else {
    echo "Error mengubah data: " . $con->error;
}

$con->close();
