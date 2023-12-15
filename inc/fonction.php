<?php

$pdo = new PDO("mysql:host=127.0.0.1;dbname=23_24_b2_projet_olympics", "root", "",[
     PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
     PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
]);

$pdo -> exec("SET NAMES UTF8");