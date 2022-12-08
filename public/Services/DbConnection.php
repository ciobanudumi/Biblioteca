<?php

namespace App\Services;

use App\Model\Book;
use Exception;
use mysqli;

    //conexiunea cu baza de date.
class DbConnection
{
    //proprietatile variabilelor
    private string $hostName = 'localhost';
    private string $username = 'root';
    private string $password = '';
    private string $dbName = 'books';
    private string $port = '3306';
    private mysqli $conn;

    //construcortul clasei
    public function __construct()
    {
        //crearea unei noi conexiuni mysql cu baza de date
        $this->conn = new mysqli($this->hostName, $this->username, $this->password, $this->dbName, $this->port);
        //daca apare o eroarea la crearea connexiunii se arunca o eroarea.
        if($this->conn->connect_error){
            //aruncarea erorii aparute la connexiunea cu baza de date
            throw new Exception('Connection failed :'. $this->conn->connect_error);
        }
    }

    //obtinerea tuturor cartilor din baza de date, pe folosind query-ului trimis ca parametru
    public function getRecords(string $query):array{
        //executarea query-ului
        $data = $this->conn->query($query);
        $records = [];
        //daca query-ul a returnat macar un record, atunci ele trebuie prelucrate
        if($data->num_rows > 0){
        //parcurgerea tuturor record-urilor obtinute
            while($row = $data->fetch_assoc()){
                //serializarea datelor
                $records[] = new Book($row);
            }
        }
        return $records;
    }


    //functia de stergere din baza de date a unui record. Parametru: sql-ul de stergere.
    public function deleteRecord($sql){
        $this->conn->query($sql);
    }
    //functia de update-are a unui record din baza de date. Parametru: sql-ul de update.
    public function updateRecord($sql){
        $this->conn->query($sql);
    }
    //metoda de inserare a unui record in baza de date. Parametru: sql-ul de inserare.
    public function insertRecord(string $mutation):bool{
        // in caz ca inserarea a esuat, functia returneaza false, in caz contrar true.
        if ($this->conn->query($mutation) === true) {
            return true;
        } else {
            return false;
        }
    }

    //La destrugerea obiectului de tip DbConnection, conexiunea cu baza de date va fi inchisa.
    public function __destructor(){
        $this->conn->close();
    }
}