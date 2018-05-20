<?php



use Doctrine\ORM\Mapping as ORM;

/**
 * WorkPost
 *
 * @ORM\Table(name="workpost", indexes={@ORM\Index(name="Worker", columns={"Worker"})})
 * @ORM\Entity
 */
class WorkPost
{
    /**
     * @var string
     *
     * @ORM\Column(name="Description", type="string", length=64, nullable=false)
     */
    private $description;

    /**
     * @var string
     *
     * @ORM\Column(name="ComittedTokens", type="decimal", precision=10, scale=0, nullable=true)
     */
    private $comittedtokens;

    /**
     * @var boolean
     *
     * @ORM\Column(name="WorkerAccepted", type="boolean", nullable=false)
     */
    private $workeraccepted = '0';

    /**
     * @var \Post
     *
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     * @ORM\OneToOne(targetEntity="Post")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="ID", referencedColumnName="ID")
     * })
     */
    private $id;

    /**
     * @var \Actor
     *
     * @ORM\ManyToOne(targetEntity="Actor")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="Worker", referencedColumnName="ID")
     * })
     */
    private $worker;


    /**
     * Set description
     *
     * @param string $description
     *
     * @return WorkPost
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
     * Set comittedtokens
     *
     * @param string $comittedtokens
     *
     * @return WorkPost
     */
    public function setComittedtokens($comittedtokens)
    {
        $this->comittedtokens = $comittedtokens;

        return $this;
    }

    /**
     * Get comittedtokens
     *
     * @return string
     */
    public function getComittedtokens()
    {
        return $this->comittedtokens;
    }

    /**
     * Set workeraccepted
     *
     * @param boolean $workeraccepted
     *
     * @return WorkPost
     */
    public function setWorkeraccepted($workeraccepted)
    {
        $this->workeraccepted = $workeraccepted;

        return $this;
    }

    /**
     * Get workeraccepted
     *
     * @return boolean
     */
    public function getWorkeraccepted()
    {
        return $this->workeraccepted;
    }

    /**
     * Set id
     *
     * @param \Post $id
     *
     * @return WorkPost
     */
    public function setId(\Post $id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Get id
     *
     * @return \Post
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set worker
     *
     * @param \Actor $worker
     *
     * @return WorkPost
     */
    public function setWorker(\Actor $worker = null)
    {
        $this->worker = $worker;

        return $this;
    }

    /**
     * Get worker
     *
     * @return \Actor
     */
    public function getWorker()
    {
        return $this->worker;
    }
}

