<?php
/**
 * MiniMVC
 *
 * Convention-based micro-framework for PHP
 *
 * @package		miniMVC
 * @author 		Timothy J. Warren
 * @copyright	Copyright (c) 2011 - 2012
 * @link 		https://github.com/aviat4ion/miniMVC
 * @license 	http://philsturgeon.co.uk/code/dbad-license 
 */
 
// --------------------------------------------------------------------------

namespace miniMVC;

/**
 * Class for building pages
 *
 * All methods are chainable, with the exception of the constructor,
 * build_header(), build_footer(), and _headers() methods.
 *
 * @package miniMVC
 * @subpackage System
 */
class Page extends Output {

	/**
	 * Meta tags
	 *
	 * @var string
	 */
	private $meta;
	
	/**
	 * JS tags for the header
	 *
	 * @var string
	 */
	private $head_js; 
	
	/**
	 * JS tags for the footer
	 *
	 * @var string
	 */
	private $foot_js; 
	
	/**
	 * CSS tags for the page
	 *
	 * @var string
	 */
	private $css; 
	
	/**
	 * Page title
	 *
	 * @var string
	 */
	private $title; 
	
	/**
	 * Additional header tags
	 *
	 * @var string
	 */
	private $head_tags; 
	
	/**
	 * Class(es) to apply to the main body tag
	 *
	 * @var string
	 */
	private $body_class; 
	
	/**
	 * Id to apply to the body tag
	 *
	 * @var string
	 */
	private $body_id; 
	
	/**
	 * Base tag
	 *
	 * @var string
	 */
	private $base;
	
	/**
	 * Set up the page class
	 *
	 * @param object
	 * @return void
	 */
	public function __construct(&$controller)
	{
		$this->meta       = "";
		$this->head_js    = "";
		$this->foot_js    = "";
		$this->css        = "";
		$this->title      = "";
		$this->head_tags  = "";
		$this->body_class = "";
		$this->body_id    = "";
		$this->base       = "";
		
		$this->mm = $controller;
	}
	
	// --------------------------------------------------------------------------
	
	/**
	 * call the parent destructor
	 */
	public function __destruct()
	{
		parent::__destruct();
	}
	
	// --------------------------------------------------------------------------
	
	/**
	 * Sets server headers and doctype
	 *
	 * Also sets page mime type, based on if sent as
	 * html or xhtml, and what the target browser
	 * supports
	 *
	 * @param bool $html5
	 * @return Page
	 */
	private function _headers($html5)
	{
		$this->set_header("Cache-Control", "must-revalidate, public");
		$mime = "";
		
		//Variable for accept keyword
		$accept = ( ! empty($_SERVER['HTTP_ACCEPT'])) ? $_SERVER['HTTP_ACCEPT'] : "";
		
		//Predefine doctype
		$doctype_string = ($html5 == TRUE) ? '<!DOCTYPE html>' : '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN">';
		
		//Predefine charset
		$charset = "UTF-8";
		
		$mime = "text/html";
			
		if ($html5 == FALSE)
		{
			$doctype_string = '<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN">';
		}
		
		$doctype_string .= "<html lang='en'>";
		
		// finally, output the mime type and prolog type
		$this->set_header("Content-Type", "{$mime};charset={$charset}");
		$this->set_header("X-UA-Compatible", "chrome=1, IE=edge");
		$this->set_output($doctype_string);
		
		return $this;
	}
	
	// --------------------------------------------------------------------------
	
	/**
	 * Set Meta
	 *
	 * Sets meta tags, with codeigniter native meta tag helper
	 * 
	 * @param array $meta
	 * @return Page
	 */
	public function set_meta($meta)
	{
		$this->meta .= $this->_meta($meta);
		return $this;
	}
	
	// --------------------------------------------------------------------------
	
