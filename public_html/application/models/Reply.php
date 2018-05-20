<?php

/**
 * Reply
 *
 * @Table(name="reply", indexes={@Index(name="Post", columns={"Post"}), @Index(name="Actor", columns={"Actor"})})
 * @Entity
 */
class Reply
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
     * @var \Post
     *
     * @ManyToOne(targetEntity="Post")
     * @JoinColumns({
     *   @JoinColumn(name="Post", referencedColumnName="ID")
     * })
     */
    private $post;

    /**
     * @var \Actor
     *
     * @ManyToOne(targetEntity="Actor")
     * @JoinColumns({
     *   @JoinColumn(name="Actor", referencedColumnName="ID")
     * })
     */
    private $actor;


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
     * @param \Post $post
     *
     * @return Reply
     */
    public function setPost(\Post $post = null)
    {
        $this->post = $post;

        return $this;
    }

    /**
     * Get post
     *
     * @return \Post
     */
    public function getPost()
    {
        return $this->post;
    }

    /**
     * Set actor
     *
     * @param \Actor $actor
     *
     * @return Reply
     */
    public function setActor(\Actor $actor = null)
    {
        $this->actor = $actor;

        return $this;
    }

    /**
     * Get actor
     *
     * @return \Actor
     */
    public function getActor()
    {
        return $this->actor;
    }
}

