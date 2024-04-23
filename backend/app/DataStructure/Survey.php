<?php

    namespace CML\DataStructure;

    class Survey
    {
        public $id;
        public $topic;
        public $type;
        public $startdate;
        public $enddate;
        public $status;
        public $categoryID;

        public $questions;
        public $participatingUsers;


        public function hydrateFromDBRow(array $row): Survey|null
        {
            if (!$this->validateFields($row)) {
                return null;
            }
            $this->id = $row["id"];
            $this->topic = $row["s_topic"];
            $this->type = $row["s_type"];
            $this->startdate = $row["s_startdate"];
            $this->enddate = $row["s_enddate"];
            $this->status = $row["s_status"];
            $this->categoryID = $row["s_categoryID"];
            return $this;
        }

        private function validateFields(array $row): bool
        {
            $requiredFields = ["id", "s_topic"];

            foreach ($requiredFields as $field) {
                if (!array_key_exists($field, $row)) {
                    return false;
                }
            }
            return true;
        }
    }

    ?>