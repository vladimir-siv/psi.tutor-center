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
     * @var \ActorRank
     *
	  * @Column(name="ActorRank")
     * @Id
     * @ManyToOne(targetEntity="ActorRank")
     * @JoinColumns({
     *   @JoinColumn(name="ActorRank", referencedColumnName="ID")
     * })
     */
    private $actorrank;
	
	/**
     * @var \Action
     *
     * @Column(name="Action")
     * @Id
     * @ManyToOne(targetEntity="Action")
     * @JoinColumns({
     *   @JoinColumn(name="Action", referencedColumnName="ID")
     * })
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
	 *	@param \Action $action: akcija
	 *	@param \ActorRank $rank: rank
	 *	@return: Privilege
	 */
	public static function New($action, $actorrank)
	{
		$instance = new Privilege();
		$instance->action = $action;
		$instance->actorrank = $actorrank;
		return $instance;
	}
	
	/**
     * Set actorrank
     *
     * @param \ActoRrank $actorrank
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
     * @return \ActorRank
     */
    public function getActorRank()
    {
        return $this->actorrank;
    }
	
	/**
     * Set action
     *
     * @param \Action $action
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
     * @return \Action
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

