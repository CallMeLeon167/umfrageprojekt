<?php

    namespace CML\DataStructure;

    class Reply extends Entity
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

        protected function getFieldMappings(): array
        {
            return [
               "id"=> "id",
               "commentID"=> "r_commentID",
               "accountID"=> "r_accountID",
               "replyText"=> "r_replyText",
               "likeCount"=> "r_likeCount"
            ];
        }
    
        protected function getRequiredFields(): array
        {
            return ["id", "r_commentID", "r_replyText"];
        }
    }