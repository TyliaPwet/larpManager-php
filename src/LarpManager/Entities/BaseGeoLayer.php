<?php

/**
 * Created by Tylia
 */

namespace LarpManager\Entities;

/**
 * LarpManager\Entities\GeoLayer
 *
 * @Entity()
 * @Table(name="geo_layer")
 * @InheritanceType("SINGLE_TABLE")
 * @DiscriminatorColumn(name="discr", type="string")
 * @DiscriminatorMap({"base":"BaseGeoLayer", "extended":"GeoLayer"})
 */
class BaseGeoLayer
{
    /**
     * @Id
     * @Column(type="integer")
     * @GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @Column(type="integer")
     */
    protected $zmin;

    /**
     * @Column(type="integer")
     */
    protected $zmax;

    /**
     * @Column(type="integer")
     */
    protected $ordre;
    
    /**
     * @Column(type="text")
     */
     protected $stylejson;
     
    /**
     * @ManyToOne(targetEntity="GeoMap", inversedBy="layers")
     * @JoinColumn(name="map_id", referencedColumnName="id", nullable=false)
     */
    protected $map;

    /**
     * @ManyToOne(targetEntity="GeoCateg", inversedBy="layers")
     * @JoinColumnn(name="categ_id", referencedColumName="id", nullable=false)
     */
     protected $categ;

    public function __construct()
    {
    }

    /**
     * Set the value of id.
     *
     * @param integer $id
     * @return \LarpManager\Entities\GeoLayer
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
     * Set the value of zmin.
     *
     * @param string $zmin
     * @return \LarpManager\Entities\GeoLayer
     */
    public function setZmin($zmin)
    {
        $this->zmin = $zmin;
        return $this;
    }

    /**
     * Get the value of zmin.
     *
     * @return integer
     */
    public function getZmin()
    {
        return $this->zmin;
    }

    /**
     * Set the value of zmax.
     *
     * @param string $zmax
     * @return \LarpManager\Entities\GeoLayer
     */
    public function setZmax($zmax)
    {
        $this->zmax = $zmax;
        return $this;
    }

    /**
     * Get the value of zmax.
     *
     * @return integer
     */
    public function getZmax()
    {
        return $this->zmax;
    }

    /**
     * Set the value of ordre.
     *
     * @param string $ordre
     * @return \LarpManager\Entities\GeoLayer
     */
    public function setOrdre($ordre)
    {
        $this->ordre = $ordre;
        return $this;
    }

    /**
     * Get the value of ordre.
     *
     * @return integer
     */
    public function getOrdre()
    {
        return $this->ordre;
    }
    
    /**
     * Set the value of stylejson.
     *
     * @param string $stylejson
     * @return \LarpManager\Entities\GeoLayer
     */
    public function setStylejson($style)
    {
        $this->stylejson = $style;
        return $this;
    }

    /**
     * Get the value of stylejson.
     *
     * @return string
     */
    public function getStylejson()
    {
        return $this->stylejson;
    }
   
   /**
     * Set the value of categ.
     *
     * @param \LarpManager\Entities\GeoCateg
     * @return \LarpManager\Entities\GeoLayer
     */
    public function setCateg(GeoCateg $categ)
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
     * Set the value of map.
     *
     * @param \LarpManager\Entities\GeoMap
     * @return \LarpManager\Entities\GeoLayer
     */
    public function setMap(GeoMap $map)
    {
        $this->map = $map;
        return $this;
    }

   /**
     * Get the value of map.
     *
     * @return \LarpManager\Entities\GeoMap
     */
    public function getMap()
    {
        return $this->map;
    }
 
    
    public function __sleep()
    {
        return array('id', 'zmin', 'zmax', 'ordre', 'stylejson');
    }
}
