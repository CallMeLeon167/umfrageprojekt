<?php

    namespace CML\DataStructure;

    use CML\Classes\DB;

    class CommentRepository extends DB
    {

        private DB $dbConn;

        public function __construct()
        {
            parent::__construct();
            $this->dbConn = new DB();
        }

        public function getComments(): array
        {
            $dbResult = $this->dbConn->sql2array("SELECT * FROM Comment");
            /* @var $comments Comment[] */
            $comments = [];
            foreach ($dbResult as $row) {
                $comment = new Comment();
                $comment->hydrateFromDBRow($row);
                $comments[] = $comment;
            }
            return $comments;
        }

        public function getCommentByID($id)
        {
            $result = $this->dbConn->sql2array("SELECT * FROM Comment WHERE id = ?", [$id]);
            if (empty($result)) {
                return null;
            }
            $Question = new Comment();
            $Question->hydrateFromDBRow($result[0]);
            return $Question;
        }
    /**
     * Fetch survey comments.
     *
     * This method fetches the comments for a survey from the database.
     *
     * @param int $surveyId The ID of the survey to fetch the questions for.
     * @return Comment[] The array of questions for the survey.
     * @throws \InvalidArgumentException
     */
    public function fetchSurveyComments($surveyId, bool $populateReplys = false): array
    {
        $stmt = <<<SQL
            SELECT * FROM Comment WHERE com_surveyID = ?;
        SQL;
        try {
            $comments = [];
            $result = $this->dbConn->sql2array($stmt, [$surveyId]);
            foreach ($result as $row) {
                $comment = new Comment();
                $comment->hydrateFromDBRow($row);
                if ($populateReplys) {
                    $replyRepo = new ReplyRepository();
                    $comment->replys = $replyRepo->fetchCommentReplys($comment->id) ?? [];
                }
                $comments[] = $comment;
            }
            return $comments;

        } catch (\Exception $e) {
            throw new \Exception("Error fetching survey comments: " . $e->getMessage(), 500);
        }
    }

}