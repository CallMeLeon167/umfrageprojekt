<?php

namespace CML\DataStructure;

use CML\Classes\DB;

class userResponseRepository extends DB
{

    private DB $dbConn;

    public function __construct()
    {
        parent::__construct();
        $this->dbConn = new DB();
    }

    public function getUserResponses(): array
    {
        $dbResult = $this->dbConn->sql2array("SELECT * FROM UserResponse");
        /* @var $userResponses UserResponse[] */
        $userResponses = [];
        foreach ($dbResult as $row) {
            $userResponse = new userResponse();
            $userResponse->hydrateFromDBRow($row);
            $userResponses[] = $userResponse;
        }
        return $userResponses;
    }

    public function getUserResponseById($id)
    {
        $result = $this->dbConn->sql2array("SELECT * FROM UserResponse WHERE id = ?", [$id]);
        if (empty($result)) {
            return null;
        }
        $survey = new Survey();
        $survey->hydrateFromDBRow($result[0]);
        return $survey;
    }

  

}