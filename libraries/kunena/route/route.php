<?php
/**
 * Kunena Component
 * @package Kunena.Framework
 * @subpackage Route
 *
 * @copyright (C) 2008 - 2014 Kunena Team. All rights reserved.
 * @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
 * @link http://www.kunena.org
 **/
defined ( '_JEXEC' ) or die ();

jimport('joomla.environment.uri');
jimport('joomla.html.parameter');
jimport('joomla.filter.output');

KunenaRoute::initialize();

/**
 * Class KunenaRoute
 */
abstract class KunenaRoute {
	// List of views: array of default variable=>value pairs, which can be removed from URI
	static $views = array (
		'announcement'=>array('layout'=>'default'),
		'category'=>array('layout'=>'default', 'catid'=>'0'),
		'common'=>array('layout'=>'default'),
		'credits'=>array('layout'=>'default'),
		'home'=>array(),
		'misc'=>array('layout'=>'default'),
		'search'=>array('layout'=>'default'),
		'statistics'=>array('layout'=>'default'),
		'topic'=>array('layout'=>'default'),
		'topics'=>array('layout'=>'default'),
		'user'=>array('layout'=>'default', 'userid'=>'0'),
	);
	// Reserved layout names for category view
	static $layouts = array ('create'=>1, 'default'=>1, 'edit'=>1, 'manage'=>1, 'moderate'=>1, 'user'=>1);
	// Use category name only in these views
	static $sefviews = array (''=>1, 'home'=>1, 'category'=>1, 'topic'=>1);
	static $parsevars = array ('do'=>1, 'task'=>1, 'mode'=>1, 'catid'=>1, 'id'=>1, 'mesid'=>1, 'userid'=>1, 'page'=>1, 'sel'=>1 );

	static $time = 0;
	static $adminApp = false;
	static $config = false;
	static $menus = false;
	static $menu = false;
	static $default = false;
	static $active = null;
	static $home = false;
	static $search = false;
	static $current = null;

	static $childlist = false;
	static $subtree = array();
	static $parent = array();
	static $uris = array();
	static $urisSave = false;

	static protected $filtered = array();

	public static function current($object = false) {
		KUNENA_PROFILER ? KunenaProfiler::instance()->start('function '.__CLASS__.'::'.__FUNCTION__.'()') : null;
		$uri = self::prepare();
		if (!$uri) return false;
		if ($object) return $uri;
		$result = $uri->getQuery ();
		KUNENA_PROFILER ? KunenaProfiler::instance()->stop('function '.__CLASS__.'::'.__FUNCTION__.'()') : null;
		return $result;
	}

	public static function getItemID($uri = null) {
		if (self::$adminApp) {
			// There are no itemids in administration
			return 0;
		}
		KUNENA_PROFILER ? KunenaProfiler::instance()->start('function '.__CLASS__.'::'.__FUNCTION__.'()') : null;
		$uri = self::prepare($uri);
		if (!$uri) return false;
		if (!$uri->getVar('Itemid')) {
			self::setItemID ( $uri );
		}
		KUNENA_PROFILER ? KunenaProfiler::instance()->stop('function '.__CLASS__.'::'.__FUNCTION__.'()') : null;
		return $uri->getVar('Itemid');
	}

