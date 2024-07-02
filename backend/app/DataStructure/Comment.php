<?php

    namespace CML\DataStructure;

    class Comment
    {
        /* @var int */
        public $id;
        /* @var int */
        public $accountID;
        /* @var varchar */
        public $commentText;
        /* @var int */
        public $likeCount;
        /* @var datetime */
        public $constitutionDate;
        /* @var int */
        public $surveyID;
        /* @var reply */
        public array $replys;

        public function hydrateFromDBRow(array $row): Comment|null
        {
            if (!$this->validateFields($row)) {
                return null;
            }
            $this->id = $row["id"];
            $this->accountID = $row["com_accountID"];
            $this->commentText = $row["com_commentText"];
            $this->likeCount = $row["com_likeCount"];
            $this->constitutionDate = $row["com_constitutionDate"];
            $this->surveyID = $row["com_surveyID"];
            return $this;
        }

        private function validateFields(array $row): bool
        {
            $requiredFields = ["id", "com_commentText"];

            foreach ($requiredFields as $field) {
                if (!array_key_exists($field, $row)) {
                    return false;
                }
            }
            return true;
        }
    }