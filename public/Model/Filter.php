<?php

namespace App\Model;

class Filter
{

    //Proprietatile classei Filter
    public int $id;
    public string $name;
    public string $author;
    public array $keyWords;
    public string $edition;
    public string $domain;
    public array $year;

    //constructorul clasei care primeste ca parametru un array asociative cu toate filtrele
    public function __construct(array $array)
    {
        //parcurgerea proprietatilor
        foreach ($array as $key=>$value){
            //key1,key2 = ['key1','key2']
            if($key === 'keyWords'){
                $this->keyWords = explode(' ',$value);
                continue;
            }
            //setarea filtrului year1
            if($key === 'year1'){
                $this->year[0] = (integer) $value;
                continue;
            }
            //setarea filtrului year2
            if($key === 'year2'){
                $this->year[1] = (integer) $value;
                continue;
            }
            $this->$key = $value;
        }
    }

}