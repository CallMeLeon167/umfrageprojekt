<?php

    namespace CML\DataStructure;

    class Category extends Entity
    {
        public $id;
        public $name;
        public $type;

        protected function getFieldMappings(): array
        {
            return [
                "id" => "id",
                "name" => "cat_name",
                "type" => "cat_type"
            ];
        }

        protected function getRequiredFields(): array
        {
            return ["id", "cat_name"];
        }
    }