-- Alinea A
-- Dado o userid <USERID> de o utilizador em questão, devolve a sua média do
-- número de registos por página.
SELECT COUNT(RP.regid) / COUNT(DISTINCT RP.pageid)
FROM reg_pag RP, registo R, pagina P
WHERE RP.ativa                  AND
      P.ativa                   AND
      R.ativo                   AND
      P.userid = <USERID>       AND
      P.userid = R.userid       AND
      R.userid = RP.userid      AND
      P.pagecounter = RP.pageid AND
      R.regcounter = RP.regid;

CREATE INDEX aupr_reg_pag_index
USING HASH
ON reg_pag (pageid, regid);

-- Alinea B
-- Dados os <USERID> e <PAGECOUNTER> dos utilizador e página em questão,
-- respectivamente, devolve o nome dos registos associados a essa página de esse
-- utilizador.
SELECT R.nome
FROM registo R, reg_pag RP, pagina P
WHERE R.userid      = <USERID>      AND
      R.userid      = RP.userid     AND
      RP.userid     = P.userid      AND
      R.regcounter  = RP.regid      AND
      P.pagecounter = RP.pageid     AND
      P.pagecounter = <PAGECOUNTER> AND
      R.ativo                       AND
      RP.ativa                      AND
      P.ativa;

CREATE INDEX reg_index
USING HASH
ON registo (userid, regcounter,  ativo);

CREATE INDEX pag_index
USING HASH
ON pagina (userid, pagecounter, ativa);

CREATE INDEX rp_index
USING HASH
ON reg_pag (userid, regid, pageid, ativa);

