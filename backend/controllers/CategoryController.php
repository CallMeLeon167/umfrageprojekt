<?php

namespace CML\Controllers;

use CML\Classes\DB;

class CategoryController extends DB {
    public function getCategorys($params)
    {
        echo $this->sql2json_file("SELECT_CATEGORYS.sql");
    }
}
?>