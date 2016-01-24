/* email cimek törlése a kampany adatbázisból
Szigetvári Árpádtól kapott lista alapján */

/* munkatábla létrehozása */
drop table if exists wtorlendo;
create table wtorlendo (
  email varchar(80)
);

/* most következik a //robitc/e/www/systemmedia/doc/torlendo_20140317.csv betöltése a wtorlendo táblába */

/* teszt */
select e.*
from  emaillista e, wtorlendo w
where e.email = w.email;

/* update  halálra itéltek bejelölése */
update emaillista e, wtorlendo w
set e.email = "TORLENDO"
where e.email = w.email;

/* halálra itéltek törlése */
delete from emaillista where email = "TORLENDO";

drop table if exists wtorlendo; 