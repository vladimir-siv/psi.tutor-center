<?php

/**
 * Privilege
 *
 * @Table(name="sectionsubscriptions")
 * @Entity
 */
class SectionSubscription extends Proxy
{
	/**
	 * @var integer
	 *
	 * @Column(name="Actor", type="integer", nullable=false)
	 * @Id
	 */
	private $actor;
	
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
	 * New() - kreira novu sabskripciju
	 *	@param integer $actor: aktor
	 *	@param integer $section: sekcija
	 *	@return: SectionSubscription
	 */
	public static function New($actor, $section)
	{
		$actor = $this->em->find('Actor', $actor);
		if ($actor === null || $actor->getRawRank() < Rank::Tutor) throw Exception('Invalid tutor.'); 
		
		$instance = new SectionSubscription();
		$instance->actor = $actor->getId();
		$instance->section = $section;
		return $instance;
	}
	
	/**
	 * Set actor
	 *
	 * @param integer $actor
	 *
	 * @return SectionSubscription
	 */
	public function setActior($actor = null)
	{
		$this->actor = $actor;
		
		return $this;
	}
	
	/**
	 * Get actor
	 *
	 * @return integer
	 */
	public function getActior()
	{
		return $this->actor;
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
		
		$this->actior = $this->em->find('Actior', $this->actior);
		$this->section = $this->em->find('Section', $this->section);
		
		parent::loadReferences();
	}
	
	public function unloadReferences()
	{
		if (!parent::refsAreLoaded()) return;
		
		$this->actior = $this->actior->getId();
		$this->section = $this->section->getId();
		
		parent::unloadReferences();
	}
}