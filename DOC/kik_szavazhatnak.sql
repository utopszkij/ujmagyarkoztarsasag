/**
  * adott szavazáson kik vehetnek részt?
  * joomla.user_id, acymailing.subid
*/

/* minden regisztrált szavazhat */
SELECT u.id
FROM  ekh_users u, ekh_szavazasok sz
WHERE sz.szavazok = 1 AND sz.id = "13"
UNION 
/* témakör tagok */
SELECT tag.id
FROM  ekh_tagok tag, ekh_szavazasok sz, ekh_temakorok t
WHERE t.id = sz.temakor_id AND tag.temakor_id = t.id AND (sz.szavazok >= 2) AND sz.id="13"
UNION
/* szülő témakör tagok */
SELECT tag.id
FROM  ekh_tagok tag, ekh_szavazasok sz, ekh_temakorok t
WHERE t.id = sz.temakor_id AND tag.temakor_id = t.szulo AND sz.szavazok = 3 AND sz.id="13"
UNION
/* második szintű szülő témakör tagok */
SELECT tag.id
FROM  (SELECT t1.szulo
       FROM ekh_temakorok t1, ekh_szavazasok sz1
       WHERE t1.id = sz1.temakor_id AND sz1.szavazok = 3 AND sz1.id="12"
       ) szt 
INNER JOIN ekh_temakorok t ON t.id = szt.szulo
INNER JOIN ekh_tagok tag ON tag.temakor_id = t.id
UNION
/* harmadik szintű szülő témakör tagok */
SELECT tag.id
FROM  (SELECT t1.szulo
       FROM ekh_temakorok t1, ekh_szavazasok sz1
       WHERE t1.id = sz1.temakor_id AND sz1.szavazok = 3 AND sz1.id="12"
       ) szt 
INNER JOIN ekh_temakorok t ON t.id = szt.szulo
INNER JOIN ekh_tagok tag ON tag.temakor_id = t.szulo
  

    
