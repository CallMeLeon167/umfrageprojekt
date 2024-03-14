<?php 
namespace CML\DataStructure;
use CML\DataStructure\Question;

class AnswerOption extends Question
{
    public $QuestionAnswerID;
    public $QuestionAnswerOptionText;
    public $QuestionAnswerOptionOrder;


    function __construct($_questionAnswerID, $_questionAnswerOptionText, $_questionAnswerOptionOrder)
    {
        $this->QuestionAnswerID = $_questionAnswerID;
        $this->QuestionAnswerOptionText = $_questionAnswerOptionText;
        $this->QuestionAnswerOptionOrder = $_questionAnswerOptionOrder;
    }
}
?>