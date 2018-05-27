<?php

/**
 * ActorReview
 *
 * @Table(name="actorreview", indexes={@Index(name="Reviewer", columns={"Reviewer"}), @Index(name="Reviewee", columns={"Reviewee"})})
 * @Entity
 */
class ActorReview extends Proxy
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
     * @var integer
     *
     * @Column(name="Grade", type="integer", nullable=false)
     */
    private $grade;

    /**
     * @var string
     *
     * @Column(name="Description", type="string", length=64, nullable=false)
     */
    private $description;

    /**
     * @var integer
     *
     * @Column(name="Reviewer", type="integer", nullable=false)
     */
    private $reviewer;

    /**
     * @var integer
     *
     * @Column(name="Reviewee", type="integer", nullable=false)
     */
    private $reviewee;

     public function __construct()
    {
        parent::__construct();
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
     * Set grade
     *
     * @param integer $grade
     *
     * @return ActorReview
     */
    public function setGrade($grade)
    {
        $this->grade = $grade;

        return $this;
    }

    /**
     * Get grade
     *
     * @return integer
     */
    public function getGrade()
    {
        return $this->grade;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return ActorReview
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
     * Set reviewer
     *
     * @param \Actor $reviewer
     *
     * @return ActorReview
     */
    public function setReviewer(\Actor $reviewer = null)
    {
        $this->reviewer = $reviewer;

        return $this;
    }

    /**
     * Get reviewer
     *
     * @return \Actor
     */
    public function getReviewer()
    {
        return $this->reviewer;
    }

    /**
     * Set reviewee
     *
     * @param \Actor $reviewee
     *
     * @return ActorReview
     */
    public function setReviewee(\Actor $reviewee = null)
    {
        $this->reviewee = $reviewee;

        return $this;
    }

    /**
     * Get reviewee
     *
     * @return \Actor
     */
    public function getReviewee()
    {
        return $this->reviewee;
    }
    
    /* ============== PROXY ============== */
	
	public function loadReferences()
	{
		if (parent::refsAreLoaded()) return;
		
		$this->reviewee = $this->em->find('Actor', $this->reviewee);
                $this->reviewer = $this->em->find('Actor', $this->reviewer);		
		parent::loadReferences();
	}
	public function unloadReferences()
	{
		if (!parent::refsAreLoaded()) return;
			
		$this->reviewee = $this->reviewee->getId();
                $this->reviewer = $this->reviewer->getId();
		parent::unloadReferences();
	}
    
}

