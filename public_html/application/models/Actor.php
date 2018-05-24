<?php

@require_once(APPPATH.'models/Proxy.php');

/**
 * Actor
 *
 * @Table(name="actor", uniqueConstraints={@UniqueConstraint(name="Email", columns={"Email"}), @UniqueConstraint(name="Username", columns={"Username"})}, indexes={@Index(name="ActorRank", columns={"ActorRank"})})
 * @Entity
 */
class Actor extends Proxy
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
     * @Column(name="FirstName", type="string", length=64, nullable=false)
     */
    private $firstname;

    /**
     * @var string
     *
     * @Column(name="LastName", type="string", length=64, nullable=false)
     */
    private $lastname;

    /**
     * @var string
     *
     * @Column(name="Email", type="string", length=64, nullable=false)
     */
    private $email;

    /**
     * @var string
     *
     * @Column(name="Username", type="string", length=64, nullable=false)
     */
    private $username;

    /**
     * @var string
     *
     * @Column(name="Password", type="string", length=64, nullable=false)
     */
    private $password;

    /**
     * @var \DateTime
     *
     * @Column(name="BirthDate", type="date", nullable=false)
     */
    private $birthdate;

    /**
     * @var string
     *
     * @Column(name="Tokens", type="decimal", precision=10, scale=0, nullable=false)
     */
    private $tokens = '0';

    /**
     * @var boolean
     *
     * @Column(name="Banned", type="boolean", nullable=false)
     */
    private $banned = '0';

    /**
     * @var integer
     *
     * @Column(name="ActorRank", type="integer", nullable=false)
     */
    private $actorrank;
	
    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ManyToMany(targetEntity="Section", inversedBy="actor")
     * @JoinTable(name="sectionsubscriptions",
     *   joinColumns={
     *     @JoinColumn(name="Actor", referencedColumnName="ID")
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
	
	/*
	 * New() - kreira novog korisnika
	 *	@param string $firstname: ime korisnika
	 *	@param string $lastname: prezime korisnika
	 *	@param string $email: e-posta korisnika
	 *	@param string $username: korisnicko ime korisnika
	 *	@param string $password: lozinka korisnika
	 *	@param DateTime $birthdate: datum rodjenja korisnika
	 *	@param ActorRank $actorrank: rank
	 *	@param int $tokens: inicijalno stanje korisnika
	 *	@param bool $banned: inicijalno banovano stanje
	 *	@return: Actor
	 */
	public static function New($firstname, $lastname, $email, $username, $password, $birthdate, $actorrank, $tokens = 0, $banned = false)
	{
		$instance = new Actor();
		$instance->firstname = $firstname;
		$instance->lastname = $lastname;
		$instance->email = $email;
		$instance->username = $username;
		$instance->password = MD5($password);
		$instance->birthdate = $birthdate;
		$instance->tokens = $tokens;
		$instance->banned = $banned;
		$instance->actorrank = $actorrank;
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
     * Set firstname
     *
     * @param string $firstname
     *
     * @return Actor
     */
    public function setFirstname($firstname)
    {
        $this->firstname = $firstname;

        return $this;
    }

    /**
     * Get firstname
     *
     * @return string
     */
    public function getFirstname()
    {
        return $this->firstname;
    }

    /**
     * Set lastname
     *
     * @param string $lastname
     *
     * @return Actor
     */
    public function setLastname($lastname)
    {
        $this->lastname = $lastname;

        return $this;
    }

    /**
     * Get lastname
     *
     * @return string
     */
    public function getLastname()
    {
        return $this->lastname;
    }

    /**
     * Set email
     *
     * @param string $email
     *
     * @return Actor
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set username
     *
     * @param string $username
     *
     * @return Actor
     */
    public function setUsername($username)
    {
        $this->username = $username;

        return $this;
    }

    /**
     * Get username
     *
     * @return string
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * Set password
     *
     * @param string $password
     *
     * @return Actor
     */
    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Get password
     *
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Set birthdate
     *
     * @param \DateTime $birthdate
     *
     * @return Actor
     */
    public function setBirthdate($birthdate)
    {
        $this->birthdate = $birthdate;

        return $this;
    }

    /**
     * Get birthdate
     *
     * @return \DateTime
     */
    public function getBirthdate()
    {
        return $this->birthdate;
    }

    /**
     * Set tokens
     *
     * @param string $tokens
     *
     * @return Actor
     */
    public function setTokens($tokens)
    {
        $this->tokens = $tokens;

        return $this;
    }

    /**
     * Get tokens
     *
     * @return string
     */
    public function getTokens()
    {
        return $this->tokens;
    }

    /**
     * Set banned
     *
     * @param boolean $banned
     *
     * @return Actor
     */
    public function setBanned($banned)
    {
        $this->banned = $banned;

        return $this;
    }

    /**
     * Get banned
     *
     * @return boolean
     */
    public function getBanned()
    {
        return $this->banned;
    }

    /**
     * Set actorrank
     *
     * @param integer $actorrank
     *
     * @return Actor
     */
    public function setActorRank($actorrank = null)
    {
        $this->actorrank = $actorrank;
		
        return $this;
    }

    /**
     * Get actorrank
     *
     * @return integer
     */
    public function getActorRank()
    {
        return $this->actorrank;
    }

    /**
     * Add section
     *
     * @param \Section $section
     *
     * @return Actor
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
	
	/* ============== PROXY ============== */
	
	private $actorrank_ref = null;
	
	public function getActorRankRef()
	{
		if ($this->actorrank_ref === null)
		{
			$this->actorrank_ref = $this->em->find('ActorRank', $this->actorrank);
			$this->actorrank_ref->setEntityManager($this->em);
		}
		
		return $this->actorrank_ref;
	}
}