<?php

/**
 * PostSection
 *
 * @Table(name="postsections")
 * @Entity
 */
class PostSection extends Proxy
{
	/**
	 * @var integer
	 *
	 * @Column(name="Post", type="integer", nullable=false)
	 * @Id
	 */
	private $post;
	
	/**
	 * @var integer
	 *
	 * @Column(name="Section", type="integer", nullable=false)
	 * @Id
	 */
	private $section;
	
	/**
	 * Constructor
	 */
	public function __construct()
	{
		parent::__construct();
	}
	
	/*
	 * New() - Postavlja postu sekciju kojoj pripada
	 *	@param integer $actor: post
	 *	@param integer $section: sekcija
	 *	@return: SectionSubscription
	 */
	public static function New($post, $section)
	{
		$instance = new PostSection();
		$instance->post = $post;
		$instance->section = $section;
		return $instance;
	}
	
	/**
	 * Set post
	 *
	 * @param integer $post
	 *
	 * @return SectionSubscription
	 */
	public function setPost($post = null)
	{
		$this->post = $post;
		
		return $this;
	}
	
	/**
	 * Get post
	 *
	 * @return integer
	 */
	public function getPost()
	{
		return $this->post;
	}
	
	/**
	 * Set section
	 *
	 * @param integer $section
	 *
	 * @return SectionSubscription
	 */
	public function setSection($section = null)
	{
		$this->section = $section;
		
		return $this;
	}
	
	/**
	 * Get section
	 *
	 * @return integer
	 */
	public function getSection()
	{
		return $this->section;
	}
	
	/* ============== PROXY ============== */
	
	public function loadReferences()
	{
		if (parent::refsAreLoaded()) return;
		
		$this->post = $this->em->find('Post', $this->post);
		$this->section = $this->em->find('Section', $this->section);
		
		parent::loadReferences();
	}
	
	public function unloadReferences()
	{
		if (!parent::refsAreLoaded()) return;
		
		$this->post = $this->post->getId();
		$this->section = $this->section->getId();
		
		parent::unloadReferences();
	}
}