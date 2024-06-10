<?php
namespace CML\DataStructure;

use CML\DataStructure\AnswerOption;

class Question
{
    /* @var int */
    public $QuestionID;
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

    function hydrateFromDBRow($row)
    {
        $this->QuestionID = $row['id'];
        $this->questionText = $row['q_questionText'];
        $this->questionType = $row['q_questionType'];
        $this->questionOrder = $row['q_questionOrder'];
        $this->questionSurveyID = $row['q_surveyID'];

        return $this;
    }       

    private function validateFields(array $row): bool
    {
        /*not implemented */
        return true;
    }
}
?>