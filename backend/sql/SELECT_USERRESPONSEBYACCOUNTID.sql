SELECT * 
FROM UserResponse 
JOIN SurveyParticipation ON UserResponse.ur_surveyParticipationID = SurveyParticipation.id 
WHERE sp_accountID = ? 