	public static function _($uri = null, $xhtml = true, $ssl=0) {
		if (self::$adminApp) {
			if ($uri instanceof JUri) $uri = $uri->toString ();
			if (substr($uri, 0, 14) == 'administrator/') {
				// Use default routing in administration
				return JRoute::_(substr($uri, 14), $xhtml, $ssl);
			} else {
				return JUri::root(true)."/{$uri}";
			}
		}
		KUNENA_PROFILER ? KunenaProfiler::instance()->start('function '.__CLASS__.'::'.__FUNCTION__.'()') : null;

		$key = (self::$home ? self::$home->id : 0) .'-'.(int)$xhtml.(int)$ssl. ($uri instanceof JUri ? $uri->toString () : (string) $uri);
		if (!$uri || (is_string($uri) && $uri[0]=='&')) {
			$key = 'a'.(self::$active ? self::$active->id : '') . '-' . $key;
		}
		if (isset(self::$uris[$key])) {
			KUNENA_PROFILER ? KunenaProfiler::instance()->stop('function '.__CLASS__.'::'.__FUNCTION__.'()') : null;
			return self::$uris[$key];
		}
		$uri = self::prepare($uri);
		if (!$uri) {
			KUNENA_PROFILER ? KunenaProfiler::instance()->stop('function '.__CLASS__.'::'.__FUNCTION__.'()') : null;
			return false;
		}
		if (!$uri->getVar('Itemid')) {
			self::setItemID ( $uri );
		}

		$fragment = $uri->getFragment();
		KUNENA_PROFILER ? KunenaProfiler::instance()->start('function '.__CLASS__.'::'.__FUNCTION__.'(t)') : null;
		self::$uris[$key] = JRoute::_ ( 'index.php?' . $uri->getQuery (), $xhtml, $ssl ) . ($fragment ? '#'.$fragment : '');
		KUNENA_PROFILER ? KunenaProfiler::instance()->stop('function '.__CLASS__.'::'.__FUNCTION__.'(t)') : null;
		self::$urisSave = true;
		KUNENA_PROFILER ? KunenaProfiler::instance()->stop('function '.__CLASS__.'::'.__FUNCTION__.'()') : null;
		return self::$uris[$key];
	}

	/**
	 * @param JUri $uri
	 * @param bool $object
	 *
	 * @return JUri|string
	 */
	public static function normalize($uri = null, $object = false) {
		if (self::$adminApp) {
			// Use default routing in administration
			return $object ? $uri : 'index.php?' . $uri->getQuery ();
		}
		KUNENA_PROFILER ? KunenaProfiler::instance()->start('function '.__CLASS__.'::'.__FUNCTION__.'()') : null;

		$uri = self::prepare($uri);
		if (!$uri) return false;
		if (!$uri->getVar('Itemid')) {
			self::setItemID ( $uri );
		}
		$result = $object ? $uri : 'index.php?' . $uri->getQuery ();
		KUNENA_PROFILER ? KunenaProfiler::instance()->stop('function '.__CLASS__.'::'.__FUNCTION__.'()') : null;
		return $result;
	}

	public static function getMenu() {
		return self::$home;
	}

	public static function getHome($item) {
		if (!$item) return null;
		KUNENA_PROFILER ? KunenaProfiler::instance()->start('function '.__CLASS__.'::'.__FUNCTION__.'()') : null;
		$id = $item->id;
		if (!isset(self::$parent[$id])) {
			if ($item->type == 'component' && $item->component == 'com_kunena' && isset($item->query['view']) && $item->query['view'] == 'home') {
				self::$parent[$id] = $item;
			} else {
				$parentid = $item->parent_id;
				$parent = isset(self::$menu[$parentid]) ? self::$menu[$parentid] : null;
				self::$parent[$id] = self::getHome($parent);
			}
		}
		KUNENA_PROFILER ? KunenaProfiler::instance()->stop('function '.__CLASS__.'::'.__FUNCTION__.'()') : null;
		return self::$parent[$id];
	}

	public static function cacheLoad() {
		KUNENA_PROFILER ? KunenaProfiler::instance()->start('function '.__CLASS__.'::'.__FUNCTION__.'()') : null;
		$user = KunenaUserHelper::getMyself();
		$cache = self::getCache();
		// TODO: can use viewlevels instead of userid
		// FIXME: enable caching after fixing the issues
		$data = false; // $cache->get($user->userid, 'com_kunena.route');
		if ($data !== false) {
			list(self::$subtree, self::$uris) = unserialize($data);
		}
		KUNENA_PROFILER ? KunenaProfiler::instance()->stop('function '.__CLASS__.'::'.__FUNCTION__.'()') : null;
	}

