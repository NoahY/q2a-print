<?php

	class qa_html_theme_layer extends qa_html_theme_base {

	// register default settings

		function option_default($option) {

			switch($option) {
				default:
					return false;
			}
			
		}

		private $pr;

		function head_css()
		{
			if($this->pr) {
				$this->output('<style>
					h1, h2 {margin-bottom: 12px;}
					.qa-vote-count {margin-bottom: 12px;}

					.qa-q-view-content {margin-bottom:12px;}
					.qa-q-view-tags {margin-bottom:12px;}
					.qa-q-view-tag-list {list-style:none; margin:0; padding:0;}
					.qa-q-view-tag-item {display:inline;}	
					.qa-q-view-main {border-bottom:1px dotted #666; padding-bottom:12px;}
					.qa-q-view-meta {margin-bottom:12px;}

					.qa-a-list-item {padding-top:12px;}
					.qa-a-item-content {font-size:14px; margin-bottom:12px;}
					.qa-a-item-main {border-bottom:1px dotted #666; padding-bottom:12px;}

					.qa-c-list-item {
					  border-top: 1px dotted #666666;
					  margin: 12px 0 0 24px;
					  padding-top: 12px;
					}
					#printer {
						cursor: pointer;
						float: right;
						margin: 12px;
					}
				</style>');
			}
			else {
				$this->output('
				<style>
					#printer {
						cursor: pointer;
						float: right;
						margin: 12px;
					}
				</style>');
					
				qa_html_theme_base::head_css();
			}
		}
		function head()
		{
			$request_parts =  explode('/',$this->request);
			$this->pr = ($request_parts[1] == 'print');
			if($this->pr) {
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
			if($this->pr) {

				$this->output('<BODY onload="window.print()">');
				
				$this->body_content();
					
				$this->output('</BODY>');
			}
			else qa_html_theme_base::body();
		}		

		function body_content()
		{
			if($this->pr) {

				$this->output('<DIV CLASS="qa-body-wrapper">', '');

				$this->main();
				
				$this->output('</DIV> <!-- END body-wrapper -->');
			}
			else qa_html_theme_base::body_content();
		}
		function main()
		{
			if($this->pr) {
				$content=$this->content;

				$this->output('<DIV CLASS="qa-main'.(@$this->content['hidden'] ? ' qa-main-hidden' : '').'">');
				
				$this->page_title();			

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
			if(!$this->pr && $this->template == 'question') {
				$this->printer();
			}
			qa_html_theme_base::page_title();
		}
		function main_parts($content)
		{
			if($this->pr) {
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
			if($this->pr) {
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
			if($this->pr) {
				$this->vote_count($post);
				$this->vote_clear();
			}
			else qa_html_theme_base::voting_inner_html($post);
		}
		function c_item_main($c_item)
		{
			if($this->pr) {
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
			if($this->pr) {
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
				$this->form(@$a_item['c_form']);

				$this->output('</DIV> <!-- END qa-a-item-main -->');
			}
			else qa_html_theme_base::a_item_main($a_item);
		}
		
		// custom
		
		function printer() {
			$request = explode('/',$this->request);
			$num = $request[0];
			$this->output('<DIV id="printer"><img title="Print" src="'.QA_HTML_THEME_LAYER_URLTOROOT.'print.png'.'" onclick="window.open(\''.qa_path_html($num.'/print').'\',\'Print View\',
                  \'toolbar=no,status=no\');" /></DIV>');
		}
	}
	
