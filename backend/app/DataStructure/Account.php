<?php 
namespace CML\DataStructure;
use CML\DataStructure\Survey;

class Account extends Survey
{
    public $AccountID;
    public $Username;
    public $givenAnswers;

    public function __construct($AccountID, $Username)
    {
        $this->AccountID = $AccountID;
        $this->Username = $Username;
        $cache = $this->sql2array_file("SELECT_USERRESPONSEBYACCOUNTID.sql",[$AccountID]);

        foreach($cache[0] as $row)
        {
            $this->givenAnswers["Antwort"] = $row["ur_response"];
            $this->givenAnswers["Question ID"] = $row["ur_questionID"];
        }
        
    }


}
?>