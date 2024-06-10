<?php 
namespace CML\DataStructure;


class AnswerOption
{
    public $answerOptionID;
    public $answerOptionText;
    public $answerOptionOrder;
    public $answerOptionQuestionID;

    function hydrateFromDBRow($row)
    {
        $this->answerOptionID = $row['id'];
        $this->answerOptionText = $row['ao_answerOptionText'];
        $this->answerOptionOrder = $row['ao_order'];
        $this->answerOptionQuestionID = $row['ao_questionID'];

        return $this;
    }       

    private function validateFields(array $row): bool
    {
        /*not implemented */
        return true;
    }
}
?>