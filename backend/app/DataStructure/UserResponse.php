<?php

    namespace CML\DataStructure;

    class UserResponse
    {
        /* @var int */
        public $id;   
        /* @var int */
        public $answerOptionID;
        /* @var int */
        public $surveyParticipationID;
        /* @var int */
        public $questionID;
        /* @var string */
        public $response;


        public function hydrateFromDBRow(array $row):UserResponse|null
        {
            if (!$this->validateFields($row)) {
                return null;
            }
            $this->id = $row["id"];
            $this->answerOptionID = $row["ur_answerOptionID"];
            $this->surveyParticipationID = $row["ur_surveyParticipationID"];
            $this->response = $row["ur_response"];
            $this->questionID = $row["ur_questionID"];
            return $this;
        }

        private function validateFields(array $row): bool
        {
            return true;
        }
    }

?>