<?php



use Doctrine\ORM\Mapping as ORM;

/**
 * ActorRank
 *
 * @ORM\Table(name="actorrank")
 * @ORM\Entity
 */
class ActorRank
{
    /**
     * @var integer
     *
     * @ORM\Column(name="ID", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="Name", type="string", length=64, nullable=false)
     */
    private $name;

    /**
     * @var integer
     *
     * @ORM\Column(name="Rank", type="integer", nullable=false)
     */
    private $rank;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Action", inversedBy="actorrank")
     * @ORM\JoinTable(name="privileges",
     *   joinColumns={
     *     @ORM\JoinColumn(name="ActorRank", referencedColumnName="ID")
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="Action", referencedColumnName="ID")
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

