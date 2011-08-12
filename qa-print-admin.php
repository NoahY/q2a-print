<?php
	class qa_print_admin {
		
		function allow_template($template)
		{
			return ($template!='admin');
		}

		function option_default($option) {

			switch($option) {

				default:
					return false;
			}
			
		}

		function admin_form(&$qa_content)
		{

		//	Process form input

			$ok = null;
			if (qa_clicked('share_save_button')) {
				qa_opt('share_plugin_facebook',(bool)qa_post_text('share_plugin_facebook'));
				qa_opt('share_plugin_twitter',(bool)qa_post_text('share_plugin_twitter'));
				qa_opt('share_plugin_google',(bool)qa_post_text('share_plugin_google'));
				qa_opt('share_plugin_linkedin',(bool)qa_post_text('share_plugin_linkedin'));
				qa_opt('share_plugin_email',(bool)qa_post_text('share_plugin_email'));
				
				qa_opt('share_plugin_facebook_weight',(int)qa_post_text('share_plugin_facebook_weight'));
				qa_opt('share_plugin_twitter_weight',(int)qa_post_text('share_plugin_twitter_weight'));
				qa_opt('share_plugin_google_weight',(int)qa_post_text('share_plugin_google_weight'));
				qa_opt('share_plugin_linkedin_weight',(int)qa_post_text('share_plugin_linkedin_weight'));
				qa_opt('share_plugin_email_weight',(int)qa_post_text('share_plugin_email_weight'));
				
				qa_opt('share_plugin_suggest',(int)qa_post_text('share_plugin_suggest'));
				qa_opt('share_plugin_suggest_text',qa_post_text('share_plugin_suggest_text'));
				
				$ok = 'Options saved.';
			}
			
		//	Create the form for display
			
		
			$fields = array();
						
			return array(
				'ok' => ($ok && !isset($error)) ? $ok : null,
				
				'fields' => $fields,
				
				'buttons' => array(
				),
			);
		}
	}
