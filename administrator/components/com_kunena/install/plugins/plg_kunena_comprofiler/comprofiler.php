<?php
/**
 * Kunena Plugin
 * @package Kunena.Plugins
 * @subpackage Comprofiler
 *
 * @Copyright (C) 2008 - 2014 Kunena Team. All rights reserved.
 * @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
 * @link http://www.kunena.org
 **/
defined ( '_JEXEC' ) or die ();

class plgKunenaComprofiler extends JPlugin {
	public $minCBVersion = '1.8.1';

	public function __construct(&$subject, $config) {
		// Do not load if Kunena version is not supported or Kunena is offline
		if (!(class_exists('KunenaForum') && KunenaForum::isCompatible('3.0') && KunenaForum::installed())) return;

		$app = JFactory::getApplication ();

		// Do not load if CommunityBuilder is not installed
		$path = JPATH_ADMINISTRATOR . '/components/com_comprofiler/plugin.foundation.php';
		if (!is_file ( $path )) {
			return;
		}

		require_once ($path);
		cbimport ( 'cb.database' );
		cbimport ( 'cb.tables' );
		cbimport ( 'language.front' );
		cbimport ( 'cb.tabs' );
		cbimport ( 'cb.field' );
		global $ueConfig;

		parent::__construct ( $subject, $config );

		$this->loadLanguage ( 'plg_kunena_comprofiler.sys', JPATH_ADMINISTRATOR ) || $this->loadLanguage ( 'plg_kunena_comprofiler.sys', KPATH_ADMIN );

		require_once __DIR__ . "/integration.php";

		if ($app->isAdmin() && (! isset ( $ueConfig ['version'] ) || version_compare ( $ueConfig ['version'], $this->minCBVersion ) < 0)) {
			$app->enqueueMessage ( JText::sprintf ( 'PLG_KUNENA_COMPROFILER_WARN_VERSION', $this->minCBVersion ), 'notice' );
		}
	}

	public function onKunenaDisplay($type, $view = null, $params = null) {
		$integration = KunenaFactory::getProfile();
		if (!$integration instanceof KunenaProfileComprofiler) return;
		switch ($type) {
			case 'start':
				$integration->open();
				break;
			case 'end':
				$integration->close();
		}
	}

	public function onKunenaPrepare($context, &$item, &$params, $page = 0) {
		if ($context == 'kunena.user') {
			$triggerParams = array ('userid' => $item->userid, 'userinfo' => &$item );
			$integration = KunenaFactory::getProfile();
			if ( $integration instanceof KunenaProfileComprofiler) KunenaProfileComprofiler::trigger ( 'profileIntegration', $triggerParams );
		}
	}

	/*
	 * Get Kunena access control object.
	 *
	 * @return KunenaAccess
	 */
	public function onKunenaGetAccessControl() {
		if (!$this->params->get('access', 1)) return null;

		require_once __DIR__ . "/access.php";
		return new KunenaAccessComprofiler($this->params);
	}

	/*
	 * Get Kunena login integration object.
	 *
	 * @return KunenaLogin
	 */
	public function onKunenaGetLogin() {
		if (!$this->params->get('login', 1)) return null;

		require_once __DIR__ . "/login.php";
		return new KunenaLoginComprofiler($this->params);
	}

	/*
	 * Get Kunena avatar integration object.
	 *
	 * @return KunenaAvatar
	 */
	public function onKunenaGetAvatar() {
		if (!$this->params->get('avatar', 1)) return null;

		require_once __DIR__ . "/avatar.php";
		return new KunenaAvatarComprofiler($this->params);
	}

	/*
	 * Get Kunena profile integration object.
	 *
	 * @return KunenaProfile
	 */
	public function onKunenaGetProfile() {
		if (!$this->params->get('profile', 1)) return null;

		require_once __DIR__ . "/profile.php";
		return new KunenaProfileComprofiler($this->params);
	}

	/*
	 * Get Kunena private message integration object.
	 *
	 * @return KunenaPrivate
	 */
	public function onKunenaGetPrivate() {
		if (!$this->params->get('private', 1)) return null;

		require_once __DIR__ . "/private.php";
		return new KunenaPrivateComprofiler($this->params);
	}

	/*
	 * Get Kunena activity stream integration object.
	 *
	 * @return KunenaActivity
	 */
	public function onKunenaGetActivity() {
		if (!$this->params->get('activity', 1)) return null;

		require_once __DIR__ . "/activity.php";
		return new KunenaActivityComprofiler($this->params);
	}
}
