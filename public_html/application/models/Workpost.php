<?php

/**
 * WorkPost
 *
 * @Table(name="workpost", indexes={@Index(name="Worker", columns={"Worker"})})
 * @Entity
 */
class WorkPost extends Proxy
{
    /**
     * @var string
     *
     * @Column(name="Description", type="string", length=64, nullable=false)
     */
    private $description;

    /**
     * @var string
     *
     * @Column(name="ComittedTokens", type="decimal", precision=10, scale=0, nullable=true)
     */
    private $comittedtokens;

    /**
     * @var boolean
     *
     * @Column(name="WorkerAccepted", type="boolean", nullable=false)
     */
    private $workeraccepted = '0';

    /**
     * @var integer
     *
     * @Id
     * @Column(name="ID", type="integer", nullable=false)
     * @GeneratedValue(strategy="NONE")
     */
    private $id;

    /**
     * @var integer
     *
     * @Column(name="Worker", type="integer", nullable=false)
     */
    private $worker;

    /**
     * Constructor
     */
    public function __construct()
    {
        parent::__construct();
    }

    /*
	 * New() - kreira novi qapost
	 *	@param string $description: opis workposta
     *	@param integer $comittedtokens: kolicina tokena koju korisnik placa workeru
     *	@param bool $workeraccepted: da li je worker prihvatio da radi na workpostu
	 *	@param integer $id: id posta
     *	@param integer $worker: id workera koji dobija tokene na kraju uradjenog workposta
	 *	@return: Actor
	 */
	public static function New($description, $comittedtokens, $workeraccepted, $id, $worker)
	{
		$instance = new Workpost();
		$instance->description = $description;
        $instance->comittedtokens = $comittedtokens;
        $instance->workeraccepted = $workeraccepted;
        $instance->id = $id;
        $instance->worker = $worker;
		return $instance;
    }
    
    /*
	 * getDescriptionForPost($post) - dohvata description za dati post
	 *	@param \Post $post: post
	 *	@return: string
	 */
    public static function getDescriptionForPost($post)
	{
		$workpost = parent::$_em->createQuery('SELECT w from Workpost w WHERE w.id = :postid')
					->setParameter('postid', $post->getId())
					->getSingleResult();
		
		return $workpost->getDescription();
    }

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
     * @param integer $id
     *
     * @return WorkPost
     */
    public function setId($id)
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
     * @param integer $worker
     *
     * @return WorkPost
     */
    public function setWorker($worker = null)
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

