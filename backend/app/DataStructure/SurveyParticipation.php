<?php declare(strict_types=1);

namespace CML\DataStructure;

class SurveyParticipation
{
    /* @var int */
    public int $id;
    /* @var int */
    public int $surveyID;
    /* @var int */
    public int $userID;
    /* @var \DateTime */
    public \DateTime $timestamp;

    public function hydrateSurveyParticipationFromDBRow(array $row): SurveyParticipation
    {
        $this->id = $row["id"];
        $this->surveyID = $row["sp_surveyID"];
        $this->userID = $row["sp_accountID"];
        $this->timestamp = $row["sp_timestamp"];
        return $this;
    }

}
