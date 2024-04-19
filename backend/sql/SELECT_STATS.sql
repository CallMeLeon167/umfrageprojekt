SELECT a.a_username, a.a_emailaddress, count(*) AS votes
FROM Account AS a
INNER JOIN SurveyParticipation AS sp ON sp.sp_accountID = a.id
GROUP BY sp.sp_accountID
ORDER BY votes DESC