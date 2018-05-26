<?php

/**
 * Action
 *
 * @Table(name="action", uniqueConstraints={@UniqueConstraint(name="Name", columns={"Name"})})
 * @Entity
 */
class Action extends Proxy
{
	/* ================= STATIC ================= */
	
	/*
	 * findByName() - dohvata akciju po nazivu
	 *	@param string $name: naziv akcije
	 *	@return: Action
	 */
	public static function findByName($name)
	{
		$actions = parent::$_em->getRepository(Action::class)->findBy(array
		(
			'name' => $name
		));
		
		if ($actions == NULL || count($actions) > 1) return NULL;
		return $actions[0];
	}
	
	/* ================ INSTANCE ================ */
	
    /**
     * @var integer
     *
     * @Column(name="ID", type="integer", nullable=false)
     * @Id
     * @GeneratedValue(strategy="IDENTITY")
     */
    private $id;
	
    /**
     * @var string
     *
     * @Column(name="Name", type="string", length=64, nullable=false)
     */
    private $name;
	
    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ManyToMany(targetEntity="Actorrank", mappedBy="action")
     */
    private $actorrank;
	
    /**
     * Constructor
     */
    public function __construct()
    {
		parent::__construct();
        $this->actorrank = new \Doctrine\Common\Collections\ArrayCollection();
    }
	
	/*
	 * New() - kreira novu akciju
	 *	@param string $name: ime akcije
	 *	@param \ActorRank $rank: minimalni rank za akciju (koji ima privilegije za nju)
	 *	@return: Action
	 */
	public static function New($name, $rank)
	{
		$instance = new Action();
		$instance->name = $name;
		$instance->addActorrank($rank);
		return $instance;
	}
	
    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }
	
    /**
     * Set name
     *
     * @param string $name
     *
     * @return Action
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }
	
    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }
	
    /**
     * Add actorrank
     *
     * @param \Actorrank $actorrank
     *
     * @return Action
     */
    public function addActorrank(\Actorrank $actorrank)
    {
        $this->actorrank[] = $actorrank;

        return $this;
    }
	
    /**
     * Remove actorrank
     *
     * @param \Actorrank $actorrank
     */
    public function removeActorrank(\Actorrank $actorrank)
    {
        $this->actorrank->removeElement($actorrank);
    }
	
    /**
     * Get actorrank
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getActorrank()
    {
        return $this->actorrank;
    }
	
	/**
	 * Get privilege
	 *
	 * @return \Privilege
	 */
	public function getPrivilege()
	{
		return Privilege::New($this->actorrank[0]->getId(), $this->getId());
	}
}