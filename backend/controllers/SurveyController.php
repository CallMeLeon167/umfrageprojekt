<?php 
namespace CML\Controllers;
use CML\Classes\DB;
class SurveyController extends DB
{
    
    public function getAllSurveys($params) 
    {
        extract($params);
        echo $this->sql2json_file("SELECT_USERBYUSERNAME.sql", [$username]);

    }
    
}
?>