<?php
include_once 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $db->vote($_POST['id'], $_POST['amm']);
}
