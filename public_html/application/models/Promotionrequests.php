<?php



use Doctrine\ORM\Mapping as ORM;

/**
 * Promotionrequests
 *
 * @ORM\Table(name="promotionrequests", indexes={@ORM\Index(name="Actor", columns={"Actor"})})
 * @ORM\Entity
 */
class Promotionrequests
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
     * @ORM\Column(name="Title", type="string", length=64, nullable=false)
     */
    private $title;

    /**
     * @var string
     *
     * @ORM\Column(name="Description", type="string", length=64, nullable=false)
     */
    private $description;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="SubmittedOn", type="date", nullable=false)
     */
    private $submittedon;

    /**
     * @var boolean
     *
     * @ORM\Column(name="Accepted", type="boolean", nullable=true)
     */
    private $accepted;

    /**
     * @var \Actor
     *
     * @ORM\ManyToOne(targetEntity="Actor")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="Actor", referencedColumnName="ID")
     * })
     */
    private $actor;


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
     * Set title
     *
     * @param string $title
     *
     * @return Promotionrequests
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return Promotionrequests
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set submittedon
     *
     * @param \DateTime $submittedon
     *
     * @return Promotionrequests
     */
    public function setSubmittedon($submittedon)
    {
        $this->submittedon = $submittedon;

        return $this;
    }

    /**
     * Get submittedon
     *
     * @return \DateTime
     */
    public function getSubmittedon()
    {
        return $this->submittedon;
    }

    /**
     * Set accepted
     *
     * @param boolean $accepted
     *
     * @return Promotionrequests
     */
    public function setAccepted($accepted)
    {
        $this->accepted = $accepted;

        return $this;
    }

    /**
     * Get accepted
     *
     * @return boolean
     */
    public function getAccepted()
    {
        return $this->accepted;
    }

    /**
     * Set actor
     *
     * @param \Actor $actor
     *
     * @return Promotionrequests
     */
    public function setActor(\Actor $actor = null)
    {
        $this->actor = $actor;

        return $this;
    }

    /**
     * Get actor
     *
     * @return \Actor
     */
    public function getActor()
    {
        return $this->actor;
    }
}

