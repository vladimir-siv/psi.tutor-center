<?php

/**
 * Section
 *
 * @Table(name="section", indexes={@Index(name="Subject", columns={"Subject"})})
 * @Entity
 */
class Section extends Proxy
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

