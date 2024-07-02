<?php
namespace CML\DataStructure;

use CML\DataStructure\AnswerOption;

class Question extends Entity
{
    /* @var int */
    public $questionId;
    /* @var string */
    public $questionText;
    /* @var string */
    public $questionType;
    /* @var int */
    public $questionOrder;
    /* @var int */
    public $questionSurveyID;
    /* @var AnswerOption[] */
    public $answerOptions = [];
     
    protected function getFieldMappings(): array
    {
        return [
           "questionId"=> "id",
           "questionSurveyID"=> "q_surveyID",
           "questionText"=> "q_questionText",
           "questionType"=> "q_type",
           "questionOrder"=> "q_order"
        ];
    }

    protected function getRequiredFields(): array
    {
        return ["id", "q_questionText"];
    }

}
?>