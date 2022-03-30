<?php

/**
 * Created by Tylia
 */

namespace LarpManager\Entities;

/**
 * LarpManager\Entities\GeoPicto
 *
 * @Entity()
 * @Table(name="geo_picto")
 * @InheritanceType("SINGLE_TABLE")
 * @DiscriminatorColumn(name="discr", type="string")
 * @DiscriminatorMap({"base":"BaseGeoPicto", "extended":"GeoPicto"})
 */
class BaseGeoPicto
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
    protected $type;

    /**
     * @Column(type="text", nullable=true)
     */
    protected $geojson;
    
    /**
     * @Column(type="string",length=255, nullable=false)
     */
    protected $url;

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
     * @return \LarpManager\Entities\GeoPicto
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
     * Set the value of type.
     *
     * @param string $type
     * @return \LarpManager\Entities\GeoPicto
     */
    public function setPictoType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get the value of type.
     *
     * @return string
     */
    public function getPictoType()
    {
        return $this->type;
    }

    /**
     * Set the value of geojson.
     *
     * @param string $geojson
     * @return \LarpManager\Entities\GeoPicto
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
     * Set the value of url.
     *
     * @param string $url
     * @return \LarpManager\Entities\GeoPicto
     */
    public function setUrl($url)
    {
        $this->url = $url;

        return $this;
    }

    /**
     * Get the value of url.
     *
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }
    
    /**
     * Set the value of rotation.
     *
     * @param integer $angle
     * @return \LarpManager\Entities\GeoPicto
     */
    public function setRotation($angle)
    {
        $this->rotation = $angle;

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

    
    public function __sleep()
    {
        return array('id', 'type', 'geojson', 'url', 'rotation');
    }
}