	public static function cacheStore() {
		if (!self::$urisSave) return;
		KUNENA_PROFILER ? KunenaProfiler::instance()->start('function '.__CLASS__.'::'.__FUNCTION__.'()') : null;
		$user = KunenaUserHelper::getMyself();
		$data = array(self::$subtree, self::$uris);
		$cache = self::getCache();
		// TODO: can use viewlevels instead of userid
		// FIXME: enable caching after fixing the issues
		//$cache->store(serialize($data), $user->userid, 'com_kunena.route');
		KUNENA_PROFILER ? KunenaProfiler::instance()->stop('function '.__CLASS__.'::'.__FUNCTION__.'()') : null;
	}

	protected static function getCache() {
		return JFactory::getCache('mod_menu', 'output');
	}

	public static function stringURLSafe($string, $default = null) {
		KUNENA_PROFILER ? KunenaProfiler::instance()->start('function '.__CLASS__.'::'.__FUNCTION__.'()') : null;
		if (!isset(self::$filtered[$string])) {
			self::$filtered[$string] = JApplication::stringURLSafe($string);

			// Remove beginning and trailing "whitespace", fixes #1130 where category alias creation fails on error: Duplicate entry '-'.
			self::$filtered[$string] = trim(self::$filtered[$string], '-_ ');
			if ($default && empty(self::$filtered[$string])) self::$filtered[$string] = $default;
		}
		KUNENA_PROFILER ? KunenaProfiler::instance()->stop('function '.__CLASS__.'::'.__FUNCTION__.'()') : null;
		return self::$filtered[$string];
	}

	/**
	 * This method implements unicode slugs instead of transliteration.
	 * It has taken from Joomla 1.7.3 with the difference that urls are not lower case.
	 *
	 * @param   string  $string  String to process
	 *
	 * @return  string  Processed string
	 */
	protected static function stringURLUnicodeSlug($string)
	{
		// Replace double byte whitespaces by single byte (East Asian languages)
		$str = preg_replace('/\xE3\x80\x80/', ' ', $string);

		// Remove any '-' from the string as they will be used as concatenator.
		// Would be great to let the spaces in but only Firefox is friendly with this

		$str = str_replace('-', ' ', $str);

		// Replace forbidden characters by whitespaces
		$str = preg_replace('#[:\#\*"@+=;!><&\.,%()\]\/\'\\\\|\[]#', "\x20", $str);

		// Delete all '?'
		$str = str_replace('?', '', $str);

		// Trim white spaces at beginning and end of alias and make lowercase
		$str = trim($str);

		// Remove any duplicate whitespace and replace whitespaces by hyphens
		$str = preg_replace('#\x20+#', '-', $str);

		return $str;
	}

	public static function resolveAlias($alias) {
		KUNENA_PROFILER ? KunenaProfiler::instance()->start('function '.__CLASS__.'::'.__FUNCTION__.'()') : null;
		$db = JFactory::getDbo();
		$query = "SELECT * FROM #__kunena_aliases WHERE alias LIKE {$db->Quote($alias.'%')}";
		$db->setQuery ($query);
		$aliases = $db->loadObjectList();

		$vars = array();
		foreach ($aliases as $object) {
			if (JString::strtolower($alias) == JString::strtolower($object->alias)) {
				$var = $object->type != 'legacy' ? $object->type : 'view';
				$vars [$var] = $object->type != 'layout' ? $object->item : preg_replace('/.*\./', '', $object->item);
				if ($var == 'catid') $vars ['view'] = 'category';
				break;
			}
		}
		KUNENA_PROFILER ? KunenaProfiler::instance()->stop('function '.__CLASS__.'::'.__FUNCTION__.'()') : null;
		return $vars;
	}

