<?php

namespace CML\Controllers;

use CML\Classes\DB;

class StatsController extends DB
{
    public function getStatsData($data)
    {
        return $this->sql2json_file("SELECT_STATS.sql");
    }
}
