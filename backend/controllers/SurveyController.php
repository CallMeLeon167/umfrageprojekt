<?php 
namespace CML\Controllers;
use CML\Classes\DB;
use CML\DataStructure\Survey;

class SurveyController extends DB
{
    
    public function getAllSurveys($params) 
    {
        //echo $this->sql2json_file("SELECT_SURVEYS.sql");     
        $s1 = new Survey(1);
    }
    
}
?>