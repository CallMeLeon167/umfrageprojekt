<?php

namespace CML\Controllers;

use CML\Classes\DB;
use CML\DataStructure\Comment;
use CML\DataStructure\CommentRepository;

class QuestionController extends DB
{
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
}
