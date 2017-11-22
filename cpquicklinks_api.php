<?php
defined('_JEXEC') or die;
if(isset($_POST['get'])) {
	$db = JFactory::getDbo();
	$query = $db
	->getQuery(true)
	->select($db->quoteName('*'))
	->from($db->quoteName('lwr6z_com_cpquicklinks_categories'));
	$db->setQuery($query);
	$cats = $db->loadAssocList();
	$query = $db
	->getQuery(true)
	->select($db->quoteName('*'))
	->from($db->quoteName('lwr6z_com_cpquicklinks_links'));
	$db->setQuery($query);
	$links = $db->loadAssocList();
	$return = array();
	foreach($cats as $key => $cat) {
		$link_format = array();
		foreach($links as $key => $link) {
			$popout = false;
			if($link['link_target'] == '_TOP') {
				$popout = true;
			}
			$link_format[$link['link_name']] = array(
				'href' => $link['link_url'],
				'popout' => $popout
			);
		}
		$return[$cat['cat_name']] = array(
			'icon' => $cat['cat_font_awesome'],
			'links' => $link_format
		);
	}
	echo json_encode($return);
} elseif(isset($_POST['save']) && !empty($_POST['save'])) {
	
}
exit();
?>