<?php

    namespace CML\DataStructure;

    use CML\Classes\DB;

    class SurveyRepository extends DB {

        private DB $dbConn;

        public function __construct() {
            parent::__construct();
             $this->dbConn = new DB();
        }

        public function getSurveys() {
            return $this->dbConn->sql2array("SELECT * FROM Survey");
        }

        public function getSurveyById($id) {
            return $this->dbConn->sql2array("SELECT * FROM Survey WHERE id = ?", [$id]);
        }

    }