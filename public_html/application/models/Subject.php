<?php

/**
 * Subject
 *
 * @Table(name="subject")
 * @Entity
 */
class Subject extends Proxy
{
	/* ================= STATIC ================= */
	
	/*
	 * getAll() - dohvata sve Subject-e
	 *	@param bool $withDeleted: indikator da li u rezultatu treba ukljuciti obrisane
	 *	@return: \Doctrine\Common\Collections\Collection
	 */
	public static function getAll($withDeleted = false)
	{
		return parent::$_em->createQuery('SELECT s FROM Subject s WHERE s.deleted = :deleted')
							->setParameter('deleted', $withDeleted)
							->getResult();
	}
	
	/*
	 * getAllSections() - dohvata sve Section-e za zadati Subject sa subjectid
	 *	@param int $subjectid: id kategorije
	 *	@param bool $withDeleted: indikator da li u rezultatu treba ukljuciti obrisane
	 *	@return: \Doctrine\Common\Collections\Collection
	 */
	public static function getAllSections($subjectid, $withDeleted = false)
	{
		return parent::$_em->createQuery('SELECT s FROM Section s WHERE s.subject = :id AND s.deleted = :deleted')
							->setParameter('id', $subjectid)
							->setParameter('deleted', $withDeleted)
							->getResult();
	}
	
	/*
	 * findByName() - dohvata sve kategorije po nazivu
	 *	@param string $name: naziv kategorije
	 *	@return: \Doctrine\Common\Collections\Collection
	 */
	public static function findByName($name)
	{
		return parent::$_em->getRepository(Subject::class)->findBy(array
		(
			'name' => $name
		));
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
     * Constructor
     */
    public function __construct()
    {
        parent::__construct();
    }

	/*
	 * New() - kreira novu kategoriju
	 *	@param string $name: naziv kategorije
	 *	@param string $description: opis kategorije
	 *	@param string $deleted: da li je kategorija logicki obrisana
	 *	@return: Subject
	 */
    public static function New($name, $description, $deleted = 0)
    {
        $instance = new Subject();
        $instance->name = $name;
        $instance->description = $description;
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
     * @return Subject
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
     * @return Subject
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
     * @return Subject
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
}

