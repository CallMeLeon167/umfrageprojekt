<?php

    namespace CML\DataStructure;

    class Survey extends Entity
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

        protected function getFieldMappings(): array
        {
            $mapping = [
                "id"=> "id",
                "topic"=> "s_topic",
                "type"=> "s_type",
                "startdate"=> "s_startdate",
                "enddate"=> "s_enddate",
                "status"=> "s_status",
                "categoryID"=> "s_categoryID",
            ];
            return $mapping;
        }

        protected function getRequiredFields(): array
        {
            return ["id", "s_topic"];
        }

    }

    ?>