	/**
	 * Sets minified javascript group in header
	 *
	 * @param string $group
	 * @param bool $debug
	 * @return Page
	 */
	public function set_head_js_group($group, $debug = FALSE)
	{
		if ($group === FALSE)
		{
			return $this;
		}
		
		$file = SCRIPT_PATH . $group;
		$file .= ($debug == TRUE) ? "/debug/1" : "";
		$this->head_js .= $this->script_tag($file, FALSE);
		return $this;
	}
	
	// --------------------------------------------------------------------------
	
	/**
	 * Sets a minified css group
	 * @param string $group
	 * @return Page
	 */
	public function set_css_group($group)
	{
		$link = [
			'href' => STYLE_PATH . $group,
			'rel' => 'stylesheet',
			'type' => 'text/css'
		];
		$this->css .= $this->_link_tag($link);
		
		return $this;
	}
	
	// --------------------------------------------------------------------------
	
	/**
	 * Sets a minified javascript group for the page footer
	 *
	 * @param string $group
	 * @param bool $debug
	 * @return Page
	 */
	public function set_foot_js_group($group, $debug = FALSE)
	{
		$file = SCRIPT_PATH . $group;
		$file .= ($debug == TRUE) ? "/debug/1" : "";
		$this->foot_js .= $this->script_tag($file, FALSE);
		return $this;
	}
	
	// --------------------------------------------------------------------------
	
	/**
	 * Sets html title string
	 *
	 * @param string $title
	 * @return Page
	 */
	public function set_title($title = "")
	{
		$title = ($title == "") ? DEFAULT_TITLE : $title;
		
		$this->title = $title;
		
		return $this;
	}
	
	// --------------------------------------------------------------------------
	
	/**
	 * Sets custom body class
	 *
	 * @param string $class
	 * @return Page
	 */
	public function set_body_class($class = "")
	{
		$this->body_class = $class;
		return $this;
	}
	
	// --------------------------------------------------------------------------
	
	/**
	 * Sets custom body id
	 *
	 * @param string $id
	 * @return Page
	 */
	public function set_body_id($id = "")
	{
		$this->body_id = $id;
		return $this;
	}
	
	// --------------------------------------------------------------------------
	
	/**
	 * Sets custom base href
	 *
	 * @param string href
	 * @return Page
	 */
	public function set_base($href)
	{
		$this->base = $href;
		return $this;
	}
	
	// --------------------------------------------------------------------------
	
	/**
	 * Sets custom css tags
	 *
	 * @param string $name
	 * @param bool $domain
	 * @param string $media
	 * @return Page
	 */
	public function set_css_tag($name, $domain = TRUE, $media = "all")
	{
		$path     = CONTENT_DOMAIN;
		$css_file = "{$path}/css/{$name}.css";
		
		if ($domain == FALSE)
		{
			$css_file = $name;
		}
		
		$this->css_tags .= $this->_link_tag([
			'rel' => 'stylesheet',
			'type' => 'text/css',
			'media' => $media,
			'href' => $css_file,
		]);
		
		return $this;
	}
	
	// --------------------------------------------------------------------------
	
	/**
	 * Sets a custom tag in the header
	 *
	 * @param string $tag
	 * @return Page
	 */
	public function set_head_tag($tag)
	{
		$this->head_tags .= $tag;
		return $this;
	}
	
	// --------------------------------------------------------------------------
	
