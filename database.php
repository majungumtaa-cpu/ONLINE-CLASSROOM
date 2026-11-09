<?php
$host='localhost'; $db='virtual_classroom'; $user='root'; $pass='';
try { $pdo=new PDO("mysql:host=$host;dbname=$db;charset=utf8mb4",$user,$pass,[PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION,PDO::ATTR_DEFAULT_FETCH_MODE=>PDO::FETCH_ASSOC]); }
catch(PDOException $e){ die('Database connection failed. Check config/database.php and import database.sql.'); }
