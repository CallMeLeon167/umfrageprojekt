<?php
namespace CML\DataStructure;

use CML\DataStructure\AnswerOption;

class Question
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

    function hydrateFromDBRow($row): Question
    {
        $this->questionId = $row['id'];
        $this->questionSurveyID = $row['q_surveyID'] ?? "null";
        $this->questionText = $row['q_questionText'] ?? "null";
        $this->questionType = $row['q_questionType'] ?? "null";
        $this->questionOrder = $row['q_questionOrder'] ?? "null";

        return $this;
    }       

    private function validateFields(array $row): bool
    {
        /*not implemented */
        return true;
    }
}
?>