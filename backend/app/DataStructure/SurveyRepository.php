<?php

    namespace CML\DataStructure;

    use CML\Classes\DB;

    class SurveyRepository extends DB
    {

        private DB $dbConn;

        public function __construct()
        {
            parent::__construct();
            $this->dbConn = new DB();
        }

        public function getSurveys(): array
        {
            $dbResult = $this->dbConn->sql2array("SELECT * FROM Survey");
            /* @var $surveys Survey[] */
            $surveys = [];
            foreach ($dbResult as $row) {
                $survey = new Survey();
                $survey->hydrateFromDBRow($row);
                $surveys[] = $survey;
            }
            return $surveys;
        }

        public function getSurveyById($id)
        {
            $result = $this->dbConn->sql2array("SELECT * FROM Survey WHERE id = ?", [$id]);
            if (empty($result)) {
                return null;
            }
            $survey = new Survey();
            $survey->hydrateFromDBRow($result[0]);
            return $survey;
        }

        /**
         * Create a survey.
         *
         * This method creates a survey from the given data and returns it as a Survey object.
         *
         * @param array $data The data to create the survey from.
         *
         * @return Survey The created survey.
         */
        public function createSurvey($data): Survey
        {
            $survey = $this->parseSurveyFromJson($data);
            $stmt = <<<SQL
                INSERT INTO Survey (s_topic, s_type, s_startdate, s_enddate, s_status, s_categoryID)
                VALUES (?, ?, ?, ?, ?, ?)
            SQL;
            try {
                $result = $this->dbConn->sql2array($stmt, [
                    $survey->topic ?? "null",
                    $survey->type ?? "null",
                    $survey->startdate ? date('Y-m-d H:i:s', strtotime($survey->startdate)) : date('Y-m-d H:i:s'),
                    $survey->enddate ? date('Y-m-d H:i:s', strtotime($survey->enddate)) : date('Y-m-d H:i:s'),
                    $survey->status ?? "open",
                    $survey->categoryID ?? 1
                ]);
            } catch (\Exception $e) {
                echo $e->getMessage();
            }
            $survey->id = $result['insert_id'];
            return $survey;
        }

        /**
         * Parse survey from JSON.
         *
         * This method parses a survey from a JSON object and returns it as a Survey object.
         * @param $data
         * @return Survey
         */
        private function parseSurveyFromJson($data): Survey
        {
            $survey = new Survey();
            $survey->topic = $data['topic'] ?? null;
            $survey->type = $data['type'] ?? null;
            $survey->startdate = $data['startdate'] ?? null;
            $survey->enddate = $data['enddate'] ?? null;
            $survey->status = $data['status'] ?? null;
            $survey->categoryID = $data['categoryID'] ?? null;
            $survey->questions = $this->parseQuestionsFromJSON($data);
            return $survey;
        }

        /**
         * Parse answers from JSON.
         *
         * This method parses answers from a JSON object and returns them as an array of Answer objects.
         *
         * @param array $data The JSON data to parse the answers from.
         *
         * @return Question[] The array of Answer objects.
         */
        private function parseQuestionsFromJSON($data): array {
            if (empty($data['questions'])) {
                return [];
            }
            $questions = [];
            foreach ($data['questions'] as $questionData) {
                $question = new Question();
                $question->questionText = $questionData['question'] ?? null;
                $question->questionType = $questionData['type'] ?? null;
                $question->answerOptions = $this->parseAnswersFromJSON($questionData);
                $questions[] = $question;
            }
            return $questions;
        }

        /**
         * Parse answers from JSON.
         *
         * This method parses answers from a JSON object and returns them as an array of Answer objects.
         *
         * @param array $data The JSON data to parse the answers from.
         *
         * @return Answer[] The array of Answer objects.
         */
        private function parseAnswersFromJSON($data): array
        {
            if (empty($data['answeroptions'])) {
                return [];
            }
            $answers = [];
            foreach ($data['answeroptions'] as $answerData) {
                $answer = new AnswerOption();
                $answer->answerOptionText = $answerData ?? null;
                $answers[] = $answer;
            }
            return $answers;
        }

    }