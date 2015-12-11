--------------------------------------------------------------------------------
-- Alínea a)

-- Tabela d_user
--
-- Corresponde à dimensão d_utilizador do enunciado. Foram incluídos os atributos
-- uid e userid. Assim, torna-se possível alterar o email de um utilizador sem se
-- perder informação. Se for alterado o email de um utilizador com userid = UID,
-- é criado um novo registo nesta página com os mesmos valores para os atributos,
-- excepto para o email (obviamente) e para o uid. Se fosse colocado o atributo
-- email como chave não seria possível mudar o email. Se fosse colocado o
-- atributo userid como chave não seria possível mudar o email sem se perder o
-- email anterior.
CREATE TABLE IF NOT EXISTS d_user (
    uid    INT          NOT NULL AUTO_INCREMENT,
    userid INT          NOT NULL,
    email  VARCHAR(255) NOT NULL,
    nome   VARCHAR(255) NOT NULL,
    pais   VARCHAR(255) NOT NULL,
    categoria VARCHAR(255) NOT NULL,
    PRIMARY KEY (uid),
    FOREIGN KEY (userid) REFERENCES utilizador (userid),
    FOREIGN KEY (email) REFERENCES utilizador (email)
);

-- Tabela d_time
--
-- Corresponde à dimensão d_tempo do enunciado. O atributo chave, tid, é redundante
-- no nosso modelo, mas permite que se criem queries de forma mais sucinta do que
-- fazendo o triplo (ano,mes,dia) chave primária da relação. A coerência desta
-- tabela (e das outras duas do diagrama em estrela), é mantida através de um
-- trigger, que será descrito mais adiante.
CREATE TABLE IF NOT EXISTS d_time (
    tid INT NOT NULL AUTO_INCREMENT,
    ano INT NOT NULL,
    mes INT NOT NULL,
    dia INT NOT NULL,
    PRIMARY KEY (tid)
);

-- Tabela f_login

-- Corresponde à tabela de factos do diagrama em estrela. Contém como atributos da
-- primary key os atributos que são foreign key para as tabelas d_user e d_time.
-- Como medida é incluído uma coluna attempts que indica o número de tentativas de
-- login associado ao par (uid,tid).
CREATE TABLE IF NOT EXISTS f_login (
    uid      INT NOT NULL,
    tid      INT NOT NULL,
    attempts INT NOT NULL,
    PRIMARY KEY (uid, tid),
    FOREIGN KEY (uid) REFERENCES d_user (uid),
    FOREIGN KEY (tid) REFERENCES d_time (tid)
);

-- Trigger factos_login
--
-- Este trigger permite manter a coerência das tabelas do diagrama em estrela. Sempre que
-- são inseridos novos registos na tabela login este trigger é activado e insere as
-- informações desse registo nas tabelas apropriadas.
DELIMITER $
DROP TRIGGER IF EXISTS f_login;
CREATE TRIGGER factos_login
AFTER INSERT ON login
FOR EACH ROW
BEGIN
    SET @email     = (SELECT U.email     FROM utilizador U WHERE NEW.userid = U.userid);
    SET @nome      = (SELECT U.nome      FROM utilizador U WHERE NEW.userid = U.userid);
    SET @pais      = (SELECT U.pais      FROM utilizador U WHERE NEW.userid = U.userid);
    SET @categoria = (SELECT U.categoria FROM utilizador U WHERE NEW.userid = U.userid);

    -- Se um novo utilizador fizer uma tentativa de login, a informação desse utilizador é
    -- inserida na tabela d_user.
    IF(NOT EXISTS( SELECT * FROM d_user U WHERE NEW.userid = U.userid))
    THEN INSERT INTO d_user(userid, email, nome, pais, categoria)
         VALUES (NEW.userid, @email, @nome, @pais, @categoria);
    END IF;

    SET @uid_k = ( SELECT uid FROM d_user U WHERE NEW.userid = U.userid);

    -- A primeira entrada de cada dia deve ser registada.
    IF(NOT EXISTS( SELECT * FROM d_time T
                   WHERE YEAR (NEW.moment) = T.ano AND
                         MONTH(NEW.moment) = T.mes AND
                         DAY  (NEW.moment) = T.dia))
    THEN INSERT INTO d_time(ano, mes, dia)
         VALUES (YEAR(NEW.moment), MONTH(NEW.moment), DAY(NEW.moment));
    END IF;

    SET @tid_k = ( SELECT tid FROM d_time T
                   WHERE YEAR (NEW.moment) = T.ano AND
                         MONTH(NEW.moment) = T.mes AND
                         DAY  (NEW.moment) = T.dia);

    -- Se um determinado utilizador já tiver feito uma tentativa no mesmo dia,
    -- incrementa-se o número de tentativas do par (uid,tid), que identifica o
    -- utilizador e o dia, respectivamente. Se não, registamos esse novo par e
    -- inicializamos a sua entrada attempts igual a 1 (primeira tentativa do dia
    -- para esse utilizador).
    IF(EXISTS( SELECT * FROM f_login T
               WHERE @uid_k = T.uid AND
                     @tid_k = T.tid))
    THEN UPDATE f_login T
         SET attempts = attempts + 1
         WHERE @uid_k = T.uid AND
               @tid_k = T.tid;
    ELSE INSERT INTO f_login(uid, tid, attempts)
         VALUES (@uid_k, @tid_k, 1);
    END IF;
END;$
DELIMITER ;

--------------------------------------------------------------------------------
-- Alínea b)

-- Interrogação para obter a média de tentativas de login para todos os
-- utilizadores de Portugal, em cada categoria, com rollup por ano e mês.
SELECT U.categoria, T.ano, T.mes, AVG(L.attempts) AS Media
FROM d_user U, d_time T, f_login L
WHERE U.uid = L.uid AND
T.tid = L.tid AND
U.pais = 'Portugal'
GROUP BY U.categoria, T.ano, T.mes WITH ROLLUP;

