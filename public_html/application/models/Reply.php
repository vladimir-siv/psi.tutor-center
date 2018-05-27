<?php

/**
 * Reply
 *
 * @Table(name="reply", indexes={@Index(name="Post", columns={"Post"}), @Index(name="Actor", columns={"Actor"})})
 * @Entity
 */
class Reply extends Proxy
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
     * @Column(name="Message", type="string", length=64, nullable=false)
     */
    private $message;

    /**
     * @var \DateTime
     *
     * @Column(name="PostedOn", type="date", nullable=false)
     */
    private $postedon;

    /**
     * @var boolean
     *
     * @Column(name="Deleted", type="boolean", nullable=false)
     */
    private $deleted = '0';

    /**
     * @var integer
     *
     * @Column(name="Post", type="integer", nullable=false)
     */
    private $post;

    /**
     * @var integer
     *
     * @Column(name="Actor", type="integer", nullable=false)
     */
    private $actor;

    /**
     * Constructor
     */
    public function __construct()
    {
		parent::__construct();
    }

    /*
	 * New() - kreira novi reply
	 *	@param string $description: opis qaposta
	 *	@param integer $id: id posta
     *	@param integer $acceptedanswer: prihvacen odgovor
	 *	@return: Actor
	 */
	public static function New($message, $postedon, $deleted = 0, $post, $actor)
	{
		$instance = new Reply();
		$instance->message = $message;
        $instance->postedon = $postedon;
        $instance->deleted = $deleted;
        $instance->post = $post;
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
     * Set message
     *
     * @param string $message
     *
     * @return Reply
     */
    public function setMessage($message)
    {
        $this->message = $message;

        return $this;
    }

    /**
     * Get message
     *
     * @return string
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * Set postedon
     *
     * @param \DateTime $postedon
     *
     * @return Reply
     */
    public function setPostedon($postedon)
    {
        $this->postedon = $postedon;

        return $this;
    }

    /**
     * Get postedon
     *
     * @return \DateTime
     */
    public function getPostedon()
    {
        return $this->postedon;
    }

    /**
     * Set deleted
     *
     * @param boolean $deleted
     *
     * @return Reply
     */
    public function setDeleted($deleted)
    {
        $this->deleted = $deleted;

        return $this;
    }

    /**
     * Get deleted
     *
     * @return boolean
     */
    public function getDeleted()
    {
        return $this->deleted;
    }

    /**
     * Set post
     *
     * @param integer $post
     *
     * @return Reply
     */
    public function setPost($post = null)
    {
        $this->post = $post;

        return $this;
    }

    /**
     * Get post
     *
     * @return integer
     */
    public function getPost()
    {
        return $this->post;
    }

    /**
     * Set actor
     *
     * @param integer $actor
     *
     * @return Reply
     */
    public function setActor($actor = null)
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
        $this->post = $this->em->find('Post', $this->post);
        
		parent::loadReferences();
	}
	public function unloadReferences()
	{
		if (!parent::refsAreLoaded()) return;
		
		$this->actor = $this->actor->getId();
        $this->post = $this->post->getId();
        
		parent::unloadReferences();
	}
}