	public static function initialize() {
		KUNENA_PROFILER ? KunenaProfiler::instance()->start('function '.__CLASS__.'::'.__FUNCTION__.'()') : null;
		self::$config = KunenaFactory::getConfig ();
		if (JFactory::getApplication()->isAdmin()) {
			self::$adminApp = true;
			KUNENA_PROFILER ? KunenaProfiler::instance()->stop('function '.__CLASS__.'::'.__FUNCTION__.'()') : null;
			return;
		}
		self::$menus = JFactory::getApplication()->getMenu ();
		self::$menu = self::$menus->getMenu ();
		self::$default = self::$menus->getDefault();
		$active = self::$menus->getActive();

		// Get the full request URI.
		$uri = clone JUri::getInstance();

		// Get current route.
		self::$current = new JUri('index.php');

		if ($active)
		{
			foreach ($active->query as $key => $value)
			{
				self::$current->setVar($key, $value);
			}

			self::$current->setVar('Itemid', (int) $active->id);

			if ($active->type == 'component' && $active->component == 'com_kunena' && isset($active->query['view']))
			{
				self::$active = $active;
			}
		}

		// If values are both in GET and POST, they are only stored in POST
		foreach (JRequest::get('post') as $key => $value)
		{
			if (in_array($key, array('view', 'layout', 'task')) && !preg_match('/[^a-zA-Z0-9_.]/i', $value))
			{
				self::$current->setVar($key, $value);
			}
		}

		// Make sure that request URI is not broken
		foreach (JRequest::get('get') as $key => $value)
		{
			if (preg_match('/[^a-zA-Z]/', $key))
			{
				continue;
			}

			if (in_array($key, array('q', 'query', 'searchuser')))
			{
				// Allow all values
			}
			// TODO: we need to find a way to here deal with arrays: &foo[]=bar
			elseif (gettype($value)=='string')
			{
				if(preg_match('/[^a-zA-Z0-9_ ]/i', $value))
				{
				// Illegal value
  				continue;
				}
			}

			self::$current->setVar($key, $value);
		}

		if (self::$current->getVar('start'))
		{
			self::$current->setVar('limitstart', self::$current->getVar('start'));
			self::$current->delVar('start');
		}

		self::$home = self::getHome(self::$active);

		KUNENA_PROFILER ? KunenaProfiler::instance()->stop('function '.__CLASS__.'::'.__FUNCTION__.'()') : null;
	}

	public static function cleanup() {
		self::$filtered = array();
		self::$uris = array();
	}

	protected static function prepare($uri = null) {
		static $current = array();
		KUNENA_PROFILER ? KunenaProfiler::instance()->start('function '.__CLASS__.'::'.__FUNCTION__.'()') : null;
		if (!$uri || (is_string($uri) && $uri[0] == '&')) {
			if (!isset($current[$uri])) {
				$get = self::$current->getQuery(true);
				$uri = $current[$uri] = JUri::getInstance('index.php?'.http_build_query($get).$uri);
				self::setItemID($uri);
				$uri->delVar ( 'defaultmenu' );
				$uri->delVar ( 'language' );
			} else {
				$uri = $current[$uri];
			}
		} elseif (is_numeric($uri)) {
			if (!isset(self::$menu[intval($uri)])) {
				KUNENA_PROFILER ? KunenaProfiler::instance()->stop('function '.__CLASS__.'::'.__FUNCTION__.'()') : null;
				return false;
			}
			$item = self::$menu[intval($uri)];
			$uri = JUri::getInstance ( "{$item->link}&Itemid={$item->id}" );
		} elseif ($uri instanceof JUri) {
			// Nothing to do
		} else {
			$uri = new JUri((string) $uri);
		}
		$option = $uri->getVar('option');
		$Itemid = $uri->getVar('Itemid');
		if (!$option && !$Itemid) {
			KUNENA_PROFILER ? KunenaProfiler::instance()->stop('function '.__CLASS__.'::'.__FUNCTION__.'()') : null;
			return false;
		} elseif ($option && $option != 'com_kunena') {
			KUNENA_PROFILER ? KunenaProfiler::instance()->stop('function '.__CLASS__.'::'.__FUNCTION__.'()') : null;
			return false;
		} elseif ($Itemid && (!isset(self::$menu[$Itemid]) || self::$menu[$Itemid]->component != 'com_kunena')) {
			KUNENA_PROFILER ? KunenaProfiler::instance()->stop('function '.__CLASS__.'::'.__FUNCTION__.'()') : null;
			return false;
		}
		// Support legacy URIs
		if ($uri->getVar('func')) {
			$result = KunenaRouteLegacy::convert($uri);
			KUNENA_PROFILER ? KunenaProfiler::instance()->stop('function '.__CLASS__.'::'.__FUNCTION__.'()') : null;
			if (!$result) return false;
			return $uri;
		}
		// Check URI
		switch ($uri->getVar('view', 'home')) {
			case 'announcement':
				KunenaRouteLegacy::convert($uri);
				$r = array();
				break;
			case 'category':
				$r = array('catid', 'limitstart', 'limit');
				break;
			case 'common':
				$r = array();
				break;
			case 'credits':
				$r = array();
				break;
			case 'home':
				$r = array();
				break;
			case 'misc':
				$r = array();
				break;
			case 'search':
				$r = array('q', 'query', 'titleonly', 'searchuser', 'starteronly', 'exactname', 'replyless',
					'replylimit', 'searchdate', 'beforeafter', 'sortby', 'order', 'childforums', 'catids',
					'show', 'limitstart', 'limit');
				break;
			case 'statistics':
				$r = array();
				break;
			case 'topic':
				$r = array('catid', 'id', 'mesid', 'limitstart', 'limit');
				break;
			case 'topics':
				$r = array('mode', 'userid', 'sel', 'limitstart', 'limit');
				break;
			case 'user':
				$r = array('userid');
				break;
			case 'users':
				$r = array('search', 'limitstart', 'limit');
				break;
			default:
				$result = KunenaRouteLegacy::convert($uri);
				if (!$result) {
					KUNENA_PROFILER ? KunenaProfiler::instance()->stop('function '.__CLASS__.'::'.__FUNCTION__.'()') : null;
					return false;
				}
		}
		KUNENA_PROFILER ? KunenaProfiler::instance()->stop('function '.__CLASS__.'::'.__FUNCTION__.'()') : null;
		return $uri;
	}

