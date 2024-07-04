<?php

namespace CML\Controllers;

use CML\Classes\DB;
use CML\DataStructure\QuestionRepository;

/**
 * Class QuestionController
 *
 * This class extends the DB class and is responsible for handling operations related to questions.
 * It uses the QuestionRepository to interact with the database.
 */
class QuestionController extends DB
{
    /**
     * @var QuestionRepository $questionRepository
     *
     * An instance of the QuestionRepository class.
     */
    private QuestionRepository $questionRepository;

    public function __construct()
    {
        parent::__construct();
        $this->questionRepository = new QuestionRepository();
    }

    public function getAllQuestions($params)
    {
        $questions = $this->questionRepository->getQuestions();
        echo json_encode($questions);
    }

    public function getQuestionByID($id)
    {
        $question = $this->questionRepository->getQuestionById($id);
        if (!$question) {
            http_response_code(404);
            echo json_encode(["message" => "Question not found"]);
            return;
        }
        echo json_encode($question);
    }
}
