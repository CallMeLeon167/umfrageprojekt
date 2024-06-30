<?php

namespace CML\Controllers;

use CML\Classes\DB;
use CML\DataStructure\SurveyParticipationRepository;
use CML\DataStructure\UserResponseRepository;

class SurveyParticipationController extends DB
{

    private UserResponseRepository $userResponseRepository;
    private SurveyParticipationRepository $surveyParticipationRepository;

    public function __construct()
    {
        parent::__construct();
        $this->userResponseRepository = new UserResponseRepository();
        $this->surveyParticipationRepository = new SurveyParticipationRepository();
    }

    public function getTest($params)
    {

        // $arrID = ['id' => $params['id']];
        // $news = DB::sql2array("SELECT * FROM news");
        // return $news;
        
        // Write your logic here
    }

    public function submitSurveyParticipation($data): void
    {
        try {
            $body = json_decode(file_get_contents('php://input'), true);
            $surveyId = $body['surveyId'] ?? null;
            $userId = $body['userId'] ?? null;
            $answers = $body['answers'] ?? null;

            if (!$surveyId || !$userId || !$answers) {
                http_response_code(400);
                echo json_encode(['success' => false, 'message' => "Survey ID and User ID must be provided."]);
                return;
            }
            if ($this->surveyParticipationRepository->userParticipatedInSurvey($surveyId, $userId)) {
                http_response_code(403);
                echo json_encode(['success' => false, 'message' => "User has already participated in this survey."]);
                return;
            }

            $surveyParticipationId = $this->surveyParticipationRepository->addSurveyParticipation($surveyId, $userId);
            $success = $this->userResponseRepository->processSurveyParticipation($surveyParticipationId, $surveyId, $answers);
            if ($success) {
                echo json_encode(['success' => true, 'message' => "Survey participation submitted successfully."]);
            } else {
                http_response_code(500);
                echo json_encode(['success' => false, 'message' => "Failed to submit survey participation."]);
            }
            return;
        } catch (\Exception $e) {
            http_response_code(500);
            echo json_encode(['success' => false, 'message' => $e->getMessage()]);
            return;
        }
    }
}
