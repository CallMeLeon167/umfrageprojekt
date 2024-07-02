<?php

    namespace CML\DataStructure;

    class Reply
    {
        /* @var int */
        public $id;
        /* @var int */
        public $accountID;
        /* @var int */
        public $commentID;
        /* @var varchar */
        public $replyText;
        /* @var int */
        public $likeCount;

        public function hydrateFromDBRow(array $row): Category|null
        {
            if (!$this->validateFields($row)) {
                return null;
            }
            $this->id = $row["id"];
            $this->accountID = $row["r_accountID"];
            $this->replyText = $row["r_replyText"];
            $this->likeCount = $row["r_likeCount"];
            return $this;
        }

        private function validateFields(array $row): bool
        {
            $requiredFields = ["id", "r_replyText"];

            foreach ($requiredFields as $field) {
                if (!array_key_exists($field, $row)) {
                    return false;
                }
            }
            return true;
        }
    }