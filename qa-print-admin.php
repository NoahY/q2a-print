<?php
    class qa_print_admin {
		
	function allow_template($template)
	{
		return ($template!='admin');
	}

	function option_default($option) {

	    switch($option) {
		default:
		    return null;
	    }
		
	}

        function admin_form(&$qa_content)
        {                       
                            
        // Process form input
            
            $ok = null;
            
            if (qa_clicked('print_view_save')) {
                qa_opt('print_view',(bool)qa_post_text('print_view'));
                $ok = 'Settings Saved.';
            }
            
                    
        // Create the form for display

            
            $fields = array();
            
            $fields[] = array(
                'label' => 'Enable print view',
                'tags' => 'NAME="print_view"',
                'value' => qa_opt('print_view'),
                'type' => 'checkbox',
            );
            
            return array(           
                'ok' => ($ok && !isset($error)) ? $ok : null,
                    
                'fields' => $fields,
             
                'buttons' => array(
                    array(
                        'label' => 'Save',
                        'tags' => 'NAME="print_view_save"',
                    )
                ),
            );
        }
    }
