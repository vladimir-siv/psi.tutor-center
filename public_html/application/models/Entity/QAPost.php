<?php



use Doctrine\ORM\Mapping as ORM;

/**
 * QAPost
 *
 * @ORM\Table(name="qapost", indexes={@ORM\Index(name="AcceptedAnswer", columns={"AcceptedAnswer"})})
 * @ORM\Entity
 */
class QAPost
{
    /**
     * @var string
     *
     * @ORM\Column(name="Description", type="string", length=64, nullable=false)
     */
    private $description;

    /**
     * @var \Post
     *
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     * @ORM\OneToOne(targetEntity="Post")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="ID", referencedColumnName="ID")
     * })
     */
    private $id;

    /**
     * @var \Reply
     *
     * @ORM\ManyToOne(targetEntity="Reply")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="AcceptedAnswer", referencedColumnName="ID")
     * })
     */
    private $acceptedanswer;


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
     * @param \Post $id
     *
     * @return QAPost
     */
    public function setId(\Post $id)
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
     * Set acceptedanswer
     *
     * @param \Reply $acceptedanswer
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
     * @return \Reply
     */
    public function getAcceptedanswer()
    {
        return $this->acceptedanswer;
    }
}

