<?php
require_once 'public/bootstrap.php';
use App\Services\BookManager;

$id = $_GET['id'];

$bookManager = new BookManager();

$bookManager->deleteBook($id);


header("Location: overview.php");