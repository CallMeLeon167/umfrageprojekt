<?php

namespace CML\Controllers;

use CML\Classes\DB;
use CML\DataStructure\Survey;
use CML\DataStructure\SurveyRepository;

class SurveyController extends DB
{
    private SurveyRepository $surveyRepository;

    public function __construct() {
        parent::__construct();
        $this->surveyRepository = new SurveyRepository();
    }

    public function getAllSurveys($params)
    {
        //echo $this->sql2json_file("SELECT_SURVEYS.sql");     
//        $s1 = new Survey(1);
//        echo json_encode([$s1]);
        $surveys = $this->surveyRepository->getSurveys();
        echo json_encode($surveys);
    }

    public function getSurveyById($id)
    {
        $survey = $this->surveyRepository->getSurveyById($id);
        if (!$survey) {
            http_response_code(404);
            echo json_encode(["message" => "Survey not found"]);
            return;
        }
        echo json_encode($survey);
    }

    public function deleteSurvey($data)
    {
        $this->sql2db_file("DELETE_SURVEY.sql", [$data['id']]);
    }

    public function createSurvey($data)
    {
        $this->sql2db_file("CREATE_SURVEY.sql", [$data['name'], $data['description']]);
    }
}
