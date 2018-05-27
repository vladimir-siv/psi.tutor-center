<?php

/**
 * QAPost
 *
 * @Table(name="qapost", indexes={@Index(name="AcceptedAnswer", columns={"AcceptedAnswer"})})
 * @Entity
 */
class QAPost extends Proxy
{
    /**
     * @var integer
     *
     * @Id
     * @Column(name="ID", type="integer", nullable=false)
     * @GeneratedValue(strategy="NONE")
     */
    private $id;

    /**
     * @var string
     *
     * @Column(name="Description", type="string", length=64, nullable=false)
     */
    private $description;

    /**
     * @var integer
     *
     * @Column(name="AcceptedAnswer", type="integer", nullable=false)
     */
    private $acceptedanswer;

    /**
     * Constructor
     */
    public function __construct()
    {
        parent::__construct();
    }

    /*
	 * New() - kreira novi qapost
	 *	@param string $description: opis qaposta
	 *	@param integer $id: id posta
     *	@param integer $acceptedanswer: prihvacen odgovor
	 *	@return: Actor
	 */
	public static function New($description, $id, $acceptedanswer)
	{
		$instance = new Qapost();
		$instance->description = $description;
        $instance->id = $id;
        $instance->acceptedanswer = $acceptedanswer;
		return $instance;
	}

    /**
     * Set description
     *
     * @param string $description
     *
     * @return QAPost
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
     * Set id
     *
     * @param integer $id
     *
     * @return QAPost
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
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
     * Set acceptedanswer
     *
     * @param integer $acceptedanswer
     *
     * @return QAPost
     */
    public function setAcceptedanswer(\Reply $acceptedanswer = null)
    {
        $this->acceptedanswer = $acceptedanswer;

        return $this;
    }

    /**
     * Get acceptedanswer
     *
     * @return integer
     */
    public function getAcceptedanswer()
    {
        return $this->acceptedanswer;
    }

    /* ============== PROXY ============== */
	
	public function loadReferences()
	{
		if (parent::refsAreLoaded()) return;
		
		$this->acceptedanswer = $this->em->find('Reply', $this->acceptedanswer);
		
		parent::loadReferences();
	}
	
	public function unloadReferences()
	{
		if (!parent::refsAreLoaded()) return;
		
		$this->acceptedanswer = $this->acceptedanswer->getId();
		
		parent::unloadReferences();
	}
}

