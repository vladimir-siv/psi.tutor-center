<?php

@require_once(APPPATH.'models/Proxy.php');

/**
 * ActorRank
 *
 * @Table(name="actorrank")
 * @Entity
 */
class ActorRank extends Proxy
{
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
     * @var integer
     *
     * @Column(name="Rank", type="integer", nullable=false)
     */
    private $rank;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ManyToMany(targetEntity="Action", inversedBy="actorrank")
     * @JoinTable(name="privileges",
     *   joinColumns={
     *     @JoinColumn(name="ActorRank", referencedColumnName="ID")
     *   },
     *   inverseJoinColumns={
     *     @JoinColumn(name="Action", referencedColumnName="ID")
     *   }
     * )
     */
    private $action;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->action = new \Doctrine\Common\Collections\ArrayCollection();
    }
	
	/*
	 * New() - kreira nov rank
	 *	@param string $name: naziv ranka
	 *	@param int $rank: rank
	 *	@return: ActorRank
	 */
	public static function New($name, $rank)
	{
		$instance = new ActorRank();
		$instance->name = $name;
		$instance->rank = $rank;
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
     * @return ActorRank
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
     * Set rank
     *
     * @param integer $rank
     *
     * @return ActorRank
     */
    public function setRank($rank)
    {
        $this->rank = $rank;

        return $this;
    }

    /**
     * Get rank
     *
     * @return integer
     */
    public function getRank()
    {
        return $this->rank;
    }

    /**
     * Add action
     *
     * @param \Action $action
     *
     * @return ActorRank
     */
    public function addAction(\Action $action)
    {
        $this->action[] = $action;

        return $this;
    }

    /**
     * Remove action
     *
     * @param \Action $action
     */
    public function removeAction(\Action $action)
    {
        $this->action->removeElement($action);
    }

    /**
     * Get action
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getAction()
    {
        return $this->action;
    }
}

abstract class Rank
{
	const Guest = 1;
	const User = 2;
	const Tutor = 3;
	const Moderator = 4;
	const Administrator = 5;
}