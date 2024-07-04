<?php

namespace CML\Controllers;

use CML\Classes\DB;
use CML\DataStructure\AnswerOptionRepository;

/**
 * Class AnswerOptionController
 *
 * This class extends the DB class and is responsible for handling operations related to answerOptions.
 * It uses the AnswerOptionRepository to interact with the database.
 */
class AnswerOptionController extends DB
{
    /**
     * @var AnswerOptionRepository $answerOptionRepository
     *
     * An instance of the answerOptionRepository class.
     */
    private AnswerOptionRepository $answerOptionRepository;

    public function __construct()
    {
        parent::__construct();
        $this->answerOptionRepository = new AnswerOptionRepository();
    }

    public function getAllAnswerOptions($params)
    {
        $answerOptions = $this->answerOptionRepository->getAnswerOptions();
        echo json_encode($answerOptions);
    }

    public function getAnswerOptionByID($id)
    {
        $answerOption = $this->answerOptionRepository->getAnswerOptionById($id);
        if (!$answerOption) {
            http_response_code(404);
            echo json_encode(["message" => "AnswerOption not found"]);
            return;
        }
        echo json_encode($answerOption);
    }
}
