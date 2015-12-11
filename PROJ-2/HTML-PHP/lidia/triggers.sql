drop trigger if exists contador_sequencia_registo_insert;

delimiter $$

    create trigger contador_sequencia_registo_insert before insert on registo
    for each row
    begin
    if (exists(select * from  tipo_registo tr where tr.idseq = new.idseq) or
    	exists(select * from  pagina p where p.idseq = new.idseq) or
    	exists(select * from  campo c where c.idseq = new.idseq) or
    	exists(select * from  registo r where r.idseq = new.idseq) or
    	exists(select * from  valor v where v.idseq = new.idseq))

    then
            call contador_sequencia_registo_insert_trigger();
    end if;
    end$$

delimiter ;

drop trigger if exists contador_sequencia_registo_update;

delimiter $$

    create trigger contador_sequencia_registo_update before update on registo
    for each row
    begin
    if (exists(select * from  tipo_registo tr where tr.idseq = new.idseq) or
    	exists(select * from  pagina p where p.idseq = new.idseq) or
    	exists(select * from  campo c where c.idseq = new.idseq) or
    	exists(select * from  registo r where r.regcounter <> old.regcounter and r.idseq=new.idseq ) or
    	exists(select * from  valor v where v.idseq = new.idseq))

    then
            call contador_sequencia_registo_update_trigger();
    end if;
    end$$

delimiter ;

/* TRIGGER TIPO_REGISTO ----------------------------------------------------*/

drop trigger if exists contador_tipo_registo_insert;

delimiter $$

    create trigger contador_sequencia_tipo_registo_insert before insert on tipo_registo
    for each row
    begin
    if (exists(select * from  tipo_registo tr where tr.idseq = new.idseq) or
    	exists(select * from  pagina p where p.idseq = new.idseq) or
    	exists(select * from  campo c where c.idseq = new.idseq) or
    	exists(select * from  registo r where r.idseq = new.idseq) or
    	exists(select * from  valor v where v.idseq = new.idseq))

    then
            call contador_sequencia_tipo_registo_insert_trigger();
    end if;
    end$$

delimiter ;

drop trigger if exists contador_sequencia_tipo_registo_update;

delimiter $$

    create trigger contador_sequencia_tipo_registo_update before update on tipo_registo
    for each row
    begin
    if (exists(select * from  tipo_registo tr where tr.typecnt <> old.typecnt and tr.idseq = new.idseq) or
    	exists(select * from  pagina p where p.idseq = new.idseq) or
    	exists(select * from  campo c where c.idseq = new.idseq) or
    	exists(select * from  registo r where r.idseq=new.idseq ) or
    	exists(select * from  valor v where v.idseq = new.idseq))

    then
            call contador_sequencia_tipo_registo_update_trigger();
    end if;
    end$$

delimiter ;

/* TRIGGER PAGINA ----------------------------------------------------*/

drop trigger if exists contador_pagina_insert;

delimiter $$

    create trigger contador_sequencia_pagina_insert before insert on pagina
    for each row
    begin
    if (exists(select * from  tipo_registo tr where tr.idseq = new.idseq) or
    	exists(select * from  pagina p where p.idseq = new.idseq) or
    	exists(select * from  campo c where c.idseq = new.idseq) or
    	exists(select * from  registo r where r.idseq = new.idseq) or
    	exists(select * from  valor v where v.idseq = new.idseq))

    then
            call contador_sequencia_pagina_insert_trigger();
    end if;
    end$$

delimiter ;

drop trigger if exists contador_sequencia_pagina_update;

delimiter $$

    create trigger contador_sequencia_pagina_update before update on pagina
    for each row
    begin
    if (exists(select * from  tipo_registo tr where  tr.idseq = new.idseq) or
    	exists(select * from  pagina p where p.pagecounter <> old.pagecounter and p.idseq = new.idseq) or
    	exists(select * from  campo c where c.idseq = new.idseq) or
    	exists(select * from  registo r where r.idseq=new.idseq ) or
    	exists(select * from  valor v where v.idseq = new.idseq))

    then
            call contador_sequencia_pagina_update_trigger();
    end if;
    end$$

delimiter ;

/* TRIGGER CAMPO ----------------------------------------------------*/

drop trigger if exists contador_campo_insert;

delimiter $$

    create trigger contador_sequencia_campo_insert before insert on campo
    for each row
    begin
    if (exists(select * from  tipo_registo tr where tr.idseq = new.idseq) or
    	exists(select * from  pagina p where p.idseq = new.idseq) or
    	exists(select * from  campo c where c.idseq = new.idseq) or
    	exists(select * from  registo r where r.idseq = new.idseq) or
    	exists(select * from  valor v where v.idseq = new.idseq))

    then
            call contador_sequencia_campo_insert_trigger();
    end if;
    end$$

delimiter ;

drop trigger if exists contador_sequencia_pagina_update;

delimiter $$

    create trigger contador_sequencia_campo_update before update on campo
    for each row
    begin
    if (exists(select * from  tipo_registo tr where  tr.idseq = new.idseq) or
    	exists(select * from  pagina p where  p.idseq = new.idseq) or
    	exists(select * from  campo c where c.campocnt <> old.campocnt and c.idseq = new.idseq) or
    	exists(select * from  registo r where r.idseq=new.idseq ) or
    	exists(select * from  valor v where v.idseq = new.idseq))

    then
            call contador_sequencia_campo_update_trigger();
    end if;
    end$$

delimiter ;


/* TRIGGER VALOR ----------------------------------------------------*/

drop trigger if exists contador_valor_insert;

delimiter $$

    create trigger contador_sequencia_valor_insert before insert on valor
    for each row
    begin
    if (exists(select * from  tipo_registo tr where tr.idseq = new.idseq) or
    	exists(select * from  pagina p where p.idseq = new.idseq) or
    	exists(select * from  campo c where c.idseq = new.idseq) or
    	exists(select * from  registo r where r.idseq = new.idseq) or
    	exists(select * from  valor v where v.idseq = new.idseq))

    then
            call contador_sequencia_valor_insert_trigger();
    end if;
    end$$

delimiter ;

drop trigger if exists contador_sequencia_valor_update;

delimiter $$

    create trigger contador_sequencia_valor_update before update on valor
    for each row
    begin
    if (exists(select * from  tipo_registo tr where  tr.idseq = new.idseq) or
    	exists(select * from  pagina p where  p.idseq = new.idseq) or
    	exists(select * from  campo c where c.idseq = new.idseq) or
    	exists(select * from  registo r where r.idseq=new.idseq ) or
    	exists(select * from  valor v where v.userid <> old.userid and v.regid <> old.regid and v.typeid <> old.typeid and v.campoid <> old.campoid  and v.idseq = new.idseq))

    then
            call contador_sequencia_campo_update_trigger();
    end if;
    end$$

delimiter ;
