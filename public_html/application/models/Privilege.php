<?php

/**
 * Privilege
 *
 * @Table(name="privileges")
 * @Entity
 */
class Privilege extends Proxy
{
    /**
     * @var integer
     *
     * @Column(name="ActorRank", type="integer", nullable=false)
	 * @Id
     */
    private $actorrank;
	
    /**
     * @var integer
     *
     * @Column(name="Action", type="integer", nullable=false)
	 * @Id
     */
    private $action;
	
	/**
     * Constructor
     */
	public function __construct()
	{
		parent::__construct();
	}
	
	/*
	 * New() - kreira novu privilegiju
	 *	@param integer $actorrank: actorrank
	 *	@param integer $action: akcija
	 *	@return: Privilege
	 */
	public static function New($actorrank, $action)
	{
		$instance = new Privilege();
		$instance->actorrank = $actorrank;
		$instance->action = $action;
		return $instance;
	}
	
	/**
     * Set actorrank
     *
     * @param integer $actorrank
     *
     * @return Privilege
     */
    public function setActorRank($actorrank = null)
    {
        $this->actorrank = $actorrank;
		
        return $this;
    }
	
    /**
     * Get actorrank
     *
     * @return integer
     */
    public function getActorRank()
    {
        return $this->actorrank;
    }
	
	/**
     * Set action
     *
     * @param integer $action
     *
     * @return Privilege
     */
    public function setAction($action = null)
    {
        $this->action = $action;
		
        return $this;
    }
	
    /**
     * Get action
     *
     * @return integer
     */
    public function getAction()
    {
        return $this->action;
    }
	
	/* ============== PROXY ============== */
	
	public function loadReferences()
	{
		if (parent::refsAreLoaded()) return;
		
		$this->actorrank = $this->em->find('ActorRank', $this->actorrank);
		$this->action = $this->em->find('Action', $this->action);
		
		parent::loadReferences();
	}
	public function unloadReferences()
	{
		if (!parent::refsAreLoaded()) return;
		
		$this->actorrank = $this->actorrank->getId();
		$this->action = $this->action->getId();
		
		parent::unloadReferences();
	}
}

