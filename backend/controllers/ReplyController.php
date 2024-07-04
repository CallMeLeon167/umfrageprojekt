<?php

namespace CML\Controllers;

use CML\Classes\DB;
use CML\DataStructure\ReplyRepository;

/**
 * Class ReplyController
 *
 * This class extends the DB class and is responsible for handling operations related to replys.
 * It uses the ReplyRepository to interact with the database.
 */
class ReplyController extends DB
{
    /**
     * @var ReplyRepository $ReplyRepository
     *
     * An instance of the ReplyRepository class.
     */
    private ReplyRepository $ReplyRepository;

    public function __construct()
    {
        parent::__construct();
        $this->ReplyRepository = new ReplyRepository();
    }

    public function getAllReplys($params)
    {
        $replys = $this->ReplyRepository->getReplys();
        echo json_encode($replys);
    }

    public function getReplyByID($id)
    {
        $reply = $this->ReplyRepository->getReplyByID($id);
        if (!$reply) {
            http_response_code(404);
            echo json_encode(["message" => "Comment not found"]);
            return;
        }
        echo json_encode($reply);
    }

    /**
     * Create a reply.
     *
     * This method creates a new reply for a comment in the database.
     */
    public function newCommentReply()
    {
        $body = json_decode(file_get_contents('php://input'), true);
        if (!$body) {
            http_response_code(400);
            echo json_encode(["message" => "Invalid input"]);
            return;
        }
       $this->ReplyRepository->newReply($body);
    }
}
