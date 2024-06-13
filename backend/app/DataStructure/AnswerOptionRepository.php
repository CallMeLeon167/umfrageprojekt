<?php

    namespace CML\DataStructure;

    use CML\Classes\DB;

    class AnswerOptionRepository extends DB
    {

        private DB $dbConn;

        public function __construct()
        {
            parent::__construct();
            $this->dbConn = new DB();
        }

        public function getAnswerOptions(): array
        {
            $dbResult = $this->dbConn->sql2array("SELECT * FROM AnswerOption");
            /* @var $surveys Survey[] */
            $answerOptions = [];
            foreach ($dbResult as $row) {
                $answerOption = new AnswerOption();
                $answerOption->hydrateFromDBRow($row);
                $answerOptions[] = $answerOption;
            }
            return $answerOptions;
        }

        public function getAnswerOptionById($id)
        {
            $result = $this->dbConn->sql2array("SELECT * FROM AnswerOption WHERE id = ?", [$id]);
            if (empty($result)) {
                return null;
            }
            $answerOptions = new AnswerOption();
            $answerOptions->hydrateFromDBRow($result[0]);
            return $answerOptions;
        }

        /**
         * Fetch question answers.
         *
         * This method fetches the answers for a question from the database.
         *
         * @param int $questionId The ID of the question to fetch the answers for.
         *
         * @return AnswerOption[] The array of answers for the question.
         *
         * @throws \Exception
         */
        public function fetchQuestionAnswerOptions(int $questionId): array
        {
            $stmt = <<<SQL
                SELECT * FROM AnswerOption WHERE ao_questionID = ?;
            SQL;
            try {
                $result = $this->dbConn->sql2array($stmt, [$questionId]);
                /* @var $answerOptions AnswerOption[] */
                $answerOptions = [];
                foreach ($result as $row) {
                    $answerOption = new AnswerOption();
                    $answerOption->hydrateFromDBRow($row);
                    $answerOptions[] = $answerOption;
                }
                return $answerOptions;
            } catch (\Exception $e) {
                throw new \Exception("Error fetching question answers: " . $e->getMessage(), 500);
            }
        }

    }