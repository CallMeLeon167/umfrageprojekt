<?php 
namespace CML\Controllers;
use CML\Classes\DB;
class SurveyController extends DB
{
    
    public function getAllSurveys($params) 
    {
        echo $this->sql2json_file("SELECT_SURVEYS.sql");
    }
    
}
?>