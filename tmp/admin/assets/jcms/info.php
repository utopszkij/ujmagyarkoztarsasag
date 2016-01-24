<?php
/**
 *------------------------------------------------------------------------------
 *  iCagenda v3 by Jooml!C - Events Management Extension for Joomla! 2.5 / 3.x
 *------------------------------------------------------------------------------
 * @package     com_icagenda
 * @copyright   Copyright (c)2012-2015 Cyril Rezé, Jooml!C - All rights reserved
 *
 * @license     GNU General Public License version 3 or later; see LICENSE.txt
 * @author      Adapted from Nicholas K. Dionysopoulos - www.akeebabackup.com
 * @link        http://www.joomlic.com
 *
 * @version     3.5.6 2015-06-24
 * @since       3.5.6
 *------------------------------------------------------------------------------
*/

// No direct access to this file
defined('_JEXEC') or die();

class iCagendaSystemInfo
{
	/** @var string Unique identifier for the site, created from server variables */
	private $siteId;
	/** @var array Associative array of data being sent */
	private $data = array();
	/** @var string Remote url to upload the stats */
	private $remoteUrl = 'http://stats.joomlic.com/index.php';

	public function setSiteId($siteId)
	{
		$this->siteId = $siteId;
	}

	/**
	 * Sets the value of a collected variable. Use NULL as value to unset it
	 *
	 * @param   string  $key        Variable name
	 * @param   string  $value      Variable value
	 */
	public function setValue($key, $value)
	{
		if (is_null($value) && isset($this->data[$key]))
		{
			unset($this->data[$key]);
		}
		else
		{
			$this->data[$key] = $value;
		}
	}

	/**
	 * Uploads collected data to the remote server
	 *
	 * @param   bool    $useIframe  Should I create an iframe to upload data or should I use cURL/fopen?
	 *
	 * @return  string|bool     The HTML code if an iframe is requested or a boolean if we're using cURL/fopen
	 */
	public function sendInfo()
	{
		// No site ID? Well, simply do nothing
		if ( ! $this->siteId)
		{
			return '';
		}

		// First of all let's add the siteId
		$this->setValue('sid', $this->siteId);

		// Then let's create the url
		$url = array();

		foreach ($this->data as $param => $value)
		{
			$url[] .= $param . '=' . $value;
		}

		$url = $this->remoteUrl . '?' . implode('&', $url);

		return '<iframe style="display: none" src="' . $url . '"></iframe>';
	}
}
