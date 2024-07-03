<?php

namespace CML\Controllers;

use CML\Classes\DB;
use CML\DataStructure\ReplyRepository;


class ReplyController extends DB
{
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

    public function newCommentReply($params)
    {
       $this->ReplyRepository->newReply($params);
    }
}
