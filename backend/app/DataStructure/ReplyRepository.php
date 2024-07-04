<?php

    namespace CML\DataStructure;

    use CML\Classes\DB;

    class ReplyRepository extends DB
    {

        private DB $dbConn;

        public function __construct()
        {
            parent::__construct();
            $this->dbConn = new DB();
        }

        public function getReplys(): array
        {
            $dbResult = $this->dbConn->sql2array("SELECT * FROM Reply");
            /* @var $surveys Survey[] */
            $answerOptions = [];
            foreach ($dbResult as $row) {
                $reply = new Reply();
                $reply->hydrateFromDBRow($row);
                $replys[] = $reply;
            }
            return $replys;
        }

        public function getReplyByID($id)
        {
            $result = $this->dbConn->sql2array("SELECT * FROM Reply WHERE id = ?", [$id]);
            if (empty($result)) {
                return null;
            }
            $answerOptions = new AnswerOption();
            $answerOptions->hydrateFromDBRow($result[0]);
            return $answerOptions;
        }

        /**
         * Fetch question answers.
         *
         * This method fetches the replys for a Comment from the database.
         *
         * @param int $commentID The ID of the comment to fetch the answers for.
         *
         * @return Replys[] The array of replys for the Comment.
         *
         * @throws \Exception
         */
        public function fetchCommentReplys(int $commentID): array
        {
            $stmt = <<<SQL
                SELECT * FROM Reply WHERE r_commentID = ?;
            SQL;
            try {
                $result = $this->dbConn->sql2array($stmt, [$commentID]);
                /* @var $replys reply[] */
                $replys = [];
                foreach ($result as $row) {
                    $reply = new Reply();
                    $reply->hydrateFromDBRow($row);
                    $replys[] = $reply;
                }
                return $replys;
            } catch (\Exception $e) {
                throw new \Exception("Error fetching Replys answers: " . $e->getMessage(), 500);
            }
        }

    /**
     * Create replys.
     *
     * This method creates reply entries in the DB for a Comment.
     *
     * @param Comment $comment The comment to create the reply for.
     * @throws \Exception
     */
    public function newReply($data): void
    {
        try {

            $reply = new Reply();
            $reply = $this->parseReplyFromJson($data);

               $stmt = <<<SQL
               INSERT INTO Reply (r_accountID, r_commentID, r_replyText, r_likeCount)
               VALUES (?, ?, ?, ?)
           SQL;
           $result = $this->dbConn->sql2db($stmt, [
               $reply->accountID ?? "null",
               $reply->commentID ?? "null",
               $reply->replyText?? "null",
               $reply->likeCount ?? "null",
               

           ]);
               $reply->replyID = $result['insert_id'];
               //$this->createReplysForComment($comment);
           
       } catch (\Exception $e) {
           throw new \Exception("Error creating reply: " . $e->getMessage(), 500);
       }
    }
    private function parseReplyFromJson($data): Reply
    {
        try {
            $reply = new Reply();
            $reply->accountID = $data['accountId'] ?? null;
            $reply->commentID = $data['commentId'] ?? null;
            $reply->replyText = $data['replytext'] ?? null;
            $reply->likeCount = $data['likecount'] ?? null;
            //$comment->Replys = $this->parseReplysFromJSON($data);
            
            return $reply;
        } catch (\Exception $e) {
            throw new \Exception("Error parsing comment from JSON: " . $e->getMessage(), 500);
        }

    }
    }