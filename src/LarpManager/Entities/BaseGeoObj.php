<?php

/**
 * Created by Tylia
 */

namespace LarpManager\Entities;

/**
 * LarpManager\Entities\GeoObj
 *
 * @Entity()
 * @Table(name="geo_obj")
 * @InheritanceType("SINGLE_TABLE")
 * @DiscriminatorColumn(name="discr", type="string")
 * @DiscriminatorMap({"base":"BaseGeoObj", "extended":"GeoObj"})
 */
class BaseGeoObj
{
    /**
     * @Id
     * @Column(type="integer")
     * @GeneratedValue(strategy="AUTO")
     */
    protected $id;

   /**
     * @Column(type="text", nullable=true)
     */
    protected $geojson;
    
    /**
     * @Column(type="text", nullable=true)
     */
    protected $propertiesjson;
    
	/**
     * @ManyToOne(targetEntity="GeoCateg", inversedBy="objets")
     * @JoinColumn(name="categ_id", referencedColumnName="id", nullable=false)
     */
     protected $categ;
    
    public function __construct()
    {
    }

    /**
     * Set the value of id.
     *
     * @param integer $id
     * @return \LarpManager\Entities\GeoLabel
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
     * Set the value of categ.
     *
     * @param \LarpManager\Entities\GeoCateg
     * @return \LarpManager\Entities\GeoObj
     */
    public function setCateg($categ)
    {
        $this->categ = $categ;

        return $this;
    }

    /**
     * Get the value of categ.
     *
     * @return \LarpManager\Entities\GeoCateg
     */
    public function getCateg()
    {
        return $this->categ;
    }

    /**
     * Set the value of geojson.
     *
     * @param string $geojson
     * @return \LarpManager\Entities\GeoLabel
     */
    public function setGeojson($geojson)
    {
        $this->geojson = $geojson;

        return $this;
    }
    
    /**
     * Get the value of geojson.
     *
     * @return string
     */
    public function getGeojson()
    {
        return $this->geojson;
    }
    
    /**
     * Get the value of propertiesjson.
     *
     * @return string
     */
    public function getPropertiesjson()
    {
        return $this->propertiesjson;
    }
    
    /**
     * Set the value of propertiesjson.
     *
     * @param string $texte
     * @return \LarpManager\Entities\GeoObj
     */
    public function setPropertiesjson($texte)
    {
        $this->propertiesjson = $texte;

        return $this;
    }
       
    public function __sleep()
    {
        return array('id', 'geojson', 'propertiesjson');
    }
}
