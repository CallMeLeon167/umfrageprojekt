<?php

namespace CML\Controllers;

use CML\Classes\DB;
use CML\DataStructure\CommentRepository;

/**
 * Class CommentController
 *
 * This class extends the DB class and is responsible for handling operations related to comments.
 * It uses the CommentRepository to interact with the database.
 */
class CommentController extends DB
{
    /**
     * @var CommentRepository $commentRepository
     *
     * An instance of the commentRepository class.
     */
    private CommentRepository $commentRepository;

    public function __construct()
    {
        parent::__construct();
        $this->commentRepository = new CommentRepository();
    }

    public function getAllComments($params)
    {
        $comments = $this->commentRepository->getComments();
        echo json_encode($comments);
    }

    public function getCommentByID($id)
    {
        $comment = $this->commentRepository->getCommentByID($id);
        if (!$comment) {
            http_response_code(404);
            echo json_encode(["message" => "Comment not found"]);
            return;
        }
        echo json_encode($comment);
    }

    public function newSurveyComment()
    {
        $body = json_decode(file_get_contents('php://input'), true);
        if (!$body) {
            http_response_code(400);
            echo json_encode(["message" => "Invalid input"]);
            return;
        }
        $this->commentRepository->createComments($body);
    }
}