	/**
	 * Sets custom page header
	 *
	 * @param bool $html5
	 * @return Page
	 */
	public function build_header($html5 = TRUE)
	{
		$data = array();
		
		//Set Meta Tags
		$this->meta   = ($html5 == TRUE) 
			? '<meta charset="utf-8" />'. $this->meta 
			: $this->_meta([
				'http-equiv' => 'Content-Type',
				'content' => 'text/html; charset=utf-8',
			]) . $this->meta;
		
		$data['meta'] = $this->meta;
		
		//Set CSS
		if ($this->css !== "")
		{
			$data['css'] = $this->css;
		}
		else
		{
			//Set default CSS group
			$this->set_css_group(DEFAULT_CSS_GROUP);
			$data['css'] = $this->css;
		}
		
		//Set head javascript
		$data['head_js'] = ( ! empty($this->head_js)) ? $this->head_js : "";
		
		//Set Page Title
		$data['title'] = ($this->title !== '') ? $this->title : DEFAULT_TITLE;
		
		//Set Body Class
		$data['body_class'] = $this->body_class;
		
		//Set Body Id
		$data['body_id'] = $this->body_id;
		
		//Set Base HREF
		$data['base'] = $this->base;
		
		//Set individual head tags
		$data['head_tags'] = $this->head_tags;
		
		//Set Server Headers and Doctype
		$this->_headers($html5);
		
		//Output Header
		$this->mm->load_view('header', $data);
		
		return $this;
	}
	
	// --------------------------------------------------------------------------
	
	/**
	 * Builds common footer with any additional js
	 */
	public function build_footer()
	{
		$data = array();
		
		$data['foot_js'] = ($this->foot_js != "") ? $this->foot_js : '';
		
		$this->mm->load_view('footer', $data);
	}
	
	// --------------------------------------------------------------------------
	
	/**
	 * Script Tag
	 *
	 * Helper function for making script tags
	 *
	 * @param string $js
	 * @param bool $domain
	 * @return string
	 */
	private function script_tag($js, $domain = TRUE)
	{
		$path    = CONTENT_DOMAIN;
		$js_file = "{$path}/js/{$js}.js";
		
		if ($domain == FALSE)
		{
			$js_file = $js;
		}
		
		$tag = '<script src="' . $js_file . '"></script>';
		
		return $tag;
	}
	
	// --------------------------------------------------------------------------
	
	/**
	 * Set Message
	 *
	 * Adds a message to the page
	 * @param string $type
	 * @param string $message
	 * @param bool $return
	 * @return void
	 */
	public function set_message($type, $message, $return=FALSE)
	{
		$data['stat_class'] = $type;
		$data['message']    = $message;
		
		return $this->mm->load_view('message', $data, $return);
	}
	
	// --------------------------------------------------------------------------
	
	/**
	 * Redirect 303
	 *
	 * Shortcut function for 303 redirect
	 * @param string $url
	 */
	function redirect_303($url)
	{
		$this->set_header("HTTP/1.1 303 See Other");
		$this->set_header("Location:" . $url);
	}
	
	// --------------------------------------------------------------------------
	
	/**
	 * Render
	 *
	 * Shortcut function for building a page
	 * @param string $view
	 * @param array $data
	 */
	function render($view, $data=array())
	{
		$this->build_header();
		$this->mm->load_view($view, $data);
		$this->build_footer();
	}
	
	// --------------------------------------------------------------------------
	
	/**
	 * Output String
	 *
	 * Similar to render(), this is a shortcut
	 * to output a string in the body of the 
	 * page.
	 * @param string $string
	 */
	function output_string($string)
	{
		$this->build_header();
		$this->append_output($string);
		$this->build_footer();
	}
	
	// --------------------------------------------------------------------------

	/**
	 * Private helper function to generate meta tags
	 *
	 * @param array $params
	 * @return string
	 */
	private function _meta($params)
	{
		$string = "<meta ";
	
		foreach ($params as $k => &$v)
		{
			$string .= $k.'="'.$v.'" ';
		}
		
		$string .= " />";
		
		return $string;
	}
	
	// --------------------------------------------------------------------------

	/**
	 * Private helper function to generate link tags
	 *
	 * @param array $params
	 * @return string
	 */ 
	private function _link_tag($params)
	{
		$string = "<link ";
		
		foreach ($params as $k => &$v)
		{
			$string .= $k . '="'.$v.'" ';
		}
		
		$string .= "/>";
		
		return $string;
	}
}

// End of page.php