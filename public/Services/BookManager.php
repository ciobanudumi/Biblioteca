<?php

namespace App\Services;


use App\Model\Book;
use App\Model\Filter;

class BookManager
{
    //clasa pentru managementul cartilor
    //permite adaugarea, stergerea, primirea si editarea cartilor
    //lista de carti
    private array $books;
    //Sql builder pentru a genera query pentru selectie si inserare
    private SQLBuilder $SQLBuilder;
    //conexiunea cu baza de date
    private DbConnection $db;


    //constructorul classei
    public function __construct()
    {
        try {
            //Crearea connexiunii cu baza de date
            $this->db = new DbConnection();
            //Crearea unui Sql builder
            $this->SQLBuilder = new SQLBuilder();
        }catch(\Exception $e){
            //tratarea exceptiilor ce pot aparea la crearea  connexiunii cu baza de date si Sql builder-ului
            echo $e->getMessage(); die;
        }
    }

    //obtinerea cartilor din DB
    public function fetchBook(Filter $filter){
        //obtinerea query-ului pentru selectrarea datelor din db
        $query = $this->SQLBuilder->getQuery($filter,'Book');
        $this->books = $this->db->getRecords($query);
    }

    //obtinerea unei singure carti din DB dupa id-ul sau
    public function getBookById($id){
        $id = (int)$id;
        //crearea unui filtru doar cu fieldul de id
        $filter = new Filter(['id'=>$id]);
        //obtinerea query-ului pentru selectrarea unei singure carti din DB
        $query = $this->SQLBuilder->getQuery($filter,'Book');

        //returnarea obiectului obtinut
        return $this->db->getRecords($query)[0];
    }

    //functia de editarea a unei carti
    public function editBook(array $arrayProperty){
        //Crearea unui obiect de tip carte pentru
        $book = new Book($arrayProperty);
        //generarea unui query pe baza noului obiect de tip book
        $mutation = $this->SQLBuilder->getUpdateQuery($book);
        //updatarea cartii in baza de date
        $this->db->updateRecord($mutation);
    }


    //functia de adaugarea a unei carti
    public function addBook(array $arrayProperty){
        //crearea unei carti noi
        $book = new Book($arrayProperty);
        //pe baza cartii sa creaza query-ul de inserare
        $mutation = $this->SQLBuilder->getInsertMutation($book);
        //inserarea in baza de date
        $this->db->insertRecord($mutation);
    }


    //functia de stergere a unei carti din baza de date dupa un id dat
    public function deleteBook($id){
        //stergerea cartii din baza de date
        $this->db->deleteRecord("DELETE FROM BOOK WHERE id = ".$id);
    }

    //printarea tabelei
    public function printTable(){
        //verificarea daca au fost primite carti din baza de date si au fost adaugate in managerul de carti
        if(sizeof($this->books)) {
            //daca exista carti atunci afiseaza tabela
            echo "<table style='border:1px solid black'>" . $this->getHTMLHead($this->books[0]).$this->getHTMLRows(). "</table>";
        }else{
            //daca nu existga carti atunci afiseaza mesajul urmator
            echo "No data to show";
        }
    }


    //functia pentru obtinerea denumirilor coloanelor
    private function getHTMLHead($book):string{
        //adaugarea tagului <tr> si stilurile sale
        $head = "<tr style='border:1px solid black'>";
        //iterearea proprietatilor obiectului de tip carte
        foreach ((array)$book as $propertyName=>$property){
            //adaugarea denumirei coloanelor
            $head.="<th style='border:1px solid black'>".str_replace(Book::class,'', $propertyName)."</th>";
        }
        //adaugarea coloanei pentru butonul de edit
        $head = $head."<th style='border:1px solid black'>Edit</th>";
        //adaugarea coloanei pentru butonul de delete
        $head = $head."<th style='border:1px solid black'>Delete</th>";
        return $head."</tr>";
    }

    //functia pentru generarea randurilor tabelului pe baza cartilor
    private function getHTMLRows():string{
        $rows = "";

        //iterarea cartilor;
        foreach ($this->books as $book) {
            //adaugarea valorilor empty pentru proprietatile ne initializate ale cartilor
            $book->addEmptyValue();
            $rows .= "<tr style='border:1px solid black'>";
            //iterearea fiecaror proprietati a fiecarei carti in parte
            foreach ((array)$book as $property) {
                //in situatia proprietatii de tip array, array se transforma in string
                if (gettype($property) === 'array') {
                    $rows .= "<td style='border:1px solid black'>" . implode(' ', $property) ?? ' ' . "</td>";
                } else {
                    $rows .= "<td style='border:1px solid black'>".$property ?? ' ' ."</td>";
                }
            }
            //adaugarea butonului de edit
            $rows .= "<td style='border:1px solid black'><a href='http://localhost/MSIC_TEMA_4/EditBook.php?id=" . $book->getId() . "'><button>Edit</button></a></td>";
            //adaugarea butonului de delete
            $rows .= "<td style='border:1px solid black'><a href='http://localhost/MSIC_TEMA_4/DeleteBook.php?id=" . $book->getId() . "'><button>Delete</button></a></td>";
            $rows .= "</tr>";
        }
        return $rows;
    }
}