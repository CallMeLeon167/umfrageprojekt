<?php
namespace CML\DataStructure;
use CML\Classes\DB;

class Survey extends DB
{  
    public $id;
    public $categoryID;
    public $topic;
    public $type;
    public $startdate;
    public $enddate;
    public $status;

    public $Questions;
    public $participatingUsers;

    public DB $dbh;

    public function __construct($_id)
    {
        $this->dbh = new DB();
        $data = $this->dbh->sql2array_file("SELECT_SURVEYBYID.sql",[$_id]);
        
        if(!is_null($data ))
        {                
                $this->id = $data[0][0]["id"];
                $this->categoryID = $data[0][0]["s_categoryID"];
                $this->topic = $data[0][0]["s_topic"];
                $this->type = $data[0][0]["s_type"];
                $this->startdate = $data[0][0]["s_startdate"];
                $this->enddate = $data[0][0]["s_enddate"];
                $this->status = $data[0][0]["s_status"];
        }  

        $questionData = $this->dbh->sql2array_file("SELECT_QUESTIONSBYSURVEYID.sql", [$_id]);        
        if(!is_null($questionData))
        {
            foreach($questionData[0] as $row)
            {              
                $q = new Question($row["id"], $row["q_questionText"], $row["q_type"], $row["q_order"]);
                $cache[] = $q;

            }
        }        
        $this->Questions = $cache;

        $participatingUserData = $this->dbh->sql2array_file("SELECT_PARTICIPATINGUSERDATA.sql",[$_id]);
    }

    
}
?>