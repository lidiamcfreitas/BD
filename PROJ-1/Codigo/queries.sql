/*SELECT nome_t
FROM tipos_de_registos T
WHERE T.email="Manuel@notebook.pt";

SELECT *
FROM pessoa NATURAL JOIN (SELECT email FROM login WHERE sucesso=falso);

SELECT data_nascimento
FROM Pessoas, paginas P, tipos_de_registos T, registos R
WHERE P.email = R.email AND Pessoa.email = P.email AND nome_p = "Facebook" AND nome_r = "Facebook";
*/





SELECT nome_t
FROM tipos_de_registos T
WHERE T.email="lidiafreitas3@gmail.com";

SELECT DISTINCT pessoa.* 
FROM pessoa, login WHERE pessoa.email = login.email AND sucesso=0;

SELECT DISTINCT timestamp_nascimento, pessoa.email
FROM pessoa, paginas P, tipos_de_registos T, registos R
WHERE P.email = R.email AND pessoa.email = P.email AND nome_p = "Facebook" AND nome_r = "Facebook";