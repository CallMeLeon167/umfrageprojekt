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

    public function getSurveyById($id, bool $populateQuestions = false, bool $populateAnswers = false, bool $populateComments = false, bool $populateReplys = false)
    {
        $result = $this->dbConn->sql2array("SELECT * FROM Survey WHERE id = ?", [$id]);
        if (empty($result)) {
            return null;
        }
        $survey = new Survey();
        $survey->hydrateFromDBRow($result[0]);
        if ($populateQuestions) {
            $questionsRepo = new QuestionRepository();
            $survey->questions = $questionsRepo->fetchSurveyQuestions($survey->id, $populateAnswers);
        }
        if ($populateComments) {
            $commentsRepo = new CommentRepository();
            $survey->comments = $commentsRepo->fetchSurveyComments($survey->id, $populateReplys);
        }

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
     * @throws \Exception
     */
    public function createSurvey($data): Survey
    {
        try {
            $survey = $this->parseSurveyFromJson($data);
            $stmt = <<<SQL
                    INSERT INTO Survey (s_topic, s_type, s_startdate, s_enddate, s_status, s_categoryID)
                    VALUES (?, ?, ?, ?, ?, ?)
                SQL;
            $result = $this->dbConn->sql2db($stmt, [
                $survey->topic ?? "null",
                $survey->type ?? "null",
                $survey->startdate ? date('Y-m-d H:i:s', $survey->startdate) : date('Y-m-d H:i:s'),
                $survey->enddate ? date('Y-m-d H:i:s', $survey->enddate) : date('Y-m-d H:i:s'),
                $survey->status ?? "open",
                $survey->categoryID ?? 1
            ]);
            $survey->id = $result['insert_id'];
            $this->createQuestions($survey);
            return $survey;

        } catch (\Exception $e) {
            // send 500 error
            throw new \Exception("Error creating survey: " . $e->getMessage(), 500);
        }
    }

    /**
     * Parse survey from JSON.
     *
     * This method parses a survey from a JSON object and returns it as a Survey object.
     * @param $data
     * @return Survey
     * @throws \Exception
     */
    private function parseSurveyFromJson($data): Survey
    {
        try {
            $survey = new Survey();
            $survey->topic = $data['topic'] ?? null;
            $survey->type = $data['type'] ?? null;
            $survey->startdate = $data['startdate'] ?? null;
            $survey->enddate = $data['enddate'] ?? null;
            $survey->status = $data['status'] ?? null;
            $survey->categoryID = $data['categoryID'] ?? null;
            $survey->questions = $this->parseQuestionsFromJSON($data);
            return $survey;
        } catch (\Exception $e) {
            throw new \Exception("Error parsing survey from JSON: " . $e->getMessage(), 500);
        }
    }

    /**
     * Parse answers from JSON.
     *
     * This method parses answers from a JSON object and returns them as an array of Answer objects.
     *
     * @param array $data The JSON data to parse the answers from.
     *
     * @return Question[] The array of Answer objects.
     * @throws \Exception
     */
    private function parseQuestionsFromJSON($data): array
    {
        try {
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
        } catch (\Exception $e) {
            throw new \Exception("Error parsing questions from JSON: " . $e->getMessage(), 500);
        }
    }

    /**
     * Parse answers from JSON.
     *
     * This method parses answers from a JSON object and returns them as an array of Answer objects.
     *
     * @param array $data The JSON data to parse the answers from.
     *
     * @return Answer[] The array of Answer objects.
     * @throws \Exception
     */
    private function parseAnswersFromJSON($data): array
    {
        try {

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
        } catch (\Exception $e) {
            throw new \Exception("Error parsing answers from JSON: " . $e->getMessage(), 500);
        }
    }

    /**
     * Create questions.
     *
     * This method creates quesion entries in the DB for a survey.
     *
     * @param Survey $survey The survey to create the questions for.
     * @throws \Exception
     */
    private function createQuestions(Survey $survey): void
    {
        try {

            foreach ($survey->questions as $question) {
                $stmt = <<<SQL
                    INSERT INTO Question (q_questionText, q_type, q_surveyID)
                    VALUES (?, ?, ?)
                SQL;
                $result = $this->dbConn->sql2db($stmt, [
                    $question->questionText ?? "null",
                    $question->questionType ?? "null",
                    $survey->id
                ]);
                $question->questionId = $result['insert_id'];
                $this->createAnswersForQuestion($question);
            }
        } catch (\Exception $e) {
            throw new \Exception("Error creating questions: " . $e->getMessage(), 500);
        }
    }


    /**
     * Create answers.
     *
     * This method creates answer entries in the DB for a question.
     *
     * @param Question $question The question to create the answers for.
     * @throws \Exception
     */
    private function createAnswersForQuestion(Question $question): void
    {
        try {

            foreach ($question->answerOptions as $answer) {
                $stmt = <<<SQL
                    INSERT INTO AnswerOption (ao_answerOptionText, ao_questionID)
                    VALUES (?, ?)
                SQL;
                $result = $this->dbConn->sql2db($stmt, [
                    $answer->answerOptionText ?? "null",
                    $question->questionId
                ]);
                $answer->answerOptionID = $result['insert_id'];
            }
        } catch (\Exception $e) {
            throw new \Exception("Error creating answers: " . $e->getMessage(), 500);
        }
    }
}