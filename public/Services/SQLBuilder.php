<?php

namespace App\Services;

use App\Model\Filter;

//class pentru crearea diferitor query pe baza diferitor parametri
class SQLBuilder
{

    //metoda pentru generarea query-ului pentru select
    //Paramtri: denumirea tabelei si filtrele.
    public function getQuery(Filter $filters, String $tableName):string{

        $statements = [];
        //iterearea filtrelor
        foreach($filters as $field => $filter){
            //daca un filtru nu este setat, el va fi ignorat.
            if($filter == null){
                 continue;
            }
            //generarea perechilor de field-uri si valori .
            $statements = array_merge($statements, $this->getSimpleStatement($field, $filter));
        }

        return $this->buildQuery($statements, $tableName);
    }


    //metoda de crearea a query-ului
    private function buildQuery(array $statements, string $tableName):string{
        // nu este specificat nici o pereche de field si valoare, atunci se returneaza select-ul urmator
        if(!sizeof($statements)){
            return "SELECT * FROM $tableName";
        }
        //slectarea tuturor coloanelor din tabel cu numele dat ca parametru
        $query = "SELECT * FROM $tableName WHERE ";

        //adaugarea in query a tuturor perechilor de field si valoare.
        foreach ($statements as $key => $statement){
            if($key === 0){
                //pentru prima pereche doar adaugo
                $query.=$statement;
            }else{
                //daca sunt mai multe perechi, adauga si legatura dintre ele
                $query.=" AND $statement";
            }
        }

        return $query;
    }


    //metoda de generarea a query-ului pentru update
    public function getUpdateQuery(object $object):string{
        //obtinerea numelui obiectului cu namespace
        $obj = explode ("\\", get_class($object));
        //obtinerea numelui clasei
        $objectName = trim($obj[sizeof($obj)-1]);
        $mutation = "UPDATE $objectName SET ";
        //obtinerea namespace-ului clasei
        $objNamespace = get_class($object);
        $objNamespace = str_replace($objectName, '', $objNamespace).$objectName;

        //iterearea proprietatilor obiectului
        foreach ((array)$object as $key => $value){
            //daca proprietarea nu este setata, atunci ignoro.
            if($value){
                $key = trim(str_replace($objNamespace,'',$key));
                //ignora proprietatea id
                if($key === "id"){
                    continue;
                }

                //transforma in string proprietarea de tip array
                if(gettype($value)==='array'){
                    $mutation.=trim($key)."='".trim(implode(',' , $value))."',";
                }else{
                    $mutation.=trim($key)."='".$value."',";
                }
            }
        }

        $mutation = substr_replace($mutation, '',-1, 1);
        //adaugarea conditiei pentru selectarea recordului
        $mutation.=" WHERE id = ".$object->getId();

        return $mutation;
    }

    //metoda de generarea a query-ului pentru inserearea datelor
    public function getInsertMutation(object $object):string{
        //obtinerea numelui obiectului cu namespace
        $obj = explode ("\\", get_class($object));
        //obtinerea numelui clasei
        $objectName = trim($obj[sizeof($obj)-1]);
        $mutation = "INSERT INTO $objectName (";
        //obtinerea namespace-ului clasei
        $objNamespace = get_class($object);
        $objNamespace = str_replace($objectName, '', $objNamespace).$objectName;

        //iterearea proprietatilor obiectului
        foreach ((array)$object as $key => $value){
            if($value){
                $key = str_replace($objNamespace,'',$key);
                $mutation.=trim($key).",";
            }
        }
        $mutation = substr_replace($mutation, ')',-1, 1);
        $mutation.= " VALUES (";
        //iterearea valorilor proprietatilor obiectului
        foreach ((array)$object as $value){
            if($value){
                switch (gettype($value)){
                    case 'array':
                        if(sizeof($value)){
                            $mutation.='"'.trim(implode(',' , $value)).'",';
                        }
                        break;
                    case 'string':
                        $mutation.="'".trim($value)."',";
                        break;
                    case 'integer':
                        $mutation.="'".trim($value)."',";
                }
            }
        }
        return substr_replace($mutation, ')',-1, 1);
    }

    //metoda pentru obtinearea perechilor de field - valoare + operatia dintre ele
    private function getSimpleStatement(string $field, $filter):array {
        //pentru fiecare tip de proprietate se returneaza operatia respectiva
        return match (gettype($filter)) {
            'array' => $this->getArrayStatement($field, $filter),
            'string' => ["$field like '%$filter%'"],
            'integer' => ["$field = $filter"],
            default => [],
        };
    }

    //metoda pentru generarea statementului pentru proprietatile de tip array
    private function getArrayStatement(string $field, array $filters):array{
        $statements = [];

        //caz special pentru proprietarea an
        if($field === 'year'){
            if(isset($filters[0])){
                $statements[] = "$field >= $filters[0]";
            }
            if(isset($filters[1])){
                $statements[] = "$field <= $filters[1]";
            }
            return $statements;
        }


        //impartirea array-ului in variabile simple si generearea statementurilor.
        foreach($filters as $filter){
            $statements = array_merge($statements, $this->getSimpleStatement($field, $filter));
        }

        return $statements;
    }

}