<?php

/**
 * Auto generated by MySQL Workbench Schema Exporter.
 * Version 2.1.6-dev (doctrine2-annotation) on 2015-07-15 11:41:32.
 * Goto https://github.com/johmue/mysql-workbench-schema-exporter for more
 * information.
 */

namespace LarpManager\Entities;

use Doctrine\Common\Collections\ArrayCollection;

/**
 * LarpManager\Entities\Confrerie
 *
 * @Entity()
 * @Table(name="confrerie")
 * @InheritanceType("SINGLE_TABLE")
 * @DiscriminatorColumn(name="discr", type="string")
 * @DiscriminatorMap({"base":"BaseConfrerie", "extended":"Confrerie"})
 */
class BaseConfrerie
{
    /**
     * @Id
     * @Column(type="integer")
     */
    protected $id;

    /**
     * @Column(type="string", length=100, nullable=true)
     */
    protected $label;

    /**
     * @Column(type="string", length=450, nullable=true)
     */
    protected $description;

    /**
     * @ManyToMany(targetEntity="Personnage", mappedBy="confreries")
     */
    protected $personnages;

    public function __construct()
    {
        $this->personnages = new ArrayCollection();
    }

    /**
     * Set the value of id.
     *
     * @param integer $id
     * @return \LarpManager\Entities\Confrerie
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
     * Set the value of label.
     *
     * @param string $label
     * @return \LarpManager\Entities\Confrerie
     */
    public function setLabel($label)
    {
        $this->label = $label;

        return $this;
    }

    /**
     * Get the value of label.
     *
     * @return string
     */
    public function getLabel()
    {
        return $this->label;
    }

    /**
     * Set the value of description.
     *
     * @param string $description
     * @return \LarpManager\Entities\Confrerie
     */
    public function setDescription($description)
    {
        $this->description = $description;

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
     * Add Personnage entity to collection.
     *
     * @param \LarpManager\Entities\Personnage $personnage
     * @return \LarpManager\Entities\Confrerie
     */
    public function addPersonnage(Personnage $personnage)
    {
        $this->personnages[] = $personnage;

        return $this;
    }

    /**
     * Remove Personnage entity from collection.
     *
     * @param \LarpManager\Entities\Personnage $personnage
     * @return \LarpManager\Entities\Confrerie
     */
    public function removePersonnage(Personnage $personnage)
    {
        $this->personnages->removeElement($personnage);

        return $this;
    }

    /**
     * Get Personnage entity collection.
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getPersonnages()
    {
        return $this->personnages;
    }

    public function __sleep()
    {
        return array('id', 'label', 'description');
    }
}