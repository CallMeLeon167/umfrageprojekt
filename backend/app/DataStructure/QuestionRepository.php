<?php

    namespace CML\DataStructure;

    use CML\Classes\DB;

    class QuestionRepository extends DB
    {

        private DB $dbConn;

        public function __construct()
        {
            parent::__construct();
            $this->dbConn = new DB();
        }

        public function getQuestions(): array
        {
            $dbResult = $this->dbConn->sql2array("SELECT * FROM Question");
            /* @var $surveys Survey[] */
            $questions = [];
            foreach ($dbResult as $row) {
                $question = new Question();
                $question->hydrateFromDBRow($row);
                $questions[] = $question;
            }
            return $questions;
        }

        public function getQuestionById($id)
        {
            $result = $this->dbConn->sql2array("SELECT * FROM Survey WHERE id = ?", [$id]);
            if (empty($result)) {
                return null;
            }
            $Question = new Question();
            $Question->hydrateFromDBRow($result[0]);
            return $Question;
        }

    /**
     * Fetch survey questions.
     *
     * This method fetches the questions for a survey from the database.
     *
     * @param int $surveyId The ID of the survey to fetch the questions for.
     * @return Question[] The array of questions for the survey.
     * @throws \InvalidArgumentException
     */
    public function fetchSurveyQuestions($surveyId, bool $populateAnswers = false): array
    {
        $stmt = <<<SQL
            SELECT * FROM Question WHERE q_surveyID = ?;
        SQL;
        try {
            $questions = [];
            $result = $this->dbConn->sql2array($stmt, [$surveyId]);
            foreach ($result as $row) {
                $question = new Question();
                $question->hydrateFromDBRow($row);
                if ($populateAnswers) {
                    $answerOptionsRepo = new AnswerOptionRepository();
                    $question->answerOptions = $answerOptionsRepo->fetchQuestionAnswerOptions($question->questionId) ?? [];
                }
                $questions[] = $question;
            }
            return $questions;

        } catch (\Exception $e) {
            throw new \Exception("Error fetching survey questions: " . $e->getMessage(), 500);
        }
    }

}