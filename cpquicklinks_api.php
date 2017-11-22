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
	$return = array();
	$count = 0;
	foreach($cats as $key => $cat) {
		$count++;
		$link_format = array();
		$conditions = array(
			$db->quoteName('link_cat_id') . ' = '.$count
		);
		$query = $db
		->getQuery(true)
		->select($db->quoteName('*'))
		->from($db->quoteName('lwr6z_com_cpquicklinks_links'))
		->where($conditions);
		$db->setQuery($query);
		$links = $db->loadAssocList();
		foreach($links as $key => $link) {
			$popout = false;
			if($link['link_target'] == '_blank') {
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
	
	$db = JFactory::getDbo();
	
	$query = $db->getQuery(true)
	->delete($db->quoteName('lwr6z_com_cpquicklinks_categories'));
	$db->setQuery($query)->execute();
	$query = $db->getQuery(true)
	->delete($db->quoteName('lwr6z_com_cpquicklinks_links'));
	$db->setQuery($query)->execute();
	
	$save = json_decode($_POST['save'], true);
	if(is_array($save) && !empty($save)) {
		$count = 0;
		foreach($save as $cat_name => $cat_array) {
			if(isset($cat_name) && !empty($cat_name) && isset($cat_array) && is_array($cat_array) && is_array($cat_array['links']) && !empty($cat_array['links'])) {
				$count++;
				$cat = new stdClass();
				$cat->cat_name = $cat_name;
				$cat->cat_font_awesome = $cat_array['icon'];
				JFactory::getDbo()->insertObject('lwr6z_com_cpquicklinks_categories', $cat);
				foreach($cat_array['links'] as $link_name => $link_array) {
					if(!empty($link_name) && is_array($link_array) && isset($link_array['href']) && !empty($link_array['href']) && isset($link_array['popout'])) {
						$target = '';
						if($link_array['popout']) {
							$target = '_blank';
						}
						$link = new stdClass();
						$link->link_name = $link_name;
						$link->link_url = $link_array['href'];
						$link->link_cat_id = $count;
						$link->link_target = $target;
						JFactory::getDbo()->insertObject('lwr6z_com_cpquicklinks_links', $link);
					}
				}
			}
		}
	}
}
exit();
?>