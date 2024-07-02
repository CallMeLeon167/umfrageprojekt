<?php

    namespace CML\DataStructure;

    class Survey
    {
        /* @var int */
        public $id;
        /* @var string */
        public $topic;
        /* @var string */
        public $type;
        /* @var \DateTime */
        public $startdate;
        /* @var \DateTime */
        public $enddate;
        /* @var string */
        public $status;
        /* @var int */
        public $categoryID;
        /* @var User[] */
        public $participatingUsers;
        /* @var Category */
        public Category $category;
        /* @var Question[] */
        public array $questions;
        /* @var Comment[]*/
        public array $comments;

        public function hydrateSurveyFromDBRow(array $row): Survey|null
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