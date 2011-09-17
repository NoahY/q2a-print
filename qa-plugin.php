<?php

/*
        Plugin Name: Print
        Plugin URI: https://github.com/NoahY/q2a-print
        Plugin Description: Adds print view to questions
        Plugin Version: 1.0b
        Plugin Date: 2011-08-11
        Plugin Author: NoahY
        Plugin Author URI: 
        Plugin License: GPLv2
        Plugin Minimum Question2Answer Version: 1.3
*/


	if (!defined('QA_VERSION')) { // don't allow this page to be requested directly from browser
			header('Location: ../../');
			exit;
	}
	
	qa_register_plugin_layer('qa-print-layer.php', 'Print View Layer');	
	
	qa_register_plugin_module('module', 'qa-print-admin.php', 'qa_print_admin', 'Print View Admin');

/*
	Omit PHP closing tag to help avoid accidental output
*/
