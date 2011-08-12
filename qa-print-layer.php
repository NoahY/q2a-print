<?php

	class qa_html_theme_layer extends qa_html_theme_base {

	// register default settings

		function option_default($option) {

			switch($option) {
				default:
					return false;
			}
			
		}
		
		function head_css()
		{
			qa_html_theme_base::head_css();
			global $qa_request_lc_parts;
			error_log($qa_request_lc_parts[1]);
		}
		
		
	}
	