	protected static function build() {
		KUNENA_PROFILER ? KunenaProfiler::instance()->start('function '.__CLASS__.'::'.__FUNCTION__.'()') : null;
		if (self::$search === false) {
			$user = KunenaUserHelper::getMyself();
			$language = JFactory::getDocument()->getLanguage();
			$cache = self::getCache();

			// FIXME: enable caching after fixing the issues
			self::$search = false; //unserialize($cache->get('search', "com_kunena.route.{$language}.{$user->userid}"));
			if (self::$search === false) {
				self::$search['home'] = array();
				foreach ( self::$menu as $item ) {
					// Joomla! 1.5:
					if (! is_object ( $item ) || (isset($item->published) && $item->published < 1 ))
						continue;

					// Do not add menu items for other languages
					if (isset($item->language) && $item->language  != '*' && strtolower($item->language) != strtolower($language))
						continue;

					if ($item->type == 'alias' && !empty($item->query['Itemid']) && !empty(self::$menu[$item->query['Itemid']])) {
						// Follow links
						$item = self::$menu[$item->query['Itemid']];
					} elseif ($item->type == 'component' && $item->component == 'com_kunena' && isset($item->query['view'])) {
						// Save Kunena menu items so that we can make fast searches
						$home = self::getHome($item);
						self::$search[$item->query['view']][$home ? $home->id : 0][$item->id] = $item->id;
					}
				}
				// FIXME: enable caching after fixing the issues
				//$cache->store(serialize(self::$search), 'search', "com_kunena.route.{$language}.{$user->userid}");
			}
		}
		KUNENA_PROFILER ? KunenaProfiler::instance()->stop('function '.__CLASS__.'::'.__FUNCTION__.'()') : null;
	}

