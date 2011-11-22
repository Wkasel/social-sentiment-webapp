<?php
	require_once('class.restapi.php');
	
	class Twitter extends RestApi
	{
		protected $cache_ext = 'twitter';
		
		function __construct($username = false, $password = false)
		{
			if ($username && $password)
				$this->login($username, $password);
			parent::__construct();
		}
		
		/********* STATUS METHODS *********/
		
		function public_timeline()
		{
			$url = "http://twitter.com/statuses/public_timeline.{$this->format}";
			return $this->request($url);
		}
		
		/*
			Available parameters:
				since: HTTP formatted date
				since_id: twitter status ID
				count: integer up to 200
				page: integer
		*/
		function friends_timeline($params = array())
		{
			$url = "http://twitter.com/statuses/friends_timeline.{$this->format}";
			if (count($params) > 0)
				return $this->request($url, array('get'=>$params));
			else
				return $this->request($url);
		}
		
		/*
			Available parameters:
				since: HTTP formatted date
				since_id: twitter status ID
				count: integer up to 200
				page: integer
		*/
		function user_timeline($id = false, $params = array())
		{
	        if ($id === false)
	            $url = "http://twitter.com/statuses/user_timeline.{$this->format}";
	        else
			{
				$id = urlencode($id);
	            $url = "http://twitter.com/statuses/user_timeline/$id.{$this->format}";
			}
			if (count($params) > 0)
				return $this->request($url, array('get'=>$params));
			else
				return $this->request($url);
		}
		
		function show_status($id)
		{
			$url = "http://twitter.com/statuses/show/$id.{$this->format}";
			return $this->request($url);
		}
		
		function update_status($status, $reply_to = false)
		{
			$url = "http://twitter.com/statuses/update.{$this->format}";
			$post = array('status' => $status);
			if ($reply_to !== false)
				$post['in_reply_to_status_id'] = $reply_to;
			return $this->request($url, array('post'=>$post));
		}
		
		/*
			Available parameters:
				since: HTTP formatted date
				since_id: twitter status ID
				page: integer
		*/
		function replies($params = array())
		{
			$url = "http://twitter.com/statuses/replies.{$this->format}";
			if (count($params) > 0)
				return $this->request($url, array('get'=>$params));
			else
				return $this->request($url);
		}
		
		function mentions($params = array())
		{
			$url = "http://twitter.com/statuses/mentions.{$this->format}";
			if (count($params) > 0)
				return $this->request($url, array('get'=>$params));
			else
				return $this->request($url);
		}
		
		function destroy_status($id)
		{
			$url = "http://twitter.com/statuses/destroy/$id.{$this->format}";
			$post = array('id' => $id);
			return $this->request($url, array('post'=>$post));
		}
		
		
		/********* USER METHODS *********/
		
		function friends($id = false, $page = false, $cursor = false)
		{
	        if ($id === false)
	            $url = "http://twitter.com/statuses/friends.{$this->format}";
	        else
			{
				$id = urlencode($id);
	            $url = "http://twitter.com/statuses/friends/$id.{$this->format}";
			}
			if ($page !== false && $page > 1)
				return $this->request($url, array('get'=>array('page'=>$page)));
			elseif ($cursor !== false)
				return $this->request($url, array('get'=>array('cursor'=>$cursor)));
			else
				return $this->request($url);
		}
		
		function followers($id = false, $page = false, $cursor = false)
		{
	        if ($id === false)
	            $url = "http://twitter.com/statuses/followers.{$this->format}";
	        else
			{
				$id = urlencode($id);
	            $url = "http://twitter.com/statuses/followers/$id.{$this->format}";
			}
			if ($page !== false && $page > 1)
				return $this->request($url, array('get'=>array('page'=>$page)));
			elseif ($cursor !== false)
				return $this->request($url, array('get'=>array('cursor'=>$cursor)));
			else
				return $this->request($url);
		}
		
		function show_user($id)
		{
			$id = urlencode($id);
			$url = "http://twitter.com/users/show/{$id}.{$this->format}";
			return $this->request($url);
		}
		
		
		/********* DIRECT MESSAGE METHODS *********/
		
		/*
			Available parameters:
				since: HTTP formatted date
				since_id: twitter status ID
				page: integer
		*/
		function direct_messages($params = array())
		{
			$url = "http://twitter.com/direct_messages.{$this->format}";
			if (count($params) > 0)
				return $this->request($url, array('get'=>$params));
			else
				return $this->request($url);
		}
		
		/*
			Available parameters:
				since: HTTP formatted date
				since_id: twitter status ID
				page: integer
		*/
		function sent_direct_messages($params = array())
		{
			$url = "http://twitter.com/direct_messages/sent.{$this->format}";
			if (count($params) > 0)
				return $this->request($url, array('get'=>$params));
			else
				return $this->request($url);
		}
		
		function new_direct_message($user, $text)
		{
			$url = "http://twitter.com/direct_messages/new.{$this->format}";
			$post = array('user' => $user, 'text' => $text);
			return $this->request($url, array('post'=>$post));
		}
		
		function destroy_direct_message($id)
		{
			$url = "http://twitter.com/direct_messages/destroy/$id.{$this->format}";
			$post = array('id' => $id);
			return $this->request($url, array('post'=>$post));
		}
		
		
		/********* FRIENDSHIP METHODS *********/

		function create_friendship($id, $follow = false)
		{
			$id = urlencode($id);
			$url = "http://twitter.com/friendships/create/$id.{$this->format}";
			$post = array();
			if ($follow)
				$post['follow'] = 'true';
			return $this->request($url, array('post'=>$post), true);
		}

		function destroy_friendship($id)
		{
			$id = urlencode($id);
			$url = "http://twitter.com/friendships/destroy/$id.{$this->format}";
			return $this->request($url, array(), true);
		}
		
		function exists($id1, $id2)
		{
			$url = "http://twitter.com/friendships/exists.{$this->format}";
			$get = array('user_a' => $id1, 'user_b' => $id2);
			return $this->request($url, array('get'=>$get));
		}


		/********* SOCIAL GRAPH METHODS *********/
		
		function friend_ids($id = false)
		{
	        if ($id === false)
	            $url = "http://twitter.com/friends/ids.{$this->format}";
	        else
			{
				$id = urlencode($id);
	            $url = "http://twitter.com/friends/ids/$id.{$this->format}";
			}
			return $this->request($url);
		}
		
		function follower_ids($id = false)
		{
	        if ($id === false)
	            $url = "http://twitter.com/followers/ids.{$this->format}";
	        else
			{
				$id = urlencode($id);
	            $url = "http://twitter.com/followers/ids/$id.{$this->format}";
			}
			return $this->request($url);
		}
		
		
		/********* ACCOUNT METHODS *********/
		function rate_limit_status()
		{
			$url = "http://twitter.com/account/rate_limit_status.{$this->format}";
			return $this->request($url);
		}
		
		/********* FAVORITE METHODS *********/
		function favorites($id = false, $page = false)
		{
	        if ($id === false)
	            $url = "http://twitter.com/favorites.{$this->format}";
	        else
			{
				$id = urlencode($id);
	            $url = "http://twitter.com/favorites/$id.{$this->format}";
			}
			if ($page !== false && $page > 1)
				return $this->request($url, array('get'=>array('page'=>$page)));
			else
				return $this->request($url);
		}
		
		/********* NOTIFICATION METHODS *********/
		function follow($id)
		{
			$url = "http://twitter.com/notifications/follow/{$id}.{$this->format}";
			return $this->request($url, array(), true);
		}
		function leave($id)
		{
			$url = "http://twitter.com/notifications/leave/{$id}.{$this->format}";
			return $this->request($url, array(), true);
		}
		
	}
