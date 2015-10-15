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

SET foreign_key_checks = 1;

create table pessoa
   (email        	varchar(255)	not null unique,
    bloqueado           boolean         not null default 0,
    nome 		varchar(255)	not null,
    insucesso           numeric(1,0)    not null,
    password            varchar(255)    not null,
    timestamp_nascimento    timestamp   not null,
    timestamp_registo   timestamp       not null,
    primary key(email));

create table pergunta
   (questao      	varchar(255)	not null unique,
    email        	varchar(255)	not null,
    resposta     	varchar(255)	not null,
    primary key(questao, email),
    foreign key(email) references pessoa(email));

create table login
    (timestamp_login    timestamp       not null unique,
    email               varchar(255)    not null,
    sucesso             boolean         not null,
    primary key(timestamp_login, email),
    foreign key(email) references pessoa(email));


create table versao
    (id                 numeric(5,0)    not null unique,
    changed             boolean         not null default 0,
    deleted             boolean         not null default 0,
    primary key(id));


create table paginas
    (nome_p             varchar(255)    not null unique,
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
    id                 numeric(5,0)    not null,
    primary key(nome_r, nome_t),
    foreign key(nome_t) references tipos_de_registos(nome_t),
    foreign key(id) references versao(id));

create table paginas_registos
    (nome_p             varchar(255) not null,
     email              varchar(255) not null,   
     nome_r             varchar(255) not null,
     id                 numeric(5,0) not null,
    primary key(nome_p, email, nome_r),
    foreign key(email) references pessoa(email),
    foreign key(nome_p) references paginas(nome_p), 
    foreign key(nome_r) references registos(nome_r), 
    foreign key(id) references versao(id));

create table campos
    (nome_c             varchar(255) not null,
    nome_t             varchar(255) not null,   
    nome_r             varchar(255) not null,
    valor				numeric(5,0) not null,
    id                 numeric(5,0) not null,
    primary key(nome_c, nome_t, nome_r),
    foreign key(nome_t) references tipos_de_registos(nome_t),
    foreign key(nome_r) references registos(nome_r));

create table log 
	(log_id			varchar(255)	not null,
	email			varchar(255) 	not null,
	primary key(log_id, email),
	foreign key(email) references pessoa(email));

create table log_versao
	(log_id			varchar(255)	not null,
	 id				numeric(5,0)	not null,
	 primary key(log_id, id),
	 foreign key(log_id) references log(log_id),
	 foreign key(id)     references versao(id));




insert into pessoa values ( 'lidiafreitas@gmail.com', 0, 'LÃdia Freitas', 0, 'password', CURRENT_TIMESTAMP, CURRENT_TIMESTAMP);
insert into pergunta values ( 'Qual o nome de solteira da tua mae?', 'lidiafreitas@gmail.com', 'yolo');
insert into login values (CURRENT_TIMESTAMP, 'lidiafreitas@gmail.com', 0);
insert into versao values (1, 0, 0);
insert into paginas values ('amigos', 'lidiafreitas@gmail.com', 1);

