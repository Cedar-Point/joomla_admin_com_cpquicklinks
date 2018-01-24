<?php
defined('_JEXEC') or die;
if(isset($_GET['api'])) {
	require(__DIR__.'./cpquicklinks_api.php');
	exit();
} else {
	JToolBarHelper::title('CP Quick Links', 'link');
	JToolBarHelper::apply();
	JToolBarHelper::cancel();
	JToolBarHelper::preview('../?option=com_cpquicklinks');
	echo file_get_contents(__DIR__.'/src/html/settings.html');
}
?>