<?php

namespace CML\Controllers;

use CML\Classes\DB;
use CML\DataStructure\CategoryRepository;

/**
 * Class CategoryController
 *
 * This class extends the DB class and is responsible for handling operations related to categories.
 * It uses the CategoryRepository to interact with the database.
 */
class CategoryController extends DB 
{
    /**
     * @var CategoryRepository $categoryRepository
     *
     * An instance of the categoryRepository class.
     */
    private CategoryRepository $categoryRepository;
    
    public function __construct() {
        parent::__construct();
        $this->categoryRepository = new CategoryRepository();
    }

    public function getCategories($params)
    {
        $categories = $this->categoryRepository->getCategories();
        echo json_encode($categories);
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