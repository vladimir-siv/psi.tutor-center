<?php

/**
 * QAPost
 *
 * @Table(name="qapost", indexes={@Index(name="AcceptedAnswer", columns={"AcceptedAnswer"})})
 * @Entity
 */
class QAPost
{
    /**
     * @var string
     *
     * @Column(name="Description", type="string", length=64, nullable=false)
     */
    private $description;

    /**
     * @var \Post
     *
     * @Id
     * @GeneratedValue(strategy="NONE")
     * @OneToOne(targetEntity="Post")
     * @JoinColumns({
     *   @JoinColumn(name="ID", referencedColumnName="ID")
     * })
     */
    private $id;

    /**
     * @var \Reply
     *
     * @ManyToOne(targetEntity="Reply")
     * @JoinColumns({
     *   @JoinColumn(name="AcceptedAnswer", referencedColumnName="ID")
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

