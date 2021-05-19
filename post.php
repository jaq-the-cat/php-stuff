<?php
include_once 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST')
    $db->insertPost($_POST['title'], $_POST['body']);
header('location: index.php');
