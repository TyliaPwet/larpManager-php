<?php

/**
 * Created by Tylia
 */

namespace LarpManager\Entities;

use Doctrine\Common\Collections\ArrayCollection;

/**
 * LarpManager\Entities\GeoMap
 *
 * @Entity()
 * @Table(name="geo_map")
 * @InheritanceType("SINGLE_TABLE")
 * @DiscriminatorColumn(name="discr", type="string")
 * @DiscriminatorMap({"base":"BaseGeoMap", "extended":"GeoMap"})
 */
class BaseGeoMap
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
     * @Column(type="string", length=50)
     */
    protected $nom;

	/**
     * @Column(type="string", length=450)
     */
    protected $description;
    
    /**
     * @Column(type="integer")
     */
    protected $zmin;

    /**
     * @Column(type="integer")
     */
    protected $zmax;
    
    /**
     * @OneToMany(targetEntity="GeoLayer", mappedBy="map")
     * @OrderBy({"ordre" = "ASC"})
     */
	protected $layers;


    public function __construct()
    {
    	$this->layers = new ArrayCollection();
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
     * @return \LarpManager\Entities\GeoMap
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
     * Set the value of nom.
     *
     * @param string $nom
     * @return \LarpManager\Entities\GeoMap
     */
    public function setNom($nom)
    {
        $this->nom = $nom;
        return $this;
    }

    /**
     * Get the value of nom.
     *
     * @return string
     */
    public function getNom()
    {
        return $this->nom;
    }

	/**
     * Set the value of description.
     *
     * @param string $desc
     * @return \LarpManager\Entities\GeoMap
     */
    public function setDescription($desc)
    {
        $this->description = $desc;
        return $this;
    }

    /**
     * Get the value of description.
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
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
     * Add GeoLayer entity to collection (one to many).
     *
     * @param \LarpManager\Entities\GeoLayer $layer
     * @return \LarpManager\Entities\GeoMap
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
     * @return \LarpManager\Entities\GeoMap
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

    public function __sleep()
    {
        return array('id', 'code', 'nom', 'description');
    }
}
