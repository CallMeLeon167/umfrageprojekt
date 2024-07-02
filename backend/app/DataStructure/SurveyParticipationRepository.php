<?php declare(strict_types=1);

namespace CML\DataStructure;

use CML\Classes\DB;

class SurveyParticipationRepository extends DB
{
    private DB $dbConn;

    public function __construct()
    {
        parent::__construct();
        $this->dbConn = new DB();
    }


    /**
     * Add a survey participation.
     *
     * This method adds a survey participation to the database.
     *
     * @param int $surveyID The ID of the survey.
     * @param int $userID The ID of the user.
     * @return int The ID of the survey participation.
     * @throws \Exception
     */
    public function addSurveyParticipation(int $surveyID, int $userID): int
    {
        try {
            if (!$surveyID || !$userID) {
                throw new \Exception("Survey ID and User ID must be provided.");
            }
            if (!$this->dbConn->sql2array("SELECT * FROM Survey WHERE id = ?", [$surveyID])) {
                throw new \Exception("Survey with ID $surveyID does not exist.");
            }
            if (!$this->dbConn->sql2array("SELECT * FROM Account WHERE id = ?", [$userID])) {
                throw new \Exception("User with ID $userID does not exist.");
            }

            $stmt = <<<SQL
                INSERT INTO SurveyParticipation (sp_surveyID, sp_accountID, sp_timestamp) 
                VALUES (?, ?, NOW())
            SQL;
            $result = $this->dbConn->sql2db($stmt, [$surveyID, $userID]);
            return $result['insert_id'];
        } catch (\Exception $e) {
            throw new \Exception("Failed to add survey participation: " . $e->getMessage());
        }
    }

    /**
     * Check if a user has participated in a survey.
     *
     * This method checks if a user has participated in a survey.
     *
     * @param int $surveyID The ID of the survey.
     * @param int $userID The ID of the user.
     * @return bool True if the user has participated in the survey, false otherwise.
     * @throws \Exception
     */
    public function userParticipatedInSurvey(int $surveyID, int $userID): bool
    {
        try {
            $stmt = <<<SQL
            SELECT * FROM SurveyParticipation WHERE sp_surveyID = ? AND sp_accountID = ?
           SQL;
            $result = $this->dbConn->sql2array($stmt, [$surveyID, $userID]);
            return !empty($result);
        } catch (\Exception $e) {
            throw new \Exception("Failed to check if user participated in survey: " . $e->getMessage());
        }
    }

    /**
     * Get all participations for a survey.
     *
     * This method returns all participations for a survey.
     *
     * @param int $surveyID The ID of the survey.
     * @return array An array of participations for the survey.
     * @throws \Exception
     */
    public function getParticipationsForSurvey(int $surveyID): array
    {
        try {
            $stmt = <<<SQL
                SELECT * FROM SurveyParticipation WHERE sp_surveyID = ?
            SQL;
            $result = $this->dbConn->sql2array($stmt, [$surveyID]);
            return $result;
        } catch (\Exception $e) {
            throw new \Exception("Failed to get participations for survey: " . $e->getMessage());
        }
    }

}