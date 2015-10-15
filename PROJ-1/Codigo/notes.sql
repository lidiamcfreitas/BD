SET foreign_key_checks = 0;

drop table pergunta cascade;
drop table pessoa cascade;
drop table login cascade;
drop table versao cascade;
drop table paginas cascade;
drop table tipos_de_registos cascade;
drop table registos cascade;
drop table paginas_registos cascade;
drop table campos cascade;
drop table log cascade;
drop table log_versao cascade;
drop table registos_campos;

SET foreign_key_checks = 1;

create table pessoa
(email           varchar(255)    not null  ,
 bloqueado           boolean         not null default 0,
 nome 		varchar(255)	not null,
 num_insucessos_login    numeric(1,0)    not null,
 password            varchar(255)    not null,
 timestamp_nascimento    timestamp   not null,
 timestamp_registo   timestamp       not null,
 num_undos           numeric(5,0)    not null,         
 primary key(email));

create table pergunta
(questao      	varchar(255)	not null  ,
 email        	varchar(255)	not null,
 resposta     	varchar(255)	not null,
 primary key(questao, email),
 foreign key(email) references pessoa(email));

create table login
(timestamp_login    timestamp       not null  ,
 email               varchar(255)    not null,
 sucesso             boolean         not null,
 primary key(timestamp_login, email),
 foreign key(email) references pessoa(email));


create table versao
(id                 numeric(5,0)    not null  ,
 changed             boolean         not null default 0,
 deleted             boolean         not null default 0,
 primary key(id));


create table paginas
(nome_p             varchar(255)    not null  ,
 email               varchar(255)    not null,
 id                  numeric(5,0)    not null,
 primary key(nome_p, email),
 foreign key(email) references pessoa(email),
 foreign key(id) references versao(id));


create table tipos_de_registos
(nome_t             varchar(255)	not null,
 email              varchar(255)    not null,
 id                 numeric(5,0)    not null,
 primary key(nome_t, email),
 foreign key(email) references pessoa(email),
 foreign key(id) references versao(id));

create table registos
(nome_r             varchar(255)	not null,
 nome_t             varchar(255)    not null,
 email              varchar(255)    not null,
 id                 numeric(5,0)    not null,
 primary key(nome_r, nome_t,email),
 foreign key(nome_t, email) references tipos_de_registos(nome_t, email),
 foreign key(id) references versao(id));

create table paginas_registos
(nome_p             varchar(255) not null,
 nome_r             varchar(255) not null,
 nome_t             varchar(255) not null,
 email              varchar(255) not null,
 id                 numeric(5,0) not null,
 primary key(nome_p, nome_r, nome_t, email),
 foreign key(nome_p, email) references paginas(nome_p, email), 
 foreign key(nome_r, nome_t, email) references registos(nome_r, nome_t, email), 
 foreign key(id) references versao(id));

create table campos
(nome_c             varchar(255) not null,
 nome_t             varchar(255) not null,   
 email              varchar(255) not null,
 id                 numeric(5,0) not null,
 primary key(nome_c, nome_t, email),
 foreign key(id)    references versao(id),
 foreign key(nome_t, email) references tipos_de_registos(nome_t, email));

create table registos_campos
(nome_r	varchar(255) not null,
 nome_t varchar(255) not null,
 nome_c varchar(255) not null,
 email  varchar(255) not null,
 valor  varchar(255) not null,
 primary key(nome_r, nome_t, nome_c, email),
 foreign key(nome_r, nome_t, email) references registos(nome_r, nome_t, email), 	
 foreign key(nome_c, nome_t, email) references campos(nome_c, nome_t, email));


create table log 
(log_id			varchar(255)	not null,
 email			varchar(255) 	not null,
 primary key(log_id, email),
 foreign key(email) references pessoa(email));

create table log_versao
(log_id             varchar(255)	not null,
 email              varchar(255)        not null,
 id		    numeric(5,0)	not null,
 primary key(log_id, email, id),
 foreign key(log_id, email) references log(log_id, email),
 foreign key(id)     references versao(id));



insert into pessoa      values ( 'lidiafreitas4@gmail.com', 0, 'Lidia4', 0 , 'password4', '2015-10-15 17:12:03', CURRENT_TIMESTAMP, 5);
insert into pessoa      values ( 'lidiafreitas3@gmail.com', 0, 'Lidia3', 0 , 'password3', CURRENT_TIMESTAMP, CURRENT_TIMESTAMP, 5);
insert into pessoa      values ( 'lidiafreitas2@gmail.com', 0, 'Lidia2', 0 , 'password2', CURRENT_TIMESTAMP, CURRENT_TIMESTAMP, 5);
insert into pessoa      values ( 'lidiafreitas1@gmail.com', 0, 'Lidia1', 2 , 'password1', CURRENT_TIMESTAMP, CURRENT_TIMESTAMP, 5);
insert into versao      values (1,0,0);
insert into paginas     values ('Pagina1', 'lidiafreitas4@gmail.com', 1);
insert into versao      values (2,0,0);
insert into paginas     values ('Pagina2', 'lidiafreitas4@gmail.com', 2);
insert into versao      values (3, 0, 0);
insert into paginas     values ('Facebook', 'lidiafreitas3@gmail.com', 3);
insert into versao      values (4,0,0);
insert into paginas     values ('Pagina4', 'lidiafreitas3@gmail.com', 4);
insert into versao      values (5,0,0);
insert into paginas     values ('Pagina5', 'lidiafreitas3@gmail.com', 5);
insert into versao      values (6,0,0);
insert into paginas     values ('Facebook', 'lidiafreitas2@gmail.com', 6);
insert into versao      values(7,0,0);
insert into tipos_de_registos   values('Random', 'lidiafreitas2@gmail.com', 7);
insert into versao      values(8,0,0);
insert into tipos_de_registos   values('Facebook', 'lidiafreitas2@gmail.com', 8);
insert into versao      values(9,0,0);
insert into tipos_de_registos   values('Random', 'lidiafreitas3@gmail.com', 9);
insert into versao      values(10,0,0);
insert into tipos_de_registos   values('Coco', 'lidiafreitas3@gmail.com', 10);
insert into versao      values(11,0,0);
insert into tipos_de_registos   values('Xixi', 'lidiafreitas4@gmail.com', 11);
insert into versao      values(12,0,0);
insert into registos    values('Facebook', 'Coco', 'lidiafreitas3@gmail.com', 12);
insert into versao      values(13,0,0);
insert into registos    values('Facebook', 'Xixi', 'lidiafreitas4@gmail.com', 13);
insert into versao      values(14,0,0);
insert into registos    values('Facebook2', 'Facebook', 'lidiafreitas2@gmail.com', 14);
insert into login       values(CURRENT_TIMESTAMP, 'lidiafreitas3@gmail.com', 1);
insert into login       values('2015-10-15 17:12:45', 'lidiafreitas3@gmail.com', 0);
insert into login       values(CURRENT_TIMESTAMP, 'lidiafreitas2@gmail.com', 1);
insert into login       values(CURRENT_TIMESTAMP, 'lidiafreitas4@gmail.com', 0);
insert into login       values('2015-10-15 17:12:22', 'lidiafreitas4@gmail.com', 0);
