<?php

/**
 * Created by Tylia
 */

namespace LarpManager\Entities;

use Doctrine\Common\Collections\ArrayCollection;

/**
 * LarpManager\Entities\GeoGeomtype
 *
 * @Entity()
 * @Table(name="geo_geomtype")
 * @InheritanceType("SINGLE_TABLE")
 * @DiscriminatorColumn(name="discr", type="string")
 * @DiscriminatorMap({"base":"BaseGeoGeomtype", "extended":"GeoGeomtype"})
 */
class BaseGeoGeomtype
{
    /**
     * @Id
     * @Column(type="integer")
     * @GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @Column(type="string", length=20)
     */
    protected $code;
    
     /**
     * @OneToMany(targetEntity="GeoCateg", mappedBy="geomtype")
     */
	protected $categs;
    
    /**
     * @Column(type="boolean")
     */
     protected $gtranslate;

    /**
     * @Column(type="boolean")
     */
     protected $gmodify;
     
     /**
     * @Column(type="boolean")
     */
     protected $territoiremodify;

    /**
     * @Column(type="boolean")
     */
     protected $propertiesmodify;
      
    public function __construct()
    {
    	$this->categs = new ArrayCollection();
    }

    /**
     * Set the value of id.
     *
     * @param integer $id
     * @return \LarpManager\Entities\GeoMap
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
     * @return \LarpManager\Entities\GeoGeomtype
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
     * Add GeoCateg entity to collection (one to many).
     *
     * @param \LarpManager\Entities\GeoCateg $categ
     * @return \LarpManager\Entities\GeoGeomtype
     */
    public function addCateg(GeoCateg $categ)
    {
        $this->categs[] = $categ;

        return $this;
    }

    /**
     * Remove GeoCateg entity from collection (one to many).
     *
     * @param \LarpManager\Entities\GeoCateg $categ
     * @return \LarpManager\Entities\GeoGeomtype
     */
    public function removeCateg(GeoCateg $categ)
    {
        $this->categs->removeElement($categ);

        return $this;
    }
    
    /**
     * Get Categs entity collection (one to many).
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getCategs()
    {
        return $this->categs;
    } 
   
   /**
     * Set the value of gtranslate.
     *
     * @param boolean $b
     * @return \LarpManager\Entities\GeoGeomtype
     */
    public function setGtranslate($b)
    {
        $this->gtranslate = $b;
        return $this;
    }

    /**
     * Get the value of gtranslate.
     *
     * @return boolean
     */
    public function getGtranslate()
    {
        return $this->gtranslate;
    }
    
    /**
     * Set the value of gmodify.
     *
     * @param boolean $b
     * @return \LarpManager\Entities\GeoGeomtype
     */
    public function setGmodify($b)
    {
        $this->gmodify = $b;
        return $this;
    }

    /**
     * Get the value of gmodify.
     *
     * @return boolean
     */
    public function getGmodify()
    {
        return $this->gmodify;
    }
	    
	/**
     * Set the value of territoiremodify.
     *
     * @param boolean $b
     * @return \LarpManager\Entities\GeoGeomtype
     */
    public function setTerritoiremodify($b)
    {
        $this->territoiremodify = $b;
        return $this;
    }

    /**
     * Get the value of territoiremodify.
     *
     * @return boolean
     */
    public function getTerritoiremodify()
    {
        return $this->territoiremodify;
    }
    
    /**
     * Set the value of propertiesmodify.
     *
     * @param boolean $b
     * @return \LarpManager\Entities\GeoGeomtype
     */
    public function setPropertiesmodify($b)
    {
        $this->propertiesmodify = $b;
        return $this;
    }

    /**
     * Get the value of propertiesmodify.
     *
     * @return boolean
     */
    public function getPropertiesmodify()
    {
        return $this->propertiesmodify;
    }
    
    public function __sleep()
    {
        return array('id', 'code');
    }
}
