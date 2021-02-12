<?php
namespace App\Entity;


/**
 * Class Bar
 * @package App\Entity
*/
class Format
{

    /**
     * Bar constructor.
    */
    public function __construct()
    {
        echo __CLASS__."<br>";
    }


    /**
     * @return string
    */
    public function printText()
    {
        return 'Bar format';
    }
}