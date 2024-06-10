<?php 
namespace CML\DataStructure;


class AnswerOption
{
    public $AnswerOptionID;
    public $AnswerOptionText;
    public $AnswerOptionOrder;
    public $AnswerOptionQuestionID;

    function hydrateFromDBRow($row)
    {
        $this->AnswerOptionID = $row['id'];
        $this->AnswerOptionText = $row['ao_answerOptionText'];
        $this->AnswerOptionOrder = $row['ao_order'];
        $this->AnswerOptionQuestionID = $row['ao_questionID'];

        return $this;
    }       

    private function validateFields(array $row): bool
    {
        /*not implemented */
        return true;
    }
}
?>