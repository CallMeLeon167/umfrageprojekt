<?php

    namespace CML\DataStructure;

    class Category
    {
        public $id;
        public $name;
        public $type;

        public function hydrateFromDBRow(array $row): Category|null
        {
            if (!$this->validateFields($row)) {
                return null;
            }
            $this->id = $row["id"];
            $this->name = $row["cat_name"];
            $this->type = $row["cat_type"];
            return $this;
        }

        private function validateFields(array $row): bool
        {
            $requiredFields = ["id", "cat_name"];

            foreach ($requiredFields as $field) {
                if (!array_key_exists($field, $row)) {
                    return false;
                }
            }
            return true;
        }
    }