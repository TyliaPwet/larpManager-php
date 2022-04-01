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
    protected $categ;

    /**
     * @Column(type="text", nullable=true)
     */
    protected $geojson;
    
    /**
     * @Column(type="string",length=255, nullable=false)
     */
    protected $src;

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
     * Set the value of categ.
     *
     * @param string $categ
     * @return \LarpManager\Entities\GeoPicto
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
     * Set the value of src.
     *
     * @param string $src
     * @return \LarpManager\Entities\GeoPicto
     */
    public function setSrc($src)
    {
        $this->src = $src;

        return $this;
    }

    /**
     * Get the value of src.
     *
     * @return string
     */
    public function getSrc()
    {
        return $this->src;
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
        return array('id', 'categ', 'geojson', 'src', 'rotation');
    }
}
