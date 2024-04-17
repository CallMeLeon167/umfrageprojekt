<?php 
namespace CML\DataStructure;
use CML\DataStructure\Question;

class AnswerOption extends Question
{
    function __construct(        
    public $QuestionAnswerID,
    public $QuestionAnswerOptionText,
    public $QuestionAnswerOptionOrder
    ){}
}
?>