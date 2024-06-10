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

    }