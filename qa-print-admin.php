<?php
    class qa_print_admin {
		
	function allow_template($template)
	{
	    return ($template!='admin');
	}

	function option_default($option) {

	    switch($option) {
		case 'print_view_title':
		    return 'Print';
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
                qa_opt('print_view_title',qa_post_text('print_view_title'));
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

	    $fields[] = array(
		'label' => 'Print button hover text',
		'type' => 'text',
		'value' => qa_html(qa_opt('print_view_title')),
		'tags' => 'NAME="print_view_title"',
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
