<?php

/*
Plugin Name: deployWP | Activated Plugins
Description: deployWP module for activated plugins
*/

add_action('deployWP', 'dwp_ap_add_module');
function dwp_ap_add_module(){
	register_deploy_module('activated_plugins', dirname(__FILE__).'/activated_plugins.dwp.php');
}


?>