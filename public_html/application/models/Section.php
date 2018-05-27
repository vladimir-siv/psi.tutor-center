<?php

/**
 * Section
 *
 * @Table(name="section", indexes={@Index(name="Subject", columns={"Subject"})})
 * @Entity
 */
class Section extends Proxy
{
	/* ================= STATIC ================= */
	
	/*
	 * findByName() - dohvata sve oblasti po nazivu
	 *	@param string $name: naziv oblasti
	 *	@return: \Doctrine\Common\Collections\Collection
	 */
	public static function findByName($name)
	{
		return parent::$_em->getRepository(Section::class)->findBy(array
		(
			'name' => $name
		));
	}
	
	/*
	 * searchSubjectSection() - trazi oblasti po nazivu (contains) koje pripadaju kategoriji po nazivu (contains)
	 *	@param string $subject: naziv kategorije (contains)
	 *	@param string $section:	naziv oblasti (contains)
	 *	@param string $format: specificni formati rezultata
	 *	@return: JSON string
	 */
	public static function searchSubjectSection($subject, $section, $format = null)
	{
		$sections = self::$_em->createQuery('SELECT sc FROM Section sc WHERE sc.subject in (SELECT sb.id FROM Subject sb WHERE sb.name LIKE :subject) AND sc.name LIKE :section')
						->setParameter('subject', '%'.$subject.'%')
						->setParameter('section', '%'.$section.'%')
						->getResult();
		
		$json = array();
		
		foreach ($sections as $section)
		{
			$json[] = array('id' => $section->getId(), 'section' => $section->getName());
		}
		
		return json_encode($json);
	}
	
	/* ================ INSTANCE ================ */
	
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
     * @Column(name="Name", type="string", length=64, nullable=false)
     */
    private $name;
	
    /**
     * @var string
     *
     * @Column(name="Description", type="string", length=64, nullable=true)
     */
    private $description;
	
    /**
     * @var boolean
     *
     * @Column(name="Deleted", type="boolean", nullable=false)
     */
    private $deleted = '0';
	
    /**
     * @var integer
     *
     * @Column(name="Subject", type="integer", nullable=false)
     */
    private $subject;
	
    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ManyToMany(targetEntity="Post", mappedBy="section")
     */
    private $post;
	
    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ManyToMany(targetEntity="Actor", mappedBy="section")
     */
    private $actor;
	
    /**
     * Constructor
     */
    public function __construct()
    {
        parent::__construct();
        $this->post = new \Doctrine\Common\Collections\ArrayCollection();
        $this->actor = new \Doctrine\Common\Collections\ArrayCollection();
    }
	
	/*
	 * New() - kreira novu oblast
	 *	@param string $name: naziv oblasti
	 *	@param string $description: opis oblasti
	 *	@param integer $subject: kategorija kojoj pripada
	 *	@param string $deleted: da li je oblast logicki obrisana
	 *	@return: Section
	 */
    public static function New($name, $description, $subject, $deleted = 0)
    {
        $instance = new Section();
        $instance->name = $name;
        $instance->description = $description;
        $instance->subject = $subject;
        $instance->deleted = $deleted;
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
     * Set name
     *
     * @param string $name
     *
     * @return Section
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
     * Set description
     *
     * @param string $description
     *
     * @return Section
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
     * Set deleted
     *
     * @param boolean $deleted
     *
     * @return Section
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
     * Set subject
     *
     * @param \Subject $subject
     *
     * @return Section
     */
    public function setSubject(\Subject $subject = null)
    {
        $this->subject = $subject;

        return $this;
    }
	
    /**
     * Get subject
     *
     * @return \Subject
     */
    public function getSubject()
    {
        return $this->subject;
    }
	
    /**
     * Add post
     *
     * @param \Post $post
     *
     * @return Section
     */
    public function addPost(\Post $post)
    {
        $this->post[] = $post;

        return $this;
    }
	
    /**
     * Remove post
     *
     * @param \Post $post
     */
    public function removePost(\Post $post)
    {
        $this->post->removeElement($post);
    }
	
    /**
     * Get post
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getPost()
    {
        return $this->post;
    }
	
    /**
     * Add actor
     *
     * @param \Actor $actor
     *
     * @return Section
     */
    public function addActor(\Actor $actor)
    {
        $this->actor[] = $actor;

        return $this;
    }
	
    /**
     * Remove actor
     *
     * @param \Actor $actor
     */
    public function removeActor(\Actor $actor)
    {
        $this->actor->removeElement($actor);
    }
	
    /**
     * Get actor
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getActor()
    {
        return $this->actor;
    }
	
    /**
     * Get subscribers
     *
     * @return \Doctrine\Common\Collections\Collection
     */
	public function getSubscribers()
	{
		$subscribers = parent::$_em->createQuery('SELECT a FROM Actor a WHERE a.id in (SELECT s.actor FROM SectionSubscription s WHERE s.section = :section)')
						->setParameter('section', $this->id)
						->getResult();
		return $subscribers;
	}
    
    /* ============== PROXY ============== */
	
    public function loadReferences()
    {
		if (parent::refsAreLoaded()) return;
		
		$this->subject = $this->em->find('Subject', $this->subject);
		
		parent::loadReferences();
    }
	
    public function unloadReferences()
    {
		if (!parent::refsAreLoaded()) return;
		
		$this->subject= $this->subject->getId();
		
		parent::unloadReferences();
    }
}
