<?php
/**
 *------------------------------------------------------------------------------
 *  iCagenda v3 by Jooml!C - Events Management Extension for Joomla! 2.5 / 3.x
 *------------------------------------------------------------------------------
 * @package     com_icagenda
 * @copyright   Copyright (c)2012-2015 Cyril Rezé, Jooml!C - All rights reserved
 *
 * @license     GNU General Public License version 3 or later; see LICENSE.txt
 * @author      doorknob
 * @link        http://www.joomlic.com
 *
 * @version     3.4.0 2014-12-05
 * @since       3.4.0
 *------------------------------------------------------------------------------
*/

// No direct access to this file
defined('_JEXEC') or die();

/**
 * feature Table class
 */
class iCagendaTablefeature extends JTable
{
	protected $new_icon = null;

	/**
	 * Constructor
	 *
	 * @param JDatabase A database connector object
	 * @since	3.4.0
	 */
	public function __construct(&$_db)
	{
		parent::__construct('#__icagenda_feature', 'id', $_db);
	}

	/**
	 * Overloaded bind function to pre-process the params.
	 *
	 * @param	array		Named array
	 * @return	null|string	null is operation was satisfactory, otherwise returns an error
	 * @see		JTable:bind
	 * @since	3.4.0
	 */
	public function bind($array, $ignore = '')
	{
		if (isset($array['new_icon']))
		{
			// Get media path
			$params_media	= JComponentHelper::getParams('com_media');
			$image_path		= $params_media->get('image_path', 'images');

			// Paths to feature icons folder
			$thumbsPath		= $image_path . '/icagenda/feature_icons';

			// Get Image File Infos
			$link_image		= $array['new_icon'];
			$decomposition	= explode( '/' , $link_image );

			// in each parent
			$i = 0;

			while ( isset($decomposition[$i]) )
				$i++;
			$i--;

			$imgname		= $decomposition[$i];
			$fichier		= explode( '.', $decomposition[$i] );
			$imgtitle		= $fichier[0];
			$imgextension	= strtolower($fichier[1]);

			// Check file type if authorized to be generated as feature icon
			$authorized_types = array('jpg', 'jpeg', 'png', 'gif');

			if (!in_array($imgextension, $authorized_types) && $imgextension)
			{
				$this->setError('<strong>' . JText::_('COM_ICAGENDA_NOT_AUTHORIZED_IMAGE_TYPE') . '</strong><br />'
								. JText::_('COM_ICAGENDA_FORM_FEATURE_MIMETYPE_ERROR'));

				return false;
			}
			elseif ($imgextension)
			{
				// Clean icon name
				jimport( 'joomla.filter.output' );
				$icon_name = JFilterOutput::stringURLSafe($imgtitle) . '.' . $imgextension;

				// Generate 16_bit if not exist
				iCThumbGet::thumbnail($array['new_icon'], $thumbsPath, '16_bit', '16', '16', '100', false, '', '', '', $icon_name);

				// Generate 24_bit if not exist
				iCThumbGet::thumbnail($array['new_icon'], $thumbsPath, '24_bit', '24', '24', '100', false, '', '', '', $icon_name);

				// Generate 32_bit if not exist
				iCThumbGet::thumbnail($array['new_icon'], $thumbsPath, '32_bit', '32', '32', '100', false, '', '', '', $icon_name);

				// Generate 48_bit if not exist
				iCThumbGet::thumbnail($array['new_icon'], $thumbsPath, '48_bit', '48', '48', '100', false, '', '', '', $icon_name);

				// Generate 64_bit if not exist
				iCThumbGet::thumbnail($array['new_icon'], $thumbsPath, '64_bit', '64', '64', '100', false, '', '', '', $icon_name);

				$array['icon'] = $icon_name;
			}
		}

		return parent::bind($array, $ignore);
	}

	/**
	 * Overloaded check function
	 * @since	3.4.0
	*/
	public function check()
	{
		// If there is an ordering column and this is a new row then get the next ordering value
		if (property_exists($this, 'ordering') && $this->id == 0)
		{
			$this->ordering = self::getNextOrder();
		}

		return parent::check();
	}

	/**
	 * Method to set the publishing state for a row or list of rows in the database
	 * table.  The method respects checked out rows by other users and will attempt
	 * to checkin rows that it can after adjustments are made.
	 *
	 * @param	mixed    An optional array of primary key values to update.  If not
	 *                    set the instance property value is used.
	 * @param	integer The publishing state. eg. [0 = unpublished, 1 = published]
	 * @param	integer The user id of the user performing the operation.
	 * @return	boolean    True on success.
	 * @since	3.4.0
	 */
	public function publish($pks = null, $state = 1, $userId = 0)
	{
		// Initialise variables.
		$k = $this->_tbl_key;

		// Sanitize input.
		JArrayHelper::toInteger($pks);
		$userId = (int) $userId;
		$state  = (int) $state;

		// If there are no primary keys set check to see if the instance key is set.
		if (empty($pks))
		{
			if ($this->$k)
			{
				$pks = array($this->$k);
			}
			// Nothing to set publishing state on, return false.
			else
			{
				$this->setError(JText::_('JLIB_DATABASE_ERROR_NO_ROWS_SELECTED'));
				return false;
			}
		}

		// Build the WHERE clause for the primary keys.
		$where = $k.'='.implode(' OR '.$k.'=', $pks);

		// Determine if there is checkin support for the table.
		if (!property_exists($this, 'checked_out') || !property_exists($this, 'checked_out_time'))
		{
			$checkin = '';
		}
		else
		{
			$checkin = ' AND (checked_out = 0 OR checked_out = '.(int) $userId.')';
		}

		// Update the publishing state for rows with the given primary keys.
		$this->_db->setQuery(
			'UPDATE `'.$this->_tbl.'`' .
			' SET `state` = '.(int) $state .
			' WHERE ('.$where.')' .
			$checkin
		);
		$this->_db->query();

		// Check for a database error.
		if ($this->_db->getErrorNum())
		{
			$this->setError($this->_db->getErrorMsg());

			return false;
		}

		// If checkin is supported and all rows were adjusted, check them in.
		if ($checkin && (count($pks) == $this->_db->getAffectedRows()))
		{
			// Checkin the rows.
			foreach($pks as $pk)
			{
				$this->checkin($pk);
			}
		}

		// If the JTable instance value is in the list of primary keys that were set, set the instance.
		if (in_array($this->$k, $pks))
		{
			$this->state = $state;
		}

		$this->setError('');

		return true;
	}
}
