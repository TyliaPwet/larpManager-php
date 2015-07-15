<?php

/**
 * Auto generated by MySQL Workbench Schema Exporter.
 * Version 2.1.6-dev (doctrine2-annotation) on 2015-07-15 11:41:32.
 * Goto https://github.com/johmue/mysql-workbench-schema-exporter for more
 * information.
 */

namespace LarpManager\Entities;

/**
 * LarpManager\Entities\ObjetCarac
 *
 * @Entity()
 * @Table(name="objet_carac", indexes={@Index(name="fk_objet_carac_objet1_idx", columns={"objet_id"})})
 * @InheritanceType("SINGLE_TABLE")
 * @DiscriminatorColumn(name="discr", type="string")
 * @DiscriminatorMap({"base":"BaseObjetCarac", "extended":"ObjetCarac"})
 */
class BaseObjetCarac
{
    /**
     * @Id
     * @Column(type="integer")
     */
    protected $objet_id;

    /**
     * @Column(type="string", length=45, nullable=true)
     */
    protected $taille;

    /**
     * @Column(type="string", length=45, nullable=true)
     */
    protected $poid;

    /**
     * @Column(type="string", length=45, nullable=true)
     */
    protected $couleur;

    /**
     * @OneToOne(targetEntity="Objet", inversedBy="objetCarac")
     * @JoinColumn(name="objet_id", referencedColumnName="id")
     */
    protected $objet;

    public function __construct()
    {
    }

    /**
     * Set the value of objet_id.
     *
     * @param integer $objet_id
     * @return \LarpManager\Entities\ObjetCarac
     */
    public function setObjetId($objet_id)
    {
        $this->objet_id = $objet_id;

        return $this;
    }

    /**
     * Get the value of objet_id.
     *
     * @return integer
     */
    public function getObjetId()
    {
        return $this->objet_id;
    }

    /**
     * Set the value of taille.
     *
     * @param string $taille
     * @return \LarpManager\Entities\ObjetCarac
     */
    public function setTaille($taille)
    {
        $this->taille = $taille;

        return $this;
    }

    /**
     * Get the value of taille.
     *
     * @return string
     */
    public function getTaille()
    {
        return $this->taille;
    }

    /**
     * Set the value of poid.
     *
     * @param string $poid
     * @return \LarpManager\Entities\ObjetCarac
     */
    public function setPoid($poid)
    {
        $this->poid = $poid;

        return $this;
    }

    /**
     * Get the value of poid.
     *
     * @return string
     */
    public function getPoid()
    {
        return $this->poid;
    }

    /**
     * Set the value of couleur.
     *
     * @param string $couleur
     * @return \LarpManager\Entities\ObjetCarac
     */
    public function setCouleur($couleur)
    {
        $this->couleur = $couleur;

        return $this;
    }

    /**
     * Get the value of couleur.
     *
     * @return string
     */
    public function getCouleur()
    {
        return $this->couleur;
    }

    /**
     * Set Objet entity (one to one).
     *
     * @param \LarpManager\Entities\Objet $objet
     * @return \LarpManager\Entities\ObjetCarac
     */
    public function setObjet(Objet $objet)
    {
        $this->objet = $objet;

        return $this;
    }

    /**
     * Get Objet entity (one to one).
     *
     * @return \LarpManager\Entities\Objet
     */
    public function getObjet()
    {
        return $this->objet;
    }

    public function __sleep()
    {
        return array('objet_id', 'taille', 'poid', 'couleur');
    }
}