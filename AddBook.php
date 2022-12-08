<?php
include "public/layout/header.php";
require_once 'public/bootstrap.php';

use App\Services\BookManager;

$bookManeger = new BookManager();
if(sizeof($_POST)) {
    $bookManeger->addBook($_POST);
}
?>

<h4>Add new book.</h4>
<form action="AddBook.php" method="POST"><br>
    Name: <input type="text" name="name" required><br>
    Author: <input type="text" name="author" required><br>
    Key words: <input type="text" name="keyWords"><br>
    Edition: <input type="text" name="edition"><br>
    Domain: <input type="text" name="domain"><br>
    Year1: <input type="number" name="year" min="1900" max="2022" value="2022"><br>
    <button type="submit">Submit</button>
</form>

<?php
include "public/layout/footer.php";
?>