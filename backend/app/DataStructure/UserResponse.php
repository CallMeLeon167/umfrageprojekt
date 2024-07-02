<?php

    namespace CML\DataStructure;

    class UserResponse extends Entity
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

        
        protected function getFieldMappings(): array
        {
            return [
                "id" => "id",
                "answerOptionID" => "ur_answerOptionID",
                "surveyParticipationID" => "ur_surveyParticipationID",
                "response" => "ur_response",
                "questionID" => "ur_questionID"
            ];
        }

        protected function getRequiredFields(): array
        {
            return [];
        }

    }

?>