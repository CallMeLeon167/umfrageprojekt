INSERT INTO 
kk_user 
(`username`, `password`, `email`, `password_salt`, `created`, `permission`, `pfp_color`) 
VALUES 
(?, ?, ?, ?, now(), 1, ?);