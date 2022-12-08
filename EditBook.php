<?php
include "public/layout/header.php";
require_once 'public/bootstrap.php';

use App\Model\Book;
use App\Services\BookManager;

$id = $_GET['id'];

$bookManager = new BookManager();

/** @var Book $book */
$book = $bookManager->getBookById($id);

$book->addEmptyValue();

?>
<h4>Edit book.</h4>
<form action="Edit.php" method="POST"><br>
    <input type="hidden" name="id" value="<?php echo $book->getId() ?>">
Name: <input type="text" name="name" value="<?php echo $book->getName() ?>" required><br>
Author: <input type="text" name="author" value="<?php echo $book->getAuthor() ?>" required><br>
Key words: <input type="text" name="keyWords" value="<?php echo implode(',' , $book->getKeyWords()) ?>"><br>
Edition: <input type="text" name="edition" value="<?php echo $book->getEdition() ?>"><br>
Domain: <input type="text" name="domain" value="<?php echo $book->getDomain() ?>"><br>
Year: <input type="number" name="year" min="1900" max="2022" value="<?php echo $book->getYear() ?>"><br>
    <button type="submit">Submit</button>
</form>

<?php
include "public/layout/footer.php";
?>