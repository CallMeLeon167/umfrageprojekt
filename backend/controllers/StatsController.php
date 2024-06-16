<?php

namespace CML\Controllers;

use CML\Classes\DB;
use CML\DataStructure\UserResponseRepository;
use CML\DataStructure\UserResponse;

class StatsController extends DB
{
    private UserResponseRepository $userResponseRepository;
    
    public function getStatsData($data)
    {
        return $this->sql2json_file("SELECT_STATS.sql");
    }

    public function getUserResponses()
    {
        $this->userResponseRepository = new UserResponseRepository();
        $questions = $this->userResponseRepository->getUserResponses();
        echo json_encode($questions);
    }
}
