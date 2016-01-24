<?php

// No direct access

// search temakorok, szavazasok, alternativak megnevezésében

defined('_JEXEC') or die;

jimport('joomla.plugin.plugin');

class plgSearchLi_de extends JPlugin
{
	
    /**
     * Constructor.
     *
     * @param object $subject The object to observe
     * @param array $config  An array that holds the plugin configuration
     */
    public function __construct(& $subject, $config)
    {
        parent::__construct($subject, $config);
        $this->loadLanguage();
    }

    /**
     * Sets the checkbox(es) to be diplayed in the Search Only box:
     * @return array An array of search areas
     */
    public function onContentSearchAreas()
    {
        static $areas = array(
            'Li_de' => 'PLG_SEARCH_Li_de'
            );

        return $areas;
    }
    /**
     * Example Search method
     *
     * The sql must return the following fields that are used in a common display
     * routine:
     - title;
     - href:            link associated with the title;
     - browsernav    if 1, link opens in a new window, otherwise in the same window;
     - section        in parenthesis below the title;
     - text;
     - created;

     * @param string Target search string
     * @param string matching option, exact|any|all
     * @param string ordering option, newest|oldest|popular|alpha|category
     * @param mixed An array if the search it to be restricted to areas, null if search all
     *
     * @return array Search results
     */
    public function onContentSearch($text, $phrase = '', $ordering = '', $areas = null)
    {
        $user = JFactory::getUser();
		$result = array();
        // jelenleg semmilyen paramétert nem veszek figyelembe 
        $db = Jfactory::getDBO();
        // témakorok
        $db->setQuery('select t.megnevezes as title,
          t.id,
          "2" as browsernav,
          "'.JText::_('TEMAKOROK').'" as section,
          "" as `text`,
          t.letrehozva as created
          from #__temakorok t
		  left outer join #__tagok ta 
		    on ta.temakor_id = t.id and ta.user_id = "'.$user->id.'"
          where t.megnevezes like "%'.$text.'%" and
		    ((t.lathatosag = 0) or
			 (t.lathatosag = 1 and "'.$user->id.'" > 0) or
			 (ta.user_id is not null)
			)
          order by t.id DESC');
        $res = $db->loadObjectList();
        foreach ($res as $res1) {
           $res1->href = 'index.php?option=com_szavazasok&view=szavazasoklist&temakor='.$res1->id;
           $result[] = $res1;
        }
        // szavazások
        $db->setQuery('select sz.megnevezes as title,
          sz.id,
          "2" as browsernav,
          "'.JText::_('SZAVAZASOK').'" as section,
          "" as `text`,
          sz.letrehozva as created
          from #__szavazasok sz
		  left outer join #__temakorok t on t.id = sz.temakor_id
		  left outer join #__tagok ta 
		    on ta.temakor_id = t.id and ta.user_id = "'.$user->id.'"
          where  sz.megnevezes like "%'.$text.'%" and
		    ((t.lathatosag = 0) or
			 (t.lathatosag = 1 and "'.$user->id.'" > 0) or
			 (ta.user_id is not null)
			)
          order by sz.id DESC');
        $res = $db->loadObjectList();
        foreach ($res as $res1) {
           $res1->href = 'index.php?option=com_alternativak&view=alternativaklist&szavazas='.$res1->id;
           $result[] = $res1;
        }
        // alternativák
        $db->setQuery('select sz.megnevezes as title,
          sz.id,
          "2" as browsernav,
          "'.JText::_('ALTERNATIVAK').'" as section,
          "" as `text`,
          sz.letrehozva as created
          from #__szavazasok sz
		  inner join #__alternativak a on a.szavazas_id = sz.id
		  left outer join #__temakorok t on t.id = sz.temakor_id
		  left outer join #__tagok ta 
		    on ta.temakor_id = t.id and ta.user_id = "'.$user->id.'"
          where  a.megnevezes like "%'.$text.'%" and
		    ((t.lathatosag = 0) or
			 (t.lathatosag = 1 and "'.$user->id.'" > 0) or
			 (ta.user_id is not null)
			)
          order by sz.id DESC');
        $res = $db->loadObjectList();
        foreach ($res as $res1) {
           $res1->href = 'index.php?option=com_alternativak&view=alternativaklist&szavazas='.$res1->id;
           $result[] = $res1;
        }
        return $result;
    }
    
}