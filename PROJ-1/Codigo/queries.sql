SELECT nome_t
FROM tipos_de_registos T
WHERE T.email="Manuel@notebook.pt";

SELECT *
FROM pessoa NATURAL JOIN (SELECT email FROM login WHERE sucesso=falso);

SELECT data_nascimento
FROM Pessoas, paginas P, tipos_de_registos T, registos R
WHERE T.nome_t = R.nome_T AND P.email = T.email AND nome_p = "Facebook" AND nome_r = "Facebook";






SELECT nome_t
FROM tipos_de_registos T
WHERE T.email="lidiafreitas4@gmail.com";

SELECT *
FROM pessoa NATURAL JOIN (SELECT email FROM login WHERE sucesso=falso);

SELECT data_nascimento
FROM Pessoas Paginas P, tipos_de_registos T, registos R
WHERE T.nome_t = R.nome_T AND P.email = T.email AND nome_p = "Facebook" AND nome_r = "Facebook";
