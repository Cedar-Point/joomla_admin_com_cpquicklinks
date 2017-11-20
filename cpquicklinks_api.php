<?php
defined('_JEXEC') or die;
if(isset($_POST['get'])) {
	/*
	$db = JFactory::getDbo();
	
	$query = $db
	->getQuery(true)
	->select($db->quoteName('*'))
	->from($db->quoteName('lwr6z_com_cpquicklinks_categories'));
	$db->setQuery($query);
	$result = $db->loadAssocList();
	*/
	//print_r($result);
	echo '
		{
			"Misc": {
				"icon": "fa-anchor",
				"links": {
					"Your Voice": "#link"
				}
			}
		}
	';
} elseif(isset($_POST['save']) && !empty($_POST['save'])) {

}
exit();
?>