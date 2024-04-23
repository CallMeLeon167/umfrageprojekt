<?php

namespace CML\Controllers;

use CML\Classes\DB;

class CategoryController extends DB {
    public function getCategories($params)
    {
        echo $this->sql2json_file("SELECT_CATEGORYS.sql");
    }

    public function deleteCategory($data)
    {
        $this->sql2db_file("DELETE_CATEGORY.sql", [$data['id']]);
        $stop = "stop";
    }

    public function createCategory($data)
    {
        $stop = "stop";
        $body = file_get_contents('php://input');
        if (!$body) {
            http_response_code(400);
            echo json_encode(["message" => "No data provided"]);
            return;
        }
        $data = json_decode($body, true);
        $categoryName = $data['name'] ?? null;
        $categoryType = $data['type'] ?? null;
        if (!$categoryName || !$categoryType) {
            http_response_code(400);
            echo json_encode(["message" => "Name and type are required"]);
            return;
        }

        $this->sql2db_file("INSERT_CATEGORY.sql", [$data['name'], $data['type']]);
        $stop = "stop";
    }

}
?>