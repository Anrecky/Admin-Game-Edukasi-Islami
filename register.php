
<?php
/*
session_start();
$DATABASE_HOST = 'localhost';
$DATABASE_USER = 'root';
$DATABASE_PASS = '';
$DATABASE_NAME = 'db_game';
$con = mysqli_connect($DATABASE_HOST, $DATABASE_USER, $DATABASE_PASS, $DATABASE_NAME);
if ( mysqli_connect_errno() ) {
	
	exit('Failed to connect to MySQL: ' . mysqli_connect_error());
}
$hash = password_hash('admin', PASSWORD_DEFAULT);
$sql = "INSERT INTO tbl_admin (id,username,password) VALUES (1,'admin','$hash')";

if(mysqli_query($con,$sql)){
    echo "Berhasil";
}else{
    echo "Eror: " . $sql . "<br>" . mysqli_error($con);
}
$con->close();
*/