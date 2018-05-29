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
			$this->loader->loadPage('reqpromotion.php', null, 'PromotionRequest', -1, null, null);
		}
		public function requestPromotion()
		{
			if (isset($this->session->actor)){
				// TODO: REGEX sa cirilicnim slovima
				$this->load->library('form_validation');
				
				$this->form_validation->set_rules('position', 'Position', 'required');
				$this->form_validation->set_rules('description', 'Description', 'required');
				
				$position= $this->input->post('position');
				$description = $this->input->post('description');
				if ($this->form_validation->run())
				{
					$request = array
					(
					'title' => $position,
					'description' => $description,
					'submittedon' => new \DateTime('now'),
					'accepted' => 0,
					'actor' => $this->session->actor->getId()
					);
					$this->loader->insertPromotionRequests(array($request));
					echo 'Success';
				}
				else echo '#Error: Data not valid.';
			}
		}
	}
?>