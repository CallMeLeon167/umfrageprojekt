<?php

    namespace CML\DataStructure;

    class Reply extends Entity
    {
        /* @var int */
        public $replyID;
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
               "replyID"=> "id",
               "accountID"=> "r_accountID",
               "commentID"=> "r_commentID",
               "replyText"=> "r_replyText",
               "likeCount"=> "r_likeCount"
            ];
        }
    
        protected function getRequiredFields(): array
        {
            return ["id", "r_commentID", "r_replyText"];
        }
    }