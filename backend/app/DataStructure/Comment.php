<?php

    namespace CML\DataStructure;

    class Comment extends Entity
    {
        /* @var int */
        public $commentID;
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

        protected function getFieldMappings(): array
        {
            return [
               "commentID"=> "id",
               "accountID"=> "com_accountID",
               "commentText"=> "com_commentText",
               "likeCount"=> "com_likeCount",
               "constitutionDate"=> "com_constitutionDate",
               "surveyID"=>"com_surveyID"
            ];
        }
    
        protected function getRequiredFields(): array
        {
            return ["id","com_commentText"];
        }
    }