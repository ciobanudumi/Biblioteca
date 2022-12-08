<?php
include "public/layout/header.php";
require_once 'public/bootstrap.php';

use App\Model\Filter;
use App\Services\BookManager;

foreach($_GET as $key=>$value){
    if($value == ''){
        unset($_GET[$key]);
    }
}
?>
<h4>Overview</h4>
<form action="overview.php" method="GET">
    Name: <input type="text" name="name" value="<?php if(isset($_GET['name'])) echo $_GET['name']?>">
    Author: <input type="text" name="author" value="<?php if(isset($_GET['author'])) echo $_GET['author']?>">
    Key words: <input type="text" name="keyWords" value="<?php if(isset($_GET['keyWords'])) echo $_GET['keyWords']?>">
    Edition: <input type="text" name="edition" value="<?php if(isset($_GET['edition'])) echo $_GET['edition']?>">
    Domain: <input type="text" name="domain" value="<?php if(isset($_GET['domain'])) echo $_GET['domain']?>">
    Year1: <input type="number" name="year1" min="1900" max="2022" value="<?php if(isset($_GET['year1'])) echo $_GET['year1']?>">
    Year2: <input type="number" name="year2" min="1900" max="2022" value="<?php if(isset($_GET['year2'])) echo $_GET['year2']?>">
    <button type="submit">Submit</button>
</form>
<br>
    <?php
        $filters = new Filter($_GET);
        $BookManager = new BookManager();
        $BookManager->fetchBook($filters);
        $BookManager->printTable();
    ?>

<?php
include "public/layout/footer.php";
?>