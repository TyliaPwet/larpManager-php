<?php

/**
 * Created by Tylia
 */

namespace LarpManager\Entities;

/**
 * LarpManager\Entities\GeoLabel
 *
 * @Entity()
 * @Table(name="geo_label")
 * @InheritanceType("SINGLE_TABLE")
 * @DiscriminatorColumn(name="discr", type="string")
 * @DiscriminatorMap({"base":"BaseGeoLabel", "extended":"GeoLabel"})
 */
class BaseGeoLabel
{
    /**
     * @Id
     * @Column(type="integer")
     * @GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @Column(type="string",length=50, nullable=false)
     */
    protected $categ;

    /**
     * @Column(type="text", nullable=true)
     */
    protected $geojson;
    
    /**
     * @Column(type="string",length=45, nullable=false)
     */
    protected $texte;
    
	/**
     * @Column(type="integer")
     */
    protected $rotation;
    
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
     * @param string $categ
     * @return \LarpManager\Entities\GeoLabel
     */
    public function setCateg($categ)
    {
        $this->categ = $categ;

        return $this;
    }

    /**
     * Get the value of categ.
     *
     * @return string
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
     * Get the value of texte.
     *
     * @return string
     */
    public function getTexte()
    {
        return $this->texte;
    }
    
    /**
     * Set the value of texte.
     *
     * @param string $texte
     * @return \LarpManager\Entities\GeoLabel
     */
    public function setTexte($texte)
    {
        $this->texte = $texte;

        return $this;
    }
    
     /**
     * Get the value of rotation.
     *
     * @return integer
     */
    public function getRotation()
    {
        return $this->rotation;
    }
    
    /**
     * Set the value of rotation.
     *
     * @param integer $angle
     * @return \LarpManager\Entities\GeoLabel
     */
    public function setRotation($angle)
    {
        $this->rotation = $angle;

        return $this;
    }
    
    
    public function __sleep()
    {
        return array('id', 'categ', 'geojson', 'texte', 'rotation');
    }
}
