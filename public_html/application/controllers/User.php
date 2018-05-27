<?php
	defined('BASEPATH') OR exit('No direct script access allowed');
	require_once 'application/models/Entities.php';
	require_once 'application/controllers/Guest.php';
	
	class User extends Guest
	{
		public function __construct()
		{
			parent::__construct();
		}
		
		public function create_post()
		{
			$this->loader->loadPage('create-post.php', null, 'Create Post', -1, array('assets/js/posts.js', 'assets/ajax/search.ajax.js'));
		}
		
		public function req_promotion()
		{
			throw new Exception('Not Yet Implemented');
		}
	}
?>