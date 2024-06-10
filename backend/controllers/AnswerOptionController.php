<?php

namespace CML\Controllers;

use CML\Classes\DB;
use CML\DataStructure\AnswerOption;
use CML\DataStructure\AnswerOptionRepository;

class AnswerOptionController extends DB
{
    private AnswerOptionRepository $answerOptionRepository;

    public function __construct()
    {
        parent::__construct();
        $this->answerOptionRepository = new AnswerOptionRepository();
    }

    public function getAllAnswerOptions($params)
    {
        //echo $this->sql2json_file("SELECT_SURVEYS.sql");     
        //        $s1 = new Survey(1);
        //        echo json_encode([$s1]);
        $answerOptions = $this->answerOptionRepository->getAnswerOptions();
        echo json_encode($answerOptions);
    }

    public function getAnswerOptionByID($id)
    {
        $answerOption = $this->answerOptionRepository->getAnswerOptionById($id);
        if (!$answerOption) {
            http_response_code(404);
            echo json_encode(["message" => "AnswerOption not found"]);
            return;
        }
        echo json_encode($answerOption);
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
