<?php

/**
 * Notification
 *
 * @Table(name="notification", indexes={@Index(name="Actor", columns={"Actor"})})
 * @Entity
 */
class Notification
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
     * @param \Actor $actor
     *
     * @return Notification
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

