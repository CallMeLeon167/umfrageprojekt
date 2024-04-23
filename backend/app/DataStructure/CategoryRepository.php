<?php
    namespace CML\DataStructure;

    use CML\Classes\DB;

    class CategoryRepository extends DB {
        private DB $dbConn;

        public function __construct()
        {
            parent::__construct();
            $this->dbConn = new DB();
        }

        /**
         * @return Category[]
         */
        public function getCategories(): array
        {
            $dbResult = $this->dbConn->sql2array("SELECT * FROM Category");
            /* @var $categories Category[] */
            $categories = [];
            foreach ($dbResult as $row) {
                $category = new Category();
                $category->hydrateFromDBRow($row);
                $categories[] = $category;
            }
            return $categories;
        }
    }