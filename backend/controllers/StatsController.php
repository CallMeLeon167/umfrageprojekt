<?php

namespace CML\Controllers;

use CML\Classes\DB;
use CML\DataStructure\userResponseRepository;
use CML\DataStructure\userResponse;

class StatsController extends DB
{
    private userResponseRepository $userResponseRepository;
    
    public function getStatsData($data)
    {
        return $this->sql2json_file("SELECT_STATS.sql");
    }

    public function getUserResponses()
    {
        $this->userResponseRepository = new userResponseRepository(); 
        $questions = $this->userResponseRepository->getUserResponses();
        echo json_encode($questions);
    }
}
