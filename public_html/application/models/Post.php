<?php

/**
 * Post
 *
 * @Table(name="post", indexes={@Index(name="OriginalPoster", columns={"OriginalPoster"})})
 * @Entity
 */
class Post
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
     * @var \Actor
     *
     * @ManyToOne(targetEntity="Actor")
     * @JoinColumns({
     *   @JoinColumn(name="OriginalPoster", referencedColumnName="ID")
     * })
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
        $this->section = new \Doctrine\Common\Collections\ArrayCollection();
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
     * @param \Actor $originalposter
     *
     * @return Post
     */
    public function setOriginalposter(\Actor $originalposter = null)
    {
        $this->originalposter = $originalposter;

        return $this;
    }

    /**
     * Get originalposter
     *
     * @return \Actor
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
}

