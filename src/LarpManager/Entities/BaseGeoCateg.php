<?php

/**
 * Created by Tylia
 */

namespace LarpManager\Entities;

use Doctrine\Common\Collections\ArrayCollection;

/**
 * LarpManager\Entities\GeoCateg
 *
 * @Entity()
 * @Table(name="geo_categ")
 * @InheritanceType("SINGLE_TABLE")
 * @DiscriminatorColumn(name="discr", type="string")
 * @DiscriminatorMap({"base":"BaseGeoCateg", "extended":"GeoCateg"})
 */
class BaseGeoCateg
{
    /**
     * @Id
     * @Column(type="integer")
     * @GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @Column(type="string", length=30)
     */
    protected $code;

	 /**
     * @ManyToOne(targetEntity="GeoGeomtype", inversedBy="categs")
     * @JoinColumn(name="geomtype_id", referencedColumnName="id", nullable=false)
     */
	protected $geomtype;
	
	/**
	  * @OneToMany(targetEntity="GeoLayer", mappedBy="categ")
	  */
	//protected $layers; 
	
	/**
     * @OneToMany(targetEntity="GeoObj", mappedBy="categ")
     */
     // protected $objets;

    public function __construct()
    {
		$this->layers = new ArrayCollection();
    }

    /**
     * Set the value of id.
     *
     * @param integer $id
     * @return \LarpManager\Entities\GeoCateg
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * Get the value of id.
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set the value of code.
     *
     * @param string $code
     * @return \LarpManager\Entities\GeoCateg
     */
    public function setCode($code)
    {
        $this->code = $code;
        return $this;
    }

    /**
     * Get the value of code.
     *
     * @return string
     */
    public function getCode()
    {
        return $this->code;
    }

	/**
     * Set the value of geomtype.
     *
     * @param \LarpManager\Entities\GeoGeomtype
     * @return \LarpManager\Entities\GeoCateg
     */
    public function setGeomtype(GeoGeomtype $geomtype)
    {
        $this->geomtype = $geomtype;
        return $this;
    }

   /**
     * Get the value of geomtype.
     *
     * @return string
     */
    public function getGeomtype()
    {
        return $this->geomtype;
    }
    
    /**
     * Add GeoLayer entity to collection (one to many).
     *
     * @param \LarpManager\Entities\GeoLayer $layer
     * @return \LarpManager\Entities\GeoCateg
     */
    public function addLayer(GeoLayer $layer)
    {
        $this->layers[] = $layer;

        return $this;
    }

    /**
     * Remove GeoLayer entity from collection (one to many).
     *
     * @param \LarpManager\Entities\GeoLayer $layer
     * @return \LarpManager\Entities\GeoCateg
     */
    public function removeLayer(GeoLayer $layer)
    {
        $this->layers->removeElement($layer);

        return $this;
    }
    
    /**
     * Get GeoLayer entity collection (one to many).
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getLayers()
    {
        return $this->layers;
    }

	/**
     * Add GeoObj entity to collection (one to many).
     *
     * @param \LarpManager\Entities\GeoObj $obj
     * @return \LarpManager\Entities\GeoCateg
     */
    public function addObjet(GeoObj $obj)
    {
        $this->objets[] = $obj;

        return $this;
    }

    /**
     * Remove GeoObj entity from collection (one to many).
     *
     * @param \LarpManager\Entities\GeoObj $obj
     * @return \LarpManager\Entities\GeoCateg
     */
    public function removeObjet(GeoObj $obj)
    {
        $this->objets->removeElement($obj);

        return $this;
    }
    
    /**
     * Get GeoObj entity collection (one to many).
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getObjets()
    {
        return $this->objets;
    }
    
    public function __sleep()
    {
        return array('id', 'code');
    }
}
