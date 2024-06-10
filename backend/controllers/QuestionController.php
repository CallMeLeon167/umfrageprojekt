<?php

namespace CML\Controllers;

use CML\Classes\DB;
use CML\DataStructure\Question;
use CML\DataStructure\QuestionRepository;

class QuestionController extends DB
{
    private QuestionRepository $questionRepository;

    public function __construct()
    {
        parent::__construct();
        $this->questionRepository = new QuestionRepository();
    }

    public function getAllQuestions($params)
    {
        //echo $this->sql2json_file("SELECT_SURVEYS.sql");     
        //        $s1 = new Survey(1);
        //        echo json_encode([$s1]);
        $questions = $this->questionRepository->getQuestions();
        echo json_encode($questions);
    }

    public function getQuestionByID($id)
    {
        $question = $this->questionRepository->getQuestionById($id);
        if (!$question) {
            http_response_code(404);
            echo json_encode(["message" => "Question not found"]);
            return;
        }
        echo json_encode($question);
    }

    /*public function deleteSurvey($data)
    {
        echo $this->sql2db_file("DELETE_SURVEY.sql", [$data['id']]);
    }

    public function createSurvey($data)
    {
        $this->sql2db_file("CREATE_SURVEY.sql", [$data['name'], $data['description']]);
    }*/
}
