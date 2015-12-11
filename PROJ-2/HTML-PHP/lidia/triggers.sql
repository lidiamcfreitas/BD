drop trigger if exists contador_sequencia_registo;

delimiter $$

    create trigger contador_sequencia_registo before insert on registo
    for each row
    begin
    if exists()

    then
            call contador_sequencia_registo_trigger();
    end if;
    end$$

delimiter ;