	protected static function setItemID(JUri $uri) {
		static $candidates = array();
		KUNENA_PROFILER ? KunenaProfiler::instance()->start('function '.__CLASS__.'::'.__FUNCTION__.'()') : null;

		$view = $uri->getVar('view');
		$catid = (int) $uri->getVar('catid');
		$Itemid = (int) $uri->getVar('Itemid');
		$key = $view.$catid;
		if (!isset($candidates[$key])) {
			if (self::$search === false) self::build();
			$search = array();
			if (self::$home) {
				// Search from the current home menu
				$search[self::$home->id] = 1;
				// Then search from all linked home menus
				if (isset(self::$search['home'][self::$home->id])) $search += self::$search['home'][self::$home->id];
			}
			// Finally search from other home menus
			$search += self::$search['home'];

			// Find all potential candidates
			$candidates[$key] = array();
			foreach ($search as $id=>$dummy) {
				$follow = !empty(self::$menu[$id]) ? self::$menu[$id] : null;
				if ($follow && self::checkHome($follow, $catid)) {
					$candidates[$key] += !empty(self::$search[$view][$follow->id]) ? self::$search[$view][$follow->id] : array();
					if ($view == 'topic') $candidates[$key] += !empty(self::$search['category'][$follow->id]) ? self::$search['category'][$follow->id] : array();
					$candidates[$key][$follow->id] = $follow->id;
				}
			}
			// Don't forget lonely candidates
			$candidates[$key] += !empty(self::$search[$view][0]) ? self::$search[$view][0] : array();
			if ($view == 'topic') $candidates[$key] += !empty(self::$search['category'][0]) ? self::$search['category'][0] : array();
		}

		// Check current menu item first
		$bestcount = ($Itemid && isset(self::$menu[$Itemid])) ? self::checkItem(self::$menu[$Itemid], $uri) : 0;
		$bestid = $bestcount ? $Itemid : 0;

		// Then go through all candidates
		foreach ($candidates[$key] as $id) {
			$item = self::$menu[$id];
			$matchcount = self::checkItem($item, $uri);
			if ($matchcount > $bestcount) {
				// This is our best candidate this far
				$bestid = $item->id;
				$bestcount = $matchcount;
			}
		}
		$uri->setVar('Itemid', $bestid);
		KUNENA_PROFILER ? KunenaProfiler::instance()->stop('function '.__CLASS__.'::'.__FUNCTION__.'()') : null;
		return $bestid;
	}

	protected static function checkItem($item, JUri $uri) {
		$authorise = self::$menus->authorise($item->id);
		if (!$authorise) {
			return 0;
		}
		$catid = (int) $uri->getVar('catid');
		if ( !empty($item->query['view']) ) {
			switch ($item->query['view']) {
				case 'home':
					$matchcount = self::checkHome($item, $catid);
					break;
				case 'category':
				case 'topic':
					$matchcount = self::checkCategory($item, $uri);
					break;
				default:
					$matchcount = self::check($item, $uri);
			}
			return $matchcount;
		} else {
			return 1;
		}
	}

	protected static function checkHome($item, $catid) {
		static $cache = array();
		if (!$catid) return 1;
		if (!isset($cache[$item->id])) {
			$params = $item->params;
			$catids = $params->get('catids', array());
			if (!is_array($catids)) {
				$catids = explode(',', $catids);
			}
			if (!empty($catids)) {
				$catids = array_combine($catids, $catids);
			}
			unset($catids[0], $catids['']);
			$cache[$item->id] = (array) $catids;
		}
		return intval(empty($cache[$item->id]) || isset($cache[$item->id][$catid]));
	}

	protected static function checkCategory($item, JUri $uri) {
		static $cache = array();
		$catid = (int) $uri->getVar('catid');
		$check = self::check($item, $uri);
		if (!$check || !$catid) return $check;
		if (!isset($cache[$item->id])) {
			$cache[$item->id] = array();
			if (!empty($item->query['catid'])) {
				$cache[$item->id] = KunenaForumCategoryHelper::getChildren($item->query['catid']);
				$cache[$item->id][$item->query['catid']] = KunenaForumCategoryHelper::get($item->query['catid']);
			}
		}
		return intval(isset($cache[$item->id][$catid])) * 8;
	}

	protected static function check($item, JUri $uri) {
		$hits = 0;
		foreach ( $item->query as $var => $value ) {
			if ($value != $uri->getVar($var)) {
				return 0;
			}
			$hits++;
		}
		return $hits;
	}
}
