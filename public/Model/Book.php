<?php

namespace App\Model;

class Book
{
    //Proprietatile classei Book
    private int $id;
    private string $name;
    private string $author;
    private string $edition;
    private array $keyWords;
    private int $year;
    private string $domain;


    //constructorul clasei care primeste ca parametru un array asociative cu toate proprietatile
    public function __construct(array $arrayProperty)
    {
        //parcurgerea proprietatilor
        foreach ($arrayProperty as $key=>$value){
            //daca proprietatea nu are valoare, nu e necesara popularea variabilei
            if(!$value){
                continue;
            }

            //cast pentru id de la string la int
            if($key === "id"){
                $this->id = (int) $value;
                continue;
            }
            //key1,key2 = ['key1','key2']
            if($key === "keyWords"){
                $this->keyWords = explode(' ',$value);
            }else {
                //caz pentru restul variabilelor
                $this->$key = $value;
            }
        }
    }

    //pentru toate variabilele care suntneinetializate,
    // initializeazale cu empty value pentru reprezentarea in tabelul de overview.
    public function addEmptyValue(){
        if(!isset($this->id)){
            $this->id = '';
        }
        if(!isset($this->name)){
            $this->name = '';
        }
        if(!isset($this->author)){
            $this->author = '';
        }
        if(!isset($this->edition)){
            $this->edition = '';
        }
        if(!isset($this->year)){
            $this->year = '';
        }
        if(!isset($this->domain)){
            $this->domain = '';
        }
        if(!isset($this->keyWords)){
            $this->keyWords[0]='';
        }
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getAuthor(): string
    {
        return $this->author;
    }

    /**
     * @return string
     */
    public function getEdition(): string
    {
        return $this->edition;
    }

    /**
     * @return array
     */
    public function getKeyWords(): array
    {
        return $this->keyWords;
    }

    /**
     * @return int
     */
    public function getYear(): int
    {
        return $this->year;
    }

    /**
     * @return string
     */
    public function getDomain(): string
    {
        return $this->domain;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }






}