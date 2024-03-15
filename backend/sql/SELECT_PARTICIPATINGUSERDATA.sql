SELECT * 
FROM Account
INNER JOIN SurveyParticipation ON Account.id = SurveyParticipation.sp_accountID
INNER JOIN Survey ON SurveyParticipation.sp_surveyID = Survey.id
where Survey.id = ?
