<?php
        $pdo = new PDO('mysql:host=localhost;dbname=new_schema;
        charset=utf8', 'anwer', 'anwer.2019');
        $pdo->setAttribute(PDO::ATTR_ERRMODE,
        PDO::ERRMODE_EXCEPTION);
?>