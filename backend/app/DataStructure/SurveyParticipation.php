<?php declare(strict_types=1);

namespace CML\DataStructure;

class SurveyParticipation extends Entity
{
    /* @var int */
    public int $id;
    /* @var int */
    public int $surveyID;
    /* @var int */
    public int $userID;
    /* @var \DateTime */
    public \DateTime $timestamp;



    protected function getRequiredFields(): array
    {
        return [];
    }

    protected function getFieldMappings(): array
    {
        return [
            "id" => "id",
            "surveyID" => "sp_surveyID",
            "userID" => "sp_accountID",
            "timestamp" => "sp_timestamp"
        ];
    }

}
