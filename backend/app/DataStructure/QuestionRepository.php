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

    }