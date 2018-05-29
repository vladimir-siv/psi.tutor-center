<?php

/**
 * PromotionRequest
 *
 * @Table(name="promotionrequests", indexes={@Index(name="Actor", columns={"Actor"})})
 * @Entity
 */
class PromotionRequest extends Proxy
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
     * @Column(name="Title", type="string", length=64, nullable=false)
     */
    private $title;

    /**
     * @var string
     *
     * @Column(name="Description", type="string", length=64, nullable=false)
     */
    private $description;

    /**
     * @var \DateTime
     *
     * @Column(name="SubmittedOn", type="date", nullable=false)
     */
    private $submittedon;

    /**
     * @var boolean
     *
     * @Column(name="Accepted", type="boolean", nullable=true)
     */
    private $accepted;

    /**
     * @var integer
     *
     * @Column(name="Actor", type="integer", nullable=false)
     */
    private $actor;

    /*
	 * New() - kreira novi promotion request
	 *	@param string $title: naslov koji actor unosi
	 *	@param string $description: opis koji actor unosi
     *	@param \DateTime $submittedon: datum postavljanja zahteva
     *	@param bool $accepted: da li je zahtev prihvacen
     *	@param integer $actor: actor koji je postavio zahtev
	 *	@return: PromotionRequest
	 */
	public static function New($title, $description, $submittedon, $accepted, $actor)
	{
		$instance = new PromotionRequest();
		$instance->title = $title;
        $instance->description = $description;
        $instance->submittedon = $submittedon;
        $instance->accepted = $accepted;
        $instance->actor = $actor;
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
     * Set title
     *
     * @param string $title
     *
     * @return PromotionRequest
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
     * @return PromotionRequest
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
     * @return PromotionRequest
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
     * @return PromotionRequest
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
     * @param integer $actor
     *
     * @return PromotionRequest
     */
    public function setActor(\Actor $actor = null)
    {
        $this->actor = $actor;

        return $this;
    }

    /**
     * Get actor
     *
     * @return integer
     */
    public function getActor()
    {
        return $this->actor;
    }

    /* ============== PROXY ============== */
	
	public function loadReferences()
	{
		if (parent::refsAreLoaded()) return;
		
		$this->actor = $this->em->find('Actor', $this->actor);
		
		parent::loadReferences();
	}
	
	public function unloadReferences()
	{
		if (!parent::refsAreLoaded()) return;
		
		$this->actor = $this->actor->getId();
		
		parent::unloadReferences();
	}
}

