<?php
namespace CML\DataStructure;

class Question extends Survey
{
    public $QuestionID;
    public $questionText;
    public $questionType;
    public $questionOrder;

    function __construct($_QuestionID,$_questionText,$_questionType,$_questionOrder)
    {
        $this->QuestionID = $_QuestionID;
        $this->questionText = $_questionText;
        $this->questionType = $_questionType;
        $this->questionOrder = $_questionOrder;
    }       
}
?>