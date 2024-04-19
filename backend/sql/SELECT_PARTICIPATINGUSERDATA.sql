SELECT Account.id, a_Username 
FROM Account
INNER JOIN SurveyParticipation ON Account.id = SurveyParticipation.sp_accountID
INNER JOIN Survey ON SurveyParticipation.sp_surveyID = Survey.id
where Survey.id = ?
