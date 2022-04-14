<?php

/**
 * Created by Tylia
 */

namespace LarpManager\Entities;

/**
 * LarpManager\Entities\GeoSurf
 *
 * @Entity()
 * @Table(name="geo_surf")
 * @InheritanceType("SINGLE_TABLE")
 * @DiscriminatorColumn(name="discr", type="string")
 * @DiscriminatorMap({"base":"BaseGeoSurf", "extended":"GeoSurf"})
 */
class BaseGeoSurf
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
        
    public function __construct()
    {
    }

    /**
     * Set the value of id.
     *
     * @param integer $id
     * @return \LarpManager\Entities\GeoSurf
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
     * @return \LarpManager\Entities\GeoSurf
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
     * @return \LarpManager\Entities\GeoSurf
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
       
    
    public function __sleep()
    {
        return array('id', 'categ', 'geojson';
    }
}
