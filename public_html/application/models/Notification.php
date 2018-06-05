<?php

/**
 * Notification
 *
 * @Table(name="notification", indexes={@Index(name="Actor", columns={"Actor"})})
 * @Entity
 */
class Notification extends Proxy
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
     * @var boolean
     *
     * @Column(name="Seen", type="boolean", nullable=false)
     */
    private $seen = '0';

    /**
     * @var string
     *
     * @Column(name="Title", type="string", length=64, nullable=false)
     */
    private $title;

    /**
     * @var string
     *
     * @Column(name="Content", type="string", length=64, nullable=false)
     */
    private $content;

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
	 * New() - kreira novu notifikaciju
	 *	@param string $title: naslov notifikacije
     *	@param string $content: tekst notifikacije
     *	@param integer $actor: actor kome je namenjena notifikacija
	 *	@return: Notification
	 */
	public static function New($title, $content, $actor)
	{
		$instance = new Notification();
		$instance->seen = '0';
        $instance->title = $title;
        $instance->content = $content;
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
     * Set seen
     *
     * @param boolean $seen
     *
     * @return Notification
     */
    public function setSeen($seen)
    {
        $this->seen = $seen;

        return $this;
    }

    /**
     * Get seen
     *
     * @return boolean
     */
    public function getSeen()
    {
        return $this->seen;
    }

    /**
     * Set title
     *
     * @param string $title
     *
     * @return Notification
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
     * Set content
     *
     * @param string $content
     *
     * @return Notification
     */
    public function setContent($content)
    {
        $this->content = $content;

        return $this;
    }

    /**
     * Get content
     *
     * @return string
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * Set actor
     *
     * @param integer $actor
     *
     * @return Notification
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
		
		parent::loadReferences();
	}
	
	public function unloadReferences()
	{
		if (!parent::refsAreLoaded()) return;
		
		$this->actor = $this->actor->getId();
		
		parent::unloadReferences();
	}
}

