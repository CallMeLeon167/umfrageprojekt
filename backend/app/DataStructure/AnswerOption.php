<?php 
namespace CML\DataStructure;


class AnswerOption extends Entity
{
    public $answerOptionID;
    public $answerOptionText;
    public $answerOptionOrder;
    public $answerOptionQuestionID;

    protected function getFieldMappings(): array
    {
        return [
            "answerOptionID" => "id",
            "answerOptionText" => "ao_answerOptionText",
            "answerOptionOrder" => "ao_order",
            "answerOptionQuestionID" => "ao_questionID"
        ];
    }

    protected function getRequiredFields(): array
    {
        return [];
    }
}
?>