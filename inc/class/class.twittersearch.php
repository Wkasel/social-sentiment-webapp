<?php
	require_once('inc/class/class.restapi.php');
	
	class TwitterSearch extends RestApi
	{
		protected $cache_ext = 'twittersearch';
		protected $next;
		/*
			Available parameters:
				lang: ISO 639-1 language code
				rpp: integer up to 100 (results per page)
				page: integer
				since_id: twitter status ID
				geocode: latitude,longitude,radius (radius in mi or km: e.g. 10mi)
				show_user: set to "true" to add username to tweet
		*/
		
		private function process($result)
		{
			if (is_object($result) && isset($result->results))
			{
				if (isset($result->next_page))
					$this->next = $result->next_page;
				else
					$this->next = false;
				return $result->results;
			}
			else
			{
				$this->next = null;
				return false;
			}
		}
		
		function search($query, $params = array())
		{
			$url = "http://search.twitter.com/search.{$this->format}";
			$get = array('q' => $query);
			$get = array_merge($get, $params);
			$result = $this->request($url, array('get'=>$get));
			return $this->process($result);
		}
		
		function next()
		{
			if ($this->next)
			{
				$url = "http://search.twitter.com/search.{$this->format}";
				$result = $this->request($url.$this->next);
				return $this->process($result);
			}
			else
				return false;
		}
	}