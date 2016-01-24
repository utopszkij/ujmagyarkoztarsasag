<?php

/*
  Schulze method implementation based on http://en.wikipedia.org/wiki/Schulze_method
  The test cases are from http://wiki.electorama.com/wiki/Schulze_method
  GNU GPL v3 or later
  (c) Árpád Magosányi 2013
  
  tábla és mező nevek módositása a li-de adatbázishoz 2014.05.04. Fogler Tibor


  FT 2015.02.13  az 123 / 321 szavazatokat a condorce - shulz módszer döntetlenre hozza
  ezért az eljárás ki lett bővitve az "elfogadhatóság" kezelésével.
  "elfogadható" egy alternativa" ha a szavazó a lehetséges poziciók első 2/3 -ba helyezte el.
  Condorcet döntetlen esetén az az alternativa kerül előre emelyiket többen tartottak
  "elfogadható"-nak.
*/

class Condorcet {
    /* A Schulze method implementation*/
      private $organization = null; // temakor_id
      private $poll = null;  // szavazas_id
      private $candidates = null;
      private $dMatrix = null;
      private $pMatrix = null;
      // FT 2015.02.13  az egyes alternativákat (key=alternativa.id) hányan rangsorolták
      //                a lehetőségek első felébe
      private $accpted = null;
      
      private $db = null;
      private $shortlist = null;

      
      function __construct($db,$temakor_id,$szavazas_id) {
          $this->db = $db;
          $this->organization = $temakor_id;
          $this->poll = $szavazas_id;
          $this->getCandidates();
          $this->loadDiffMatrix();
          $this->floydWarshall();
          $this->shortlist = $this->findWinner();
      }

      public function report() {
          $result = '<div id="eredmenyInfo2" style="display:none">
          <p>Az alábbi táblázat sorai és oszlopai is egy-egy jelöltnek 
          felelnek meg. A táblázat celláiban az látható, hogy a sorban szereplő 
          jelölt hány szavazónál előzte meg az oszlopban lévőt.</p>
          ';
          $result .= $this->printMatrix($this->dMatrix);
          $result .= '<p>Az alábbi táblázat sorai és oszlopai is egy-egy alternatívának 
          felelnek meg. A táblázat celláiban a sorban szereplő 
          alternatívától az oszlopban lévőhöz vezető legerősebb Shulze method szerinti utvonal 
          "erejét" mutatja.</p>
          ';
          $result .= $this->printMatrix($this->pMatrix);
          $result .= '<p><i>(Ha az elöző táblázatban "[sor<sub>A</sub>,oszlop<sub>B</sub>]" &gt; "[sor<sub>B</sub>,oszlop<sub>A</sub>]" akkor "A" előzi "B" -t)</i></p>';
          $result .= '<h3>Condorcet / Shulze  módszer szerinti sorrend</h3></div>';
          $result .= $this->showlist($this->shortlist);
          return $result;
      }

      private function getCandidates() {
          $candidates_sql = "select megnevezes,id 
		  from #__alternativak 
		  where /* temakor_id=".$this->organization." and */ szavazas_id=".$this->poll;
		  
		  
          $db = $this->db;
          $db->setQuery($candidates_sql);
          $this->candidates=array();
          foreach($db->loadObjectList() as $row) {
              $this->candidates[$row->id] = $row->megnevezes;
          }
          return $this->candidates;
      }

      private function printMatrix($matrix) {
          $result= '<center>
          <table border="1" cellpadding="4" class="pollResult" width="100%">
          <tr><th>&nbsp;</th><th>&nbsp;</th>
          ';
          $c=1;
          foreach($this->candidates as $id => $name) {
              $result .= "<th>$c</th>";
              $c++;
          }
          $result .= "</tr>";
          $r = 1;
          foreach($this->candidates as $id1 => $name1) {
              $result .= "<tr><th>$r</th><td>$name1</td>";
              foreach($this->candidates as $id2 => $name2) {
                  if(array_key_exists($id1,$matrix) && array_key_exists($id2,$matrix[$id1])) {
                     if ($id1 == $id2)
                        $result .= '<td align="center"> - </td>';
                     else
                        $result .= '<td align="center">'.$matrix[$id1][$id2].'</td>';
                  } else {
                    $result .= '<td align="center"> - </td>';
                  }  
              }
              $result .= "</tr>\n";
              $r++;
          }
          $result .= "</table>
          </center>
          <p>&nbsp;</p>\n";
          return $result;
      }

      /**
       * @return $this->pMatrix
       *    cc x cc mátrix ahol cc az alternativák darabszáma
       *    a cella tartalma a shulze metod szerinti max érték               
       */             
      private function floydWarshall() {
          $this->pMatrix = array();
          foreach($this->candidates as $i => $name1) {
              $this->pMatrix[$i] = array();
              foreach($this->candidates as $j => $name2) {
                  if($i != $j) {
                    if($this->dMatrix[$i][$j] > $this->dMatrix[$j][$i]) {
                      $this->pMatrix[$i][$j] = $this->dMatrix[$i][$j] ;
                    } else {
                      $this->pMatrix[$i][$j] = 0;
                    }
                  }
              }
          }

          /*
            Minden "i","j" párhoz a lehetséges "j" előzi "i"-t, "i" előzi "k"-t 
            lehetséges hármas sorrendek közül
            kiválasztja a legnagyobb támogatottságut ezt irja be a [j][k] -ba
            
            "j" előzi "i"-t, "i" előzi "k" -t lehetséges hármasok közül
            a leginkább támogatott kerül [j][k] -ba
          */
          foreach($this->candidates as $i => $name1) {
              foreach($this->candidates as $j => $name2) {
                  if($i != $j) {
                    foreach($this->candidates as $k => $name3) {
                        if(($i != $k) && ($j != $k)) {
                          $this->pMatrix[$j][$k] = max($this->pMatrix[$j][$k], min ($this->pMatrix[$j][$i],$this->pMatrix[$i][$k]));
                        }
                    }
                  }
              }
          }
      }

