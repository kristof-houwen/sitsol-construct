<?php


require_once(APP_PATH . '/lib/smarty/Smarty.class.php');

interface IView {
	public function render();
}

class StsHtmlView implements IView {
	
	private $_smarty = null;
	private $_tmplDirs = null;
	private $_masterTemplate = null;    // masterpage
	private $_contentTemplate = null;	// filename used for content display  {include file="$content"}
	private $_viewModel = null;			// every view has a viewmodel {$model}
	
	private $_error404 = "error/error404.html";


	/* ***** FIELDS & CONSTRUCTORS ********** */

	public function __construct()
	{
		$this->_smarty = new Smarty();
		$this->_smarty->setTemplateDir(SMARTY_TEMPLATE_PATH);
		$this->_smarty->setCompileDir(SITE_PATH . '/templates_c');
		$this->_smarty->setConfigDir(SITE_PATH . '/config');
		$this->_smarty->setCacheDir(SITE_PATH . '/cache');

		$this->_tmplDirs = $this->_smarty->getTemplateDir();
	}

	/* ***** GETTERS - SETTERS ********** */ 
	public function get_masterTemplate()
	{
		return $this->_masterTemplate();
	}

	public function set_masterTemplate($value) 
	{
		$this->_masterTemplate = $value;

	}

	public function get_contentTemplate() 
	{
		return $this->_contentTemplate;
	}

	public function set_contentTemplate($value)
	{
		$this->_contentTemplate = $value;
	}

	public function get_viewModel()
	{
		return $this->_viewModel;
	}

	public function set_viewModel($value)
	{
		$this->_viewModel = $value;
	}

	/* ***** PUBLIC FUNCTIONS ********** */
	public function render()
	{
		// $this->createView();
		// try {
		// 	$this->_smarty->display($this->_masterTemplate);
		// } catch (Exception $e) {
		// 	echo 'Caught exception: ',  $e->getMessage(), "\n";
		// }

		$model = null;
		if ($this->_viewModel != null) {
			$model=$this->_viewModel;
		}
			//$this->_smarty->assign('model', $this->_viewModel);
		
		if ($this->_contentTemplate != null && is_file($this->_tmplDirs[0] . $this->_contentTemplate))
			include($this->_tmplDirs[0] . $this->_contentTemplate);
	}
	
	/**
	 * use this function to assign variables you have declared in the template
	 */
	public function addVar($varname, $value) {
		$this->_smarty->assign($varname, $value);
	}

	/* ***** Private helper functions ********** */
	
	/**
	 * Method to assign content template and model to smarty
	 */
	private function createView(){
		if ($this->_masterTemplate == null || !is_file($this->_tmplDirs[0] . $this->_masterTemplate)) {
			$this->_masterTemplate = $this->_error404;
			return -1;
		}
		
		// only needed to execute when there is no error in mastertemplate
		if ($this->_contentTemplate != null && is_file($this->_tmplDirs[0] . $this->_contentTemplate))
			$this->_smarty->assign('content', $this->_contentTemplate);

		if ($this->_viewModel != null)
			//$this->_smarty->assign('model', $this->_viewModel);
			$model=$this->_viewModel;

	}



		

}


?>
