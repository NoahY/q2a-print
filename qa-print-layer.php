<?php

	class qa_html_theme_layer extends qa_html_theme_base {

	// register default settings

		function doctype() {
			$request_parts =  explode('/',$this->request);
			$this->is_print_view = (qa_opt('print_view') && isset($request_parts[1]) && $request_parts[1] == 'print');
			$test = $this->content['asdf'];		
			qa_html_theme_base::doctype();	
		}

		private $is_print_view;

		function head_css()
		{
			if($this->is_print_view) {
				$this->output('<style>
					h1, h2 {margin-bottom: 12px;}
					a {text-decoration:none; font-weight:bold};
					.qa-vote-count {margin-bottom: 12px;}

					.qa-q-view-content {margin-bottom:12px;}
					.qa-q-view-tags {margin-bottom:12px;}
					.qa-q-view-tag-list {list-style:none; margin:0; padding:0;}
					.qa-q-view-tag-item {display:inline;}	
					.qa-q-view-main {border-bottom:1px dotted #666; padding-bottom:12px;}
					.qa-q-view-meta {margin-bottom:12px;}

					.qa-a-list-item {border-top:1px dotted #666; padding-top:12px;}
					.qa-a-item-content {font-size:14px; margin-bottom:12px;}
					.qa-a-item-main { padding-bottom:12px;}

					.qa-c-list-item {
					  border-top: 1px dotted #666666;
					  margin: 12px 0 0 24px;
					  padding-top: 12px;
					}
					.qa-vote-count {
					  font-weight: bold;
					  margin-bottom: 12px;
					}					
					#printer {
						cursor: pointer;
						float: right;
						margin: 12px 12px 12px 0;
					}
				</style>');
			}
			else if (qa_opt('print_view')) {
				$this->output('
				<style>
					#printer {
						cursor: pointer;
						float: right;
						margin: 12px 12px 12px 0;
					}
				</style>');
					
				qa_html_theme_base::head_css();
			}
			else qa_html_theme_base::head_css();
		}
		function head()
		{

			if($this->is_print_view) {
				$this->output(
					'<HEAD>',
					'<META HTTP-EQUIV="Content-type" CONTENT="'.$this->content['content_type'].'"/>'
				);
				
				$this->head_title();
				$this->head_css();
				$this->head_custom();
				
				$this->output('</HEAD>');
			}
			else qa_html_theme_base::head();

		}		
		function body()
		{
			if($this->is_print_view) {

				$this->output('<BODY onload="window.print()">');
				
				$this->body_content();
					
				$this->output('</BODY>');
			}
			else qa_html_theme_base::body();
		}		

		function body_content()
		{
			if($this->is_print_view) {

				$this->output('<DIV CLASS="qa-body-wrapper">', '');

				$this->main();
				
				$this->output('</DIV> <!-- END body-wrapper -->');
			}
			else qa_html_theme_base::body_content();
		}
		function main()
		{
			if($this->is_print_view) {
				$content=$this->content;

				$this->output('<DIV CLASS="qa-main'.(@$this->content['hidden'] ? ' qa-main-hidden' : '').'">');
				
				if(method_exists(qa_html_theme_base,'page_title'))
					$this->page_title();			
				else if(method_exists(qa_html_theme_base,'page_title_error'))
					$this->page_title_error();

				if (isset($content['main_form_tags']))
					$this->output('<FORM '.$content['main_form_tags'].'>');
					
				$this->main_parts($content);
			
				if (isset($content['main_form_tags']))
					$this->output('</FORM>');
					
				$this->output('</DIV> <!-- END qa-main -->', '');
			}
			else qa_html_theme_base::main();
		}
		function page_title()
		{
			if(!$this->is_print_view && qa_opt('print_view') && $this->template == 'question') {
				$this->printer();
			}
			qa_html_theme_base::page_title();
		}
		function page_title_error()
		{
			if(!$this->is_print_view && qa_opt('print_view') && $this->template == 'question') {
				$this->printer();
			}
			qa_html_theme_base::page_title_error();
		}
		function main_parts($content)
		{
			if($this->is_print_view) {
				foreach ($content as $key => $part) {
					if (strpos($key, 'custom')===0)
						$this->output_raw($part);

					elseif (strpos($key, 'form')===0)
						$this->form($part);
						
					elseif (strpos($key, 'q_view')===0)
						$this->q_view($part);
						
					elseif (strpos($key, 'a_list')===0)
						$this->a_list($part);
						
					elseif (strpos($key, 'ranking')===0)
						$this->ranking($part);
						
				}
			}
			else qa_html_theme_base::main_parts($content);
		}
		function q_view_main($q_view)
		{
			if($this->is_print_view) {
				$this->output('<DIV CLASS="qa-q-view-main">');

				$this->q_view_content($q_view);
				$this->q_view_follows($q_view);
				$this->post_tags($q_view, 'qa-q-view');
				$this->post_meta($q_view, 'qa-q-view');
				$this->c_list(@$q_view['c_list'], 'qa-q-view');
				$this->form(@$q_view['a_form']);
				$this->c_list(@$q_view['a_form']['c_list'], 'qa-a-item');
				$this->form(@$q_view['c_form']);
				
				$this->output('</DIV> <!-- END qa-q-view-main -->');
			}
			else qa_html_theme_base::q_view_main($q_view);
		}
		function voting_inner_html($post)
		{
			if($this->is_print_view) {
				$this->vote_count($post);
				$this->vote_clear();
			}
			else qa_html_theme_base::voting_inner_html($post);
		}
		function c_item_main($c_item)
		{
			if($this->is_print_view) {
				if (isset($c_item['url']))
					$this->c_item_link($c_item);
				else
					$this->c_item_content($c_item);
				
				$this->output('<DIV CLASS="qa-c-item-footer">');
				$this->post_meta($c_item, 'qa-c-item');
				$this->output('</DIV>');
			}
			else qa_html_theme_base::c_item_main($c_item);
		}
		function a_item_main($a_item)
		{
			if($this->is_print_view) {
				$this->output('<DIV CLASS="qa-a-item-main">');
				
				if ($a_item['hidden'])
					$this->output('<DIV CLASS="qa-a-item-hidden">');
				elseif ($a_item['selected'])
					$this->output('<DIV CLASS="qa-a-item-selected">');

				$this->a_item_content($a_item);
				$this->post_meta($a_item, 'qa-a-item');
				$this->a_item_clear();
				
				if ($a_item['hidden'] || $a_item['selected'])
					$this->output('</DIV>');
				
				$this->c_list(@$a_item['c_list'], 'qa-a-item');

				$this->output('</DIV> <!-- END qa-a-item-main -->');
			}
			else qa_html_theme_base::a_item_main($a_item);
		}
		
		// custom
		
		function printer() {
			$request = explode('/',$this->request);
			$num = $request[0];
			$this->output('<DIV id="printer"><img title="'.qa_html(qa_opt('print_view_title')).'" src="'.QA_HTML_THEME_LAYER_URLTOROOT.'print.png'.'" onclick="window.open(\''.qa_path_html($num.'/print').'\',\'PrintView\',
                  \'resizable=yes,scrollbars=yes,toolbar=no,status=no\');" /></DIV>');
		}
	}
	
