<?php 
namespace CML\DataStructure;
use CML\DataStructure\Question;

class AnswerOption extends Question
{
    public $AnswerOptionID;
    public $AnswerOptionText;
    public $AnswerOptionOrder;

    function __construct($id,$ao_answerOptionText,$ao_order)
    {
        $this->AnswerOptionID = $id;
        $this->AnswerOptionText = $ao_answerOptionText;
        $this->AnswerOptionOrder = $ao_order;

    }
}
?>