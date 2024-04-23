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

    }