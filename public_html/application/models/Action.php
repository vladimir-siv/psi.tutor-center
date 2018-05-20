<?php



use Doctrine\ORM\Mapping as ORM;

/**
 * Action
 *
 * @ORM\Table(name="action", uniqueConstraints={@ORM\UniqueConstraint(name="Name", columns={"Name"})})
 * @ORM\Entity
 */
class Action
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
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Actorrank", mappedBy="action")
     */
    private $actorrank;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->actorrank = new \Doctrine\Common\Collections\ArrayCollection();
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
}

