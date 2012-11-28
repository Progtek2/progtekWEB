<?php
/**
 * Class used by presentation files
 * @author Eivind Kleiven
 *
 */
class View_User_News
{
	public $user = null;
	public $news;
	public $allNews = Array();
	public $keywordNews = Array();
	public $module = "user";
	public $controller = "news";
	public $action = "index";
	
	public function __construct()
	{
		// Get the module and controller from $_POST or $_GET
		$module = fetch('Module');
		$controller = fetch('Controller');

		
		// Set to true if user is logged in
		$this->user = UserDBManager::GetUserFromId(Authenticate::GetUserId());
		
		// If user is logged in get news for the user
		if($this->user != null)
		{
			$this->news = NewsDBManager::GetNewsForUserId($this->user->GetUserId());
			$keywords = $this->user->GetKeywords();
			foreach($keywords as $keyword)
			{
				$match = NewsDBManager::GetNewsForKeyword($keyword);
				if(!empty($match))
					$this->keywordNews[$keyword->GetKeyword()] = NewsDBManager::GetNewsForKeyword($keyword);
			}			
		}
		else
			$this->news = NewsDBManager::GetAllNews(0,10);
			
		$this->allNews = NewsDBManager::GetAllNews();
		
		// Get the requested action
		if($module == $this->module && $controller == $this->controller)
		{
			$action = Fetch('Action');
			$this->action = 'index';
		}
		
	}
}