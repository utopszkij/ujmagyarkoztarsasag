<?php


jimport('joomla.application.component.modellist');
jimport('joomla.application.component.helper');

JTable::addIncludePath(JPATH_ROOT.'/administrator/components/com_szavazasok/tables');

class SzavazasokModelSzavazasoklist extends JModelList
{
	public function __construct($config = array())
	{		
	
		parent::__construct($config);		
	}
	
	protected function populateState($ordering = null, $direction = null)
	{
			parent::populateState();
			$app = JFactory::getApplication();
			$id = JRequest::getVar('id', 0, '', 'int');
			$this->setState('szavazasoklist.id', $id);			
	}

	protected function getStoreId($id = '')
	{
		// Compile the store id.
		$id	.= ':'.$this->getState('szavazasoklist.id');
		return parent::getStoreId($id);
	}	
	
	/**
	 * Method to get a JDatabaseQuery object for retrieving the data set from a database.
	 *
	 * @return	object	A JDatabaseQuery object to retrieve the data set.
	 */
	protected function getListQuery()	{
    $w = explode('|',urldecode(JRequest::getVar('filterStr','')));
    $filterStr = $w[0];
    $filterAktiv = $w[1];
    if ($filterAktiv==1)
      $lezartLimit = 1;
    else
      $lezartLimit = 99;
		$db		= $this->getDbo();
		$query	= $db->getQuery(true);			
		$catid = (int) $this->getState('authorlist.id', 1);		
		$query->select('sz.id, sz.megnevezes,
                   if(sz.vita1>0,"X"," ") vita1,
                   if(sz.vita2>0,"X"," ") vita2,
                   if(sz.szavazas>0,"X"," ") szavazas,
                   if(sz.lezart>0,"X"," ") lezart,
                   sz.szavazas_vege,
                   sz.titkos');
		$query->from('#__szavazasok as sz');
    if ($filterStr=='')
		   $query->where('sz.temakor_id="'.JRequest::getVar('temakor',0).'" and sz.lezart < '.$lezartLimit);
    else
		   $query->where('sz.temakor_id="'.JRequest::getVar('temakor',0).'" and
       sz.megnevezes like "%'.$filterStr.'%" and sz.lezart < '.$lezartLimit);
     
    if (JRequest::getVar('order','1')=='1')
      $query->order(JRequest::getVar('order','1').' ASC');
    else   
      $query->order(JRequest::getVar('order','1').' DESC');
    $query->order('sz.szavazas_vege DESC');
    ;
		return $query;
	}
}