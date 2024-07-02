<?php

namespace CML\DataStructure;

use CML\Classes\DB;

class UserResponseRepository extends DB
{

    private DB $dbConn;

    public function __construct()
    {
        parent::__construct();
        $this->dbConn = new DB();
    }

    public function getUserResponses(?string $surveyId = null): array
    {
        if ($surveyId) {
            $query = <<<SQL
                SELECT * FROM UserResponse
                JOIN SurveyParticipation ON UserResponse.ur_surveyParticipationID = SurveyParticipation.id
                WHERE SurveyParticipation.sp_surveyID = ?
            SQL;
            $dbResult = $this->dbConn->sql2array($query, [$surveyId]);
        } else {
            $query = "SELECT * FROM UserResponse";
            $dbResult = $this->dbConn->sql2array($query);
        }
        /* @var $userResponses UserResponse[] */
        $userResponses = [];
        foreach ($dbResult as $row) {
            $userResponse = new UserResponse();
            $userResponse->hydrateFromDBRow($row);
            $userResponses[] = $userResponse;
        }
        return $userResponses;
    }

    public function getUserResponseById($id)
    {
        $result = $this->dbConn->sql2array("SELECT * FROM UserResponse WHERE id = ?", [$id]);
        if (empty($result)) {
            return null;
        }
        $survey = new Survey();
        $survey->hydrateFromDBRow($result[0]);
        return $survey;
    }

    /**
     * Add a user response.
     *
     * This method adds a user response to the database.
     *
     * @param UserResponse $userResponse The user response to add.
     * @return bool True if the user response was added successfully, false otherwise.
     * @throws \Exception
     */
    public function addUserResponse(UserResponse $userResponse): bool
    {
        if (!$userResponse->surveyParticipationID
            || !$userResponse->questionID) {
            return false;
        }
        try {

        $stmt = <<<SQL
            INSERT INTO UserResponse (ur_answerOptionID, ur_surveyParticipationID, ur_questionID, ur_response)
            VALUES (?, ?, ?, ?)
        SQL;

        $params = [
            $userResponse->answerOptionID,
            $userResponse->surveyParticipationID,
            $userResponse->questionID,
            $userResponse->response
        ];

        $result = $this->dbConn->sql2db($stmt, $params);

        return isset($result['insert_id']);

        } catch (\Exception $e) {
            throw new \Exception("Failed to add user response: " . $e->getMessage());
        }
    }

    public function parseUserResponseFromJson($data): UserResponse
    {
        $userResponse = new UserResponse();
        $userResponse->answerOptionID = $data["answerId"] ?? null;
        $userResponse->surveyParticipationID = $data["surveyParticipationId"] ?? null;
        $userResponse->response = $data["answer"] ?? null;
        $userResponse->questionID = $data["questionId"] ?? null;
        return $userResponse;
    }

    /**
     * Process a survey participation.
     *
     * This method processes a survey participation and adds the user responses to the database.
     *
     * @param $surveyParticipationId The ID of the survey participation.
     * @param $surveyId The ID of the survey.
     * @param $answers The answers provided by the user.
     *
     * @return bool True if the survey participation was processed successfully, false otherwise.
     */
    public function processSurveyParticipation(
        string $surveyParticipationId,
        string $surveyId,
        array  $answers
    ): bool
    {
        try {
            foreach ($answers as $answer) {
                $userResponse = $this->parseUserResponseFromJson($answer);
                $userResponse->surveyParticipationID = $surveyParticipationId;
                $success = $this->addUserResponse($userResponse);
                if (!$success) {
                    return false;
                }
            }
            return true;
        } catch (\Exception $e) {
            throw new \Exception("Failed to process survey participation: " . $e->getMessage());
        }
    }

}