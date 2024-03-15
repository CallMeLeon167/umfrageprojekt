<?php
namespace CML\DataStructure;

use CML\DataStructure\AnswerOption;

class Question extends Survey
{
    public $QuestionID;
    public $questionText;
    public $questionType;
    public $questionOrder;

    public $AnswerOptions;

    function __construct($_QuestionID,$_questionText,$_questionType,$_questionOrder)
    {
        $this->QuestionID = $_QuestionID;
        $this->questionText = $_questionText;
        $this->questionType = $_questionType;
        $this->questionOrder = $_questionOrder;

        $AnswerOptionsData = $this->sql2array_file("SELECT_QUESTIONSBYSURVEYID.sql", [$this->QuestionID]);        
        if(!is_null($AnswerOptionsData))
        {
            foreach($AnswerOptionsData[0] as $row)
            {              
                $q = new AnswerOption($row["id"], $row["ao_answerOptionText"], $row["ao_order"]);
                $cache[] = $q;

            }
        }        
        $this->AnswerOptions = $cache;
    }       
}
?>