<?php



use Doctrine\ORM\Mapping as ORM;

/**
 * Actorreview
 *
 * @ORM\Table(name="actorreview", indexes={@ORM\Index(name="Reviewer", columns={"Reviewer"}), @ORM\Index(name="Reviewee", columns={"Reviewee"})})
 * @ORM\Entity
 */
class Actorreview
{
    /**
     * @var integer
     *
     * @ORM\Column(name="ID", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var integer
     *
     * @ORM\Column(name="Grade", type="integer", nullable=false)
     */
    private $grade;

    /**
     * @var string
     *
     * @ORM\Column(name="Description", type="string", length=64, nullable=false)
     */
    private $description;

    /**
     * @var \Actor
     *
     * @ORM\ManyToOne(targetEntity="Actor")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="Reviewer", referencedColumnName="ID")
     * })
     */
    private $reviewer;

    /**
     * @var \Actor
     *
     * @ORM\ManyToOne(targetEntity="Actor")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="Reviewee", referencedColumnName="ID")
     * })
     */
    private $reviewee;


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
     * @return Actorreview
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
     * @return Actorreview
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
     * @return Actorreview
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
     * @return Actorreview
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
}

