<?php

/**
 * Post
 *
 * @Table(name="post", indexes={@Index(name="OriginalPoster", columns={"OriginalPoster"})})
 * @Entity
 */
class Post extends Proxy
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
     * @var \DateTime
     *
     * @Column(name="PostedOn", type="date", nullable=false)
     */
    private $postedon;

    /**
     * @var boolean
     *
     * @Column(name="Active", type="boolean", nullable=false)
     */
    private $active = '1';

    /**
     * @var boolean
     *
     * @Column(name="Deleted", type="boolean", nullable=false)
     */
    private $deleted = '0';

    /**
     * @var integer
     *
     * @Column(name="OriginalPoster", type="integer", nullable=false)
     */
    private $originalposter;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ManyToMany(targetEntity="Section", inversedBy="post")
     * @JoinTable(name="postsections",
     *   joinColumns={
     *     @JoinColumn(name="Post", referencedColumnName="ID")
     *   },
     *   inverseJoinColumns={
     *     @JoinColumn(name="Section", referencedColumnName="ID")
     *   }
     * )
     */
    private $section;

    /**
     * Constructor
     */
    public function __construct()
    {
        parent::__construct();
        $this->section = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /*
	 * New() - kreira novi post
	 *	@param string $title: naslov posta
	 *	@param \Datetime $postedon: vreme postavljanja
	 *	@param integer $originalposter: osoba koja je postavila post
     *	@param bool $active: inicijalno aktivno stanje
     *	@param bool $deleted: inicijalno obrisano stanje
	 *	@return: Actor
	 */
	public static function New($title, $postedon, $originalposter, $active = '1', $deleted = '0')
	{
		$instance = new Post();
		$instance->title = $title;
        $instance->postedon = $postedon;
        $instance->active = $active;
        $instance->deleted = $deleted;
        $instance->originalposter = $originalposter;
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
     * @return Post
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
     * Set postedon
     *
     * @param \DateTime $postedon
     *
     * @return Post
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
     * Set active
     *
     * @param boolean $active
     *
     * @return Post
     */
    public function setActive($active)
    {
        $this->active = $active;

        return $this;
    }

    /**
     * Get active
     *
     * @return boolean
     */
    public function getActive()
    {
        return $this->active;
    }

    /**
     * Set deleted
     *
     * @param boolean $deleted
     *
     * @return Post
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
     * Set originalposter
     *
     * @param integer $originalposter
     *
     * @return Post
     */
    public function setOriginalposter($originalposter = null)
    {
        $this->originalposter = $originalposter;

        return $this;
    }

    /**
     * Get originalposter
     *
     * @return integer
     */
    public function getOriginalposter()
    {
        return $this->originalposter;
    }

    /**
     * Add section
     *
     * @param \Section $section
     *
     * @return Post
     */
    public function addSection(\Section $section)
    {
        $this->section[] = $section;

        return $this;
    }

    /**
     * Remove section
     *
     * @param \Section $section
     */
    public function removeSection(\Section $section)
    {
        $this->section->removeElement($section);
    }

    /**
     * Get section
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getSection()
    {
        return $this->section;
    }
	
    /*
	 * getOriginalPosterId() - dohvata id op-a za dati post
	 *	@return: \Actor
	 */
    public function getOriginalPosterId()
	{
        if (parent::refsAreLoaded()) return $this->originalposter->getId();
		else return $this->originalposter->getId();
    }
    
    /*
	 * getOriginalPosterReference() - dohvata op za dati post
	 *	@return: \Actor
	 */
    public function getOriginalPosterReference()
	{
        if (parent::refsAreLoaded()) return $this->originalposter;
		else return parent::$_em->find('Actor', $this->originalposter);
    }
	
    /*
	 * getWorkpost() - dohvata referencu na workpost
	 *	@return: \Workpost
	 */
	public function getWorkpost()
	{
		return parent::$_em->find('Workpost', $this->id);
	}
    
	/* ============== PROXY ============== */
	
	public function loadReferences()
	{
		if (parent::refsAreLoaded()) return;
		
		$this->originalposter = $this->em->find('Post', $this->originalposter);
		
		parent::loadReferences();
	}
	public function unloadReferences()
	{
		if (!parent::refsAreLoaded()) return;
		
		$this->originalposter = $this->originalposter->getId();
		
		parent::unloadReferences();
	}
}

