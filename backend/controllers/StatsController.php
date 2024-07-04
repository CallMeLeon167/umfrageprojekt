<?php

namespace CML\Controllers;

use CML\Classes\DB;
use CML\DataStructure\UserResponseRepository;

/**
 * Class StatsController
 *
 * This class extends the DB class and is responsible for handling operations regarding the output of stats.
 * It uses the relevant repositories to interact with the database.
 */
class StatsController extends DB
{
    /**
     * @var UserResponseRepository $userResponseRepository
     *
     * An instance of the UserResponseRepository class.
     */
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
