<?php

namespace CML\Controllers;

use CML\Classes\DB;
use CML\Classes\Functions\Functions;
use CML\DataStructure\Question;
use CML\DataStructure\Survey;
use CML\DataStructure\SurveyParticipationRepository;
use CML\DataStructure\SurveyRepository;
use CML\DataStructure\UserResponseRepository;

/**
 * Class SurveyController
 *
 * This class extends the DB class and is responsible for handling operations related to surveys.
 * It uses the SurveyRepository to interact with the database.
 */
class SurveyController extends DB
{
    /**
     * @var SurveyRepository $surveyRepository
     *
     * An instance of the SurveyRepository class.
     */
    private SurveyRepository $surveyRepository;

    /**
     * @var SurveyParticipationRepository $participationRepository
     *
     * An instance of the SurveyParticipationRepository class.
     */
    private SurveyParticipationRepository $participationRepository;

    /**
     * @var UserResponseRepository $userResponseRepository
     *
     * An instance of the UserResponseRepository class.
     */
    private UserResponseRepository $userResponseRepository;


    use Functions;

    /**
     * SurveyController constructor.
     *
     * Initializes the SurveyRepository.
     */
    public function __construct()
    {
        parent::__construct();
        $this->surveyRepository = new SurveyRepository();
        $this->participationRepository = new SurveyParticipationRepository();
        $this->userResponseRepository = new UserResponseRepository();
    }

    /**
     * Get all surveys.
     *
     * This method retrieves all surveys from the database and returns them as a JSON response.
     *
     * @param array $params The parameters passed to the method.
     */
    public function getAllSurveys($params)
    {
        $surveys = $this->surveyRepository->getSurveys();
        echo json_encode($surveys);
    }

    /**
     * Get a survey by its ID.
     *
     * This method retrieves a survey by its ID from the database and returns it as a JSON response.
     * If the survey is not found, it returns a 404 response with a message.
     *
     * @param int $id The ID of the survey to retrieve.
     */
    public function getSurveyById($data)
    {
        if (!isset($data['id'])) {
            http_response_code(400);
            echo json_encode(["message" => "Invalid input"]);
            return;
        }
        // Get URL parameters
        
        $params = $this->getQueryParams("populateQuestions","populateAnswers","populateComments","populateReplys");

        $survey = $this->surveyRepository->getSurveyById($data['id'],
            $params["populateQuestions"] ?? false,
            $params["populateAnswers"] ?? false,
            $params["populateComments"] ?? false,
            $params["populateReplys"] ?? false
        );
        if (!$survey) {
            http_response_code(404);
            echo json_encode(["message" => "Survey not found"]);
            return;
        }
        echo json_encode($survey);
    }

    /**
     * Delete a survey.
     *
     * This method deletes a survey from the database.
     *
     * @param array $data The data passed to the method, including the ID of the survey to delete.
     */
    public function deleteSurvey($data)
    {
        echo $this->sql2db_file("DELETE_SURVEY.sql", [$data['id']]);
    }

    /**
     * Create a survey.
     *
     * This method creates a new survey in the database.
     */
    public function newSurvey()
    {
        $body = json_decode(file_get_contents('php://input'), true);
        if (!$body) {
            http_response_code(400);
            echo json_encode(["message" => "Invalid input"]);
            return;
        }
        $this->surveyRepository->createSurvey($body);
    }

    /**
     * Get Survey Results
     *
     * This method returns evaluated survey
     */
    public function surveyResults(array $params): void
    {
        $surveyId = $params['id'] ?? null;
        // Check if the survey ID is provided
        if (!$surveyId) {
            http_response_code(400);
            echo json_encode(["message" => "Invalid Survey Id"]);
            return;
        }

        // fetch all survey participations
        $participations = $this->participationRepository->getParticipationsForSurvey($surveyId);
        if (!$participations) {
            http_response_code(404);
            echo json_encode(["message"=> "No participations found"]);
            return;
        }

        $answers = $this->userResponseRepository->getUserResponses($surveyId);

        $result = [];
        foreach ($answers as $answer) {
            $result["answers"][$answer->questionID][] = $answer->answerOptionID ?
                $answer->answerOptionID : $answer->response;
        }
        $result["participations"] = count($participations);

        echo json_encode($result);
    }

    
    private function parseUrlParams($url): array {
        $params = [];
        if (!$url || !str_contains($url, '?')) {
            return [];
        }
        $paramsString = parse_url($url, PHP_URL_QUERY);
        $paramsArray = explode('&', $paramsString);
        foreach ($paramsArray as $param) {
            $paramParts = explode('=', $param);
            $params[$paramParts[0]] = $paramParts[1];
        }
        return $params;
    }

}