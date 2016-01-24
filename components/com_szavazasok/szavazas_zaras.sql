
/* 1. Témakör képviseletek kezelése */
/* -------------------------------- */
/* nemszavazott - temakorképviselőjük - témakörképviseőszavazata --> wkepviseloszavazat */
drop table if exists wkepviseloszavazat;
create table wkepviseloszavazat 
select sz.temakor_id, sz.szavazas_id, 0 szavazo_id, nemszavaztak.id user_id, sz.alternativa_id, sz.pozicio 
from (
  select u.id
  from #__users u
  left outer jooin #__szavazok szavazok on szavazok.user_id=u.id and szavazok.szavazas_id = ":PSZAVAZAS"
  left outer join #__szavazas szavazasok on sz.id=":PSZAVAZAS"
  where szavazok.id is null and szavazas.szavazok=1
  union
  select t.user_id
  from #__tagok t
  left outer jooin #__szavazok szavazok on szavazok.user_id=t.user_id and szavazok.szavazas_id = ":PSZAVAZAS"
  left outer join #__szavazasok szavazas on sz.id=":PSZAVAZAS"
  where szavazok.id is null and szavazas.szavazok=2 and t.temakor_id=":PTEMAKOR"
) nemszavaztak
inner join #__kepviselok k on k.temakor_id=":PTEMAKOR" and k.user_id = nemszavaztak.id 
inner join #__szavazatok sz on sz.szavzas_id = ":PSZAVAZAS" and sz.user_id = k.kepviselo_id;

/* wkepviseloszavazat distinct --> szavozok */
insert into #__szavazok (temakor_id,szavazas_id,user_id,idopont)
select distinct temakor_id, szavazas_id, user_id, now()
from wkepviseloszavazat;

/* eddigi max(szavazo_id) és min(id) alapjánPKONSTANS */
select max(szavazo_id) maxszavazo_id 
from #__szavazatok;
select min(id) minid 
from #__wkepviseloszavazat;

PKONSTANS = maxszavazo_id - minid + 1;


/* update wkepviseloszavazat szavazo_id szavazok tábla alapján*/
update #__wkepviseloszavazat w, #__szavazok sz
set w.szavazo_id = sz.id + :PKOSTANS
where w.user_id = sz.user_id and sz.szavazas_id = ":PSZAVAZAS"

/* wkepviseoszavazat --> szavazatok 
   HA TITKOS szavazás akkor user_id = 0
*/
insert into #__szavazatok
select 0,temakor_id, szavazas_id, szavazo_id, user_id, alternativa_id, pozicio
from wkepviseloszavazat; 

/* 1. Általános képviseletek kezelése */
/* ---------------------------------- */

drop table if exists wkepviseloszavazat;
create table wkepviseloszavazat 
select sz.temakor_id, sz.szavazas_id, 0 szavazo_id, nemszavaztak.id user_id, sz.alternativa_id, sz.pozicio 
from (
  select u.id
  from #__users u
  left outer jooin #__szavazok szavazok on szavazok.user_id=u.id and szavazok.szavazas_id = ":PSZAVAZAS"
  left outer join #__szavazas szavazasok on sz.id=":PSZAVAZAS"
  where szavazok.id is null and szavazas.szavazok=1
  union
  select t.user_id
  from #__tagok t
  left outer jooin #__szavazok szavazok on szavazok.user_id=t.user_id and szavazok.szavazas_id = ":PSZAVAZAS"
  left outer join #__szavazasok szavazas on sz.id=":PSZAVAZAS"
  where szavazok.id is null and szavazas.szavazok=2 and t.temakor_id=":PTEMAKOR"
) nemszavaztak
inner join #__kepviselok k on k.temakor_id=0 and k.user_id = nemszavaztak.id 
inner join #__szavazatok sz on sz.szavzas_id = ":PSZAVAZAS" and sz.user_id = k.kepviselo_id;

/* wkepviseloszavazat distinct --> szavozok */
insert into #__szavazok (temakor_id,szavazas_id,user_id,idopont)
select distinct temakor_id, szavazas_id, user_id, now()
from wkepviseloszavazat;

/* eddigi max(szavazo_id) és min(id) alapjánPKONSTANS */
select max(szavazo_id) maxszavazo_id 
from #__szavazatok;
select min(id) minid 
from #__wkepviseloszavazat;

PKONSTANS = maxszavazo_id - minid + 1;

/* update wkepviseloszavazat szavazo_id szavazok tábla alapján*/
update #__wkepviseloszavazat w, #__szavazok sz
set w.szavazo_id = sz.id + :PKOSTANS
where w.user_id = sz.user_id and sz.szavazas_id = ":PSZAVAZAS"

/* wkepviseoszavazat --> szavazatok 
   HA TITKOS szavazás akkor user_id = 0
*/
insert into #__szavazatok
select 0,temakor_id, szavazas_id, szavazo_id, user_id, alternativa_id, pozicio
from wkepviseloszavazat; 
 