      private function loadDiffMatrix() {
          $diff_sql = "select c1.id as id1, c2.id as id2, count(a.id) as d 
                       from #__szavazatok a, 
                            #__szavazatok b, 
                            #__alternativak c1, 
                            #__alternativak c2  
                       where /* a.temakor_id=".$this->organization." and */ 
                             a.szavazas_id=".$this->poll." and 
                             /* b.temakor_id=a.temakor_id and */
                             b.szavazas_id=a.szavazas_id and 
                             a.szavazo_id=b.szavazo_id and 
                             a.alternativa_id=c1.id and 
                             b.alternativa_id=c2.id and 
                             a.pozicio < b.pozicio and 
                             c1.id != c2.id and 
                             /* c1.temakor_id=a.temakor_id and  */
                             /* c2.temakor_id=a.temakor_id and */
                             c1.szavazas_id=a.szavazas_id and 
                             c2.szavazas_id=a.szavazas_id 
                       group by c1.id, c2.id";
          $this->db->setQuery($diff_sql);
          $this->dMatrix=array();
          foreach($this->db->loadObjectList() as $row ) {
              $id1 = $row->id1;
              $id2 = $row->id2;
              $d = $row->d;
              if(!array_key_exists($id1,$this->dMatrix)) {
                  $this->dMatrix[$id1] = array();
              }
              $this->dMatrix[$id1][$id2] = $d;
          }
          foreach($this->candidates as $id1 => $name1) {
              if(!array_key_exists($id1,$this->dMatrix)) {
                  $this->dMatrix[$id1] = array();
              }
              foreach($this->candidates as $id2 => $name2) {
                  if(!array_key_exists($id2,$this->dMatrix[$id1])) {
                      $this->dMatrix[$id1][$id2] = 0;
                  }  
              }
          }
          
          //FT 2015.02.13 a Condorce holtverseny kezeléshez szükség van arra is
          //   hogy az adott alternativát hány szavazó sorolta az "elfogadható"
          //   kategoriába, azaz a lehetséges poziciók első felébe.
          $this->accepted = array();
          $this->db->setQuery('select a.id, count(sz.szavazo_id) cc
          from #__szavazatok sz, #__alternativak a
          where sz.alternativa_id = a.id and 
                sz.szavazas_id = "'.$this->poll.'" and
                sz.pozicio <= '.(count($this->candidates)*2/3).'
          group by a.id      
          ');
          $res = $this->db->loadObjectList();
          foreach ($res as $row) {
            $this->accepted[$row->id] = $row->cc;
          }
          return $this->dMatrix;
      }

      // rendezéshez compare rutin
      private function beatsP($id1,$id2) {
          $result = $this->pMatrix[$id2][$id1] - $this->pMatrix[$id1][$id2];
          if ($result == 0) {
            $result = $this->accepted[$id2] - $this->accepted[$id1];
          }
          return $result;
      }

      private function showlist($shortlist) {
          // eredmény értékek számolása
          $values = array();
          $i = 0;
          $id1 = 0;
          $id2 = 0;
          $i = count($shortlist) - 1;
          $values[$shorlist[$i]] = 0;
          $lastValue = 0;
          for ($i=count($shortlist) - 2; $i >=0; $i--) {
            $id1 = $shortlist[$i];
            $id2 = $shortlist[$i+1];
            $values[$shortlist[$i]] = $lastValue + $this->pMatrix[$id1][$id2] - $this->pMatrix[$id2][$id1];
            $lastValue = $values[$shortlist[$i]];
          }  
          
          // atlag poziok számítása
          $szavazas_id = JRequest::getVar('szavazas');
          $db = JFactory::getDBO();
          $db->setQuery('select a.megnevezes, avg(sz.pozicio) pozicio
          from #__szavazatok sz, #__alternativak a
          where sz.alternativa_id = a.id and sz.szavazas_id='.$szavazas_id.'
          group by a.megnevezes
          order by 2,1');
          $res = $db->loadObjectList();
          $atlagok = array();
          foreach($res as $res1) {
            $atlagok[$res1->megnevezes] = $res1->pozicio;
          }
          
          $result =  '<table class="pollResult" border="1" width="100%">'."\n".
                     '<tr><th>Megnevezés</th><th>Átlag poziió</th>
                     </th><th>Elfogadható</th>
                     <th colspan="2">Condorce-Shulze érték</th>'.
                     '</tr>'."\n";
          foreach($shortlist as $i) {
              if ($values[$shortlist[0]] > 0)
                $w2 = round($values[$i] * (300/$values[$shortlist[0]]));
              else
                $w2 = 0;  
              $result .= "<tr><td>".$this->candidates[$i]."</td>".
                             "<td>".$atlagok[$this->candidates[$i]]."</td>".
                             "<td>".$this->accepted[$i]."</td>".
                             "<td>".$values[$i]."</td>".
                             '<td><div style="display:inline-block; background-color:blue; width:'.$w2.'px;">&nbsp;</div>&nbsp;</td>'.
                         "</tr>\n";
              if ($values[$i] > $maxValue) $maxValue = $values[$i];
          }
          $result .= "</table>\n";
          return $result;
      }

      private function findWinner() {
          $shortlist = array_keys($this->candidates);
          $newlist = usort($shortlist,array('Condorcet','beatsP'));
          return $shortlist;
      }

}

?>
