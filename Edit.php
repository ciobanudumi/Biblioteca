<?php

require_once 'public/bootstrap.php';

use App\Services\BookManager;

$bookManeger = new BookManager();
if(sizeof($_POST)) {
    $bookManeger->editBook($_POST);
}

header("Location: overview.php");
