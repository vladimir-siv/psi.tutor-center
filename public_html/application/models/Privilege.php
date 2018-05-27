<?php

/**
 * Privilege
 *
 * @Table(name="privileges")
 * @Entity
 */
class Privilege extends Proxy
{
	/* ================= STATIC ================= */
	
	/*
	 * has() - checks if rank has privilege for the action
	 *	@param Rank $rank: rank aktora
	 *	@param string $actionname: naziv akcije
	 *	@return: bool
	 */
	public static function has($rank, $actionname)
	{
		$action = Action::findByName($actionname);
		if ($action === null) throw new Exception('Invalid action');
		
		$privileges = parent::$_em->createQuery('SELECT p from Privilege p WHERE p.actorrank <= :actorrank AND p.action = :action')
					->setParameter('actorrank', $rank)
					->setParameter('action', $action->getId())
					->getResult();
		
		if ($privileges == NULL || count($privileges) == 0) return false;
		
		return true;
	}
	
	/* ================ INSTANCE ================ */
	
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

abstract class Privileges
{
	private static $enumeration = array
	(
        'CreatePost' => Rank::User,
        'Reply' => Rank::User,
        'LockPost' => Rank::Tutor,
        'ReleasePost' => Rank::User,
        'SubmitTokens' => Rank::User,
        'WorkerAccepted' => Rank::Tutor,
        'DeleteReply' => Rank::Moderator,
        'DeletePost' => Rank::Moderator,
        'BanUser' => Rank::Administrator,
        'DeleteSubject' => Rank::Administrator,
        'DeleteSection' => Rank::Administrator,
        'BuyTokens' => Rank::User,
        'SellTokens' => Rank::Tutor,
        'CreateSubject' => Rank::Administrator,
        'CreateSection' => Rank::Administrator,
        'Review' => Rank::User,
        'ChangeAbout' => Rank::User,
        'ChangeDetails' => Rank::User
	);
	
	public static function Enumerate()
	{
		return self::$enumeration;
	}
}