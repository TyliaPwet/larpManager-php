<?php

/**
 * Auto generated by MySQL Workbench Schema Exporter.
 * Version 2.1.6-dev (doctrine2-annotation) on 2016-06-17 17:19:58.
 * Goto https://github.com/johmue/mysql-workbench-schema-exporter for more
 * information.
 */

namespace LarpManager\Entities;

use Doctrine\Common\Collections\ArrayCollection;

/**
 * LarpManager\Entities\Groupe
 *
 * @Entity()
 * @Table(name="groupe", indexes={@Index(name="fk_groupe_users1_idx", columns={"scenariste_id"}), @Index(name="fk_groupe_user2_idx", columns={"responsable_id"}), @Index(name="fk_groupe_topic1_idx", columns={"topic_id"})})
 * @InheritanceType("SINGLE_TABLE")
 * @DiscriminatorColumn(name="discr", type="string")
 * @DiscriminatorMap({"base":"BaseGroupe", "extended":"Groupe"})
 */
class BaseGroupe
{
    /**
     * @Id
     * @Column(type="integer")
     * @GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @Column(type="string", length=100, nullable=true)
     */
    protected $nom;

    /**
     * @Column(type="text", nullable=true)
     */
    protected $description;

    /**
     * @Column(type="integer")
     */
    protected $numero;

    /**
     * @Column(type="string", length=10, nullable=true)
     */
    protected $code;

    /**
     * @Column(type="boolean", nullable=true)
     */
    protected $jeu_maritime;

    /**
     * @Column(type="boolean", nullable=true)
     */
    protected $jeu_strategique;

    /**
     * @Column(type="integer", nullable=true)
     */
    protected $classe_open;

    /**
     * @Column(type="boolean", nullable=true)
     */
    protected $pj;

    /**
     * @Column(type="text", nullable=true)
     */
    protected $materiel;

    /**
     * @OneToMany(targetEntity="Background", mappedBy="groupe")
     * @JoinColumn(name="id", referencedColumnName="groupe_id", nullable=false)
     */
    protected $backgrounds;

    /**
     * @OneToMany(targetEntity="GroupeAllie", mappedBy="groupeRelatedByGroupeId")
     * @JoinColumn(name="id", referencedColumnName="groupe_id", nullable=false)
     */
    protected $groupeAllieRelatedByGroupeIds;

    /**
     * @OneToMany(targetEntity="GroupeAllie", mappedBy="groupeRelatedByGroupeAllieId")
     * @JoinColumn(name="id", referencedColumnName="groupe_allie_id", nullable=false)
     */
    protected $groupeAllieRelatedByGroupeAllieIds;

    /**
     * @OneToMany(targetEntity="GroupeClasse", mappedBy="groupe", cascade={"persist"})
     * @JoinColumn(name="id", referencedColumnName="groupe_id", nullable=false)
     */
    protected $groupeClasses;

    /**
     * @OneToMany(targetEntity="GroupeEnemy", mappedBy="groupeRelatedByGroupeId")
     * @JoinColumn(name="id", referencedColumnName="groupe_id", nullable=false)
     */
    protected $groupeEnemyRelatedByGroupeIds;

    /**
     * @OneToMany(targetEntity="GroupeEnemy", mappedBy="groupeRelatedByGroupeEnemyId")
     * @JoinColumn(name="id", referencedColumnName="groupe_enemy_id", nullable=false)
     */
    protected $groupeEnemyRelatedByGroupeEnemyIds;

    /**
     * @OneToMany(targetEntity="Participant", mappedBy="groupe")
     * @JoinColumn(name="id", referencedColumnName="groupe_id", nullable=false)
     */
    protected $participants;

    /**
     * @OneToMany(targetEntity="Personnage", mappedBy="groupe")
     * @JoinColumn(name="id", referencedColumnName="groupe_id", nullable=false)
     */
    protected $personnages;

    /**
     * @OneToMany(targetEntity="Territoire", mappedBy="groupe")
     * @JoinColumn(name="id", referencedColumnName="groupe_id", nullable=false)
     */
    protected $territoires;

    /**
     * @ManyToOne(targetEntity="User", inversedBy="groupeRelatedByScenaristeIds")
     * @JoinColumn(name="scenariste_id", referencedColumnName="id")
     */
    protected $userRelatedByScenaristeId;

    /**
     * @ManyToOne(targetEntity="User", inversedBy="groupeRelatedByResponsableIds")
     * @JoinColumn(name="responsable_id", referencedColumnName="id")
     */
    protected $userRelatedByResponsableId;

    /**
     * @ManyToOne(targetEntity="Topic", inversedBy="groupes")
     * @JoinColumn(name="topic_id", referencedColumnName="id", nullable=false)
     */
    protected $topic;

    /**
     * @ManyToMany(targetEntity="Gn", mappedBy="groupes", cascade={"persist"})
     */
    protected $gns;

    public function __construct()
    {
        $this->backgrounds = new ArrayCollection();
        $this->groupeAllieRelatedByGroupeIds = new ArrayCollection();
        $this->groupeAllieRelatedByGroupeAllieIds = new ArrayCollection();
        $this->groupeClasses = new ArrayCollection();
        $this->groupeEnemyRelatedByGroupeIds = new ArrayCollection();
        $this->groupeEnemyRelatedByGroupeEnemyIds = new ArrayCollection();
        $this->participants = new ArrayCollection();
        $this->personnages = new ArrayCollection();
        $this->territoires = new ArrayCollection();
        $this->gns = new ArrayCollection();
    }

    /**
     * Set the value of id.
     *
     * @param integer $id
     * @return \LarpManager\Entities\Groupe
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
     * Set the value of nom.
     *
     * @param string $nom
     * @return \LarpManager\Entities\Groupe
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
     * @param string $description
     * @return \LarpManager\Entities\Groupe
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
     * Set the value of numero.
     *
     * @param integer $numero
     * @return \LarpManager\Entities\Groupe
     */
    public function setNumero($numero)
    {
        $this->numero = $numero;

        return $this;
    }

    /**
     * Get the value of numero.
     *
     * @return integer
     */
    public function getNumero()
    {
        return $this->numero;
    }

    /**
     * Set the value of code.
     *
     * @param string $code
     * @return \LarpManager\Entities\Groupe
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
     * Set the value of jeu_maritime.
     *
     * @param boolean $jeu_maritime
     * @return \LarpManager\Entities\Groupe
     */
    public function setJeuMaritime($jeu_maritime)
    {
        $this->jeu_maritime = $jeu_maritime;

        return $this;
    }

    /**
     * Get the value of jeu_maritime.
     *
     * @return boolean
     */
    public function getJeuMaritime()
    {
        return $this->jeu_maritime;
    }

    /**
     * Set the value of jeu_strategique.
     *
     * @param boolean $jeu_strategique
     * @return \LarpManager\Entities\Groupe
     */
    public function setJeuStrategique($jeu_strategique)
    {
        $this->jeu_strategique = $jeu_strategique;

        return $this;
    }

    /**
     * Get the value of jeu_strategique.
     *
     * @return boolean
     */
    public function getJeuStrategique()
    {
        return $this->jeu_strategique;
    }

    /**
     * Set the value of classe_open.
     *
     * @param integer $classe_open
     * @return \LarpManager\Entities\Groupe
     */
    public function setClasseOpen($classe_open)
    {
        $this->classe_open = $classe_open;

        return $this;
    }

    /**
     * Get the value of classe_open.
     *
     * @return integer
     */
    public function getClasseOpen()
    {
        return $this->classe_open;
    }

    /**
     * Set the value of pj.
     *
     * @param boolean $pj
     * @return \LarpManager\Entities\Groupe
     */
    public function setPj($pj)
    {
        $this->pj = $pj;

        return $this;
    }

    /**
     * Get the value of pj.
     *
     * @return boolean
     */
    public function getPj()
    {
        return $this->pj;
    }

    /**
     * Set the value of materiel.
     *
     * @param string $materiel
     * @return \LarpManager\Entities\Groupe
     */
    public function setMateriel($materiel)
    {
        $this->materiel = $materiel;

        return $this;
    }

    /**
     * Get the value of materiel.
     *
     * @return string
     */
    public function getMateriel()
    {
        return $this->materiel;
    }

    /**
     * Add Background entity to collection (one to many).
     *
     * @param \LarpManager\Entities\Background $background
     * @return \LarpManager\Entities\Groupe
     */
    public function addBackground(Background $background)
    {
        $this->backgrounds[] = $background;

        return $this;
    }

    /**
     * Remove Background entity from collection (one to many).
     *
     * @param \LarpManager\Entities\Background $background
     * @return \LarpManager\Entities\Groupe
     */
    public function removeBackground(Background $background)
    {
        $this->backgrounds->removeElement($background);

        return $this;
    }

    /**
     * Get Background entity collection (one to many).
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getBackgrounds()
    {
        return $this->backgrounds;
    }

    /**
     * Add GroupeAllie entity related by `groupe_id` to collection (one to many).
     *
     * @param \LarpManager\Entities\GroupeAllie $groupeAllie
     * @return \LarpManager\Entities\Groupe
     */
    public function addGroupeAllieRelatedByGroupeId(GroupeAllie $groupeAllie)
    {
        $this->groupeAllieRelatedByGroupeIds[] = $groupeAllie;

        return $this;
    }

    /**
     * Remove GroupeAllie entity related by `groupe_id` from collection (one to many).
     *
     * @param \LarpManager\Entities\GroupeAllie $groupeAllie
     * @return \LarpManager\Entities\Groupe
     */
    public function removeGroupeAllieRelatedByGroupeId(GroupeAllie $groupeAllie)
    {
        $this->groupeAllieRelatedByGroupeIds->removeElement($groupeAllie);

        return $this;
    }

    /**
     * Get GroupeAllie entity related by `groupe_id` collection (one to many).
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getGroupeAllieRelatedByGroupeIds()
    {
        return $this->groupeAllieRelatedByGroupeIds;
    }

    /**
     * Add GroupeAllie entity related by `groupe_allie_id` to collection (one to many).
     *
     * @param \LarpManager\Entities\GroupeAllie $groupeAllie
     * @return \LarpManager\Entities\Groupe
     */
    public function addGroupeAllieRelatedByGroupeAllieId(GroupeAllie $groupeAllie)
    {
        $this->groupeAllieRelatedByGroupeAllieIds[] = $groupeAllie;

        return $this;
    }

    /**
     * Remove GroupeAllie entity related by `groupe_allie_id` from collection (one to many).
     *
     * @param \LarpManager\Entities\GroupeAllie $groupeAllie
     * @return \LarpManager\Entities\Groupe
     */
    public function removeGroupeAllieRelatedByGroupeAllieId(GroupeAllie $groupeAllie)
    {
        $this->groupeAllieRelatedByGroupeAllieIds->removeElement($groupeAllie);

        return $this;
    }

    /**
     * Get GroupeAllie entity related by `groupe_allie_id` collection (one to many).
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getGroupeAllieRelatedByGroupeAllieIds()
    {
        return $this->groupeAllieRelatedByGroupeAllieIds;
    }

    /**
     * Add GroupeClasse entity to collection (one to many).
     *
     * @param \LarpManager\Entities\GroupeClasse $groupeClasse
     * @return \LarpManager\Entities\Groupe
     */
    public function addGroupeClasse(GroupeClasse $groupeClasse)
    {
        $this->groupeClasses[] = $groupeClasse;

        return $this;
    }

    /**
     * Remove GroupeClasse entity from collection (one to many).
     *
     * @param \LarpManager\Entities\GroupeClasse $groupeClasse
     * @return \LarpManager\Entities\Groupe
     */
    public function removeGroupeClasse(GroupeClasse $groupeClasse)
    {
        $this->groupeClasses->removeElement($groupeClasse);

        return $this;
    }

    /**
     * Get GroupeClasse entity collection (one to many).
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getGroupeClasses()
    {
        return $this->groupeClasses;
    }

    /**
     * Add GroupeEnemy entity related by `groupe_id` to collection (one to many).
     *
     * @param \LarpManager\Entities\GroupeEnemy $groupeEnemy
     * @return \LarpManager\Entities\Groupe
     */
    public function addGroupeEnemyRelatedByGroupeId(GroupeEnemy $groupeEnemy)
    {
        $this->groupeEnemyRelatedByGroupeIds[] = $groupeEnemy;

        return $this;
    }

    /**
     * Remove GroupeEnemy entity related by `groupe_id` from collection (one to many).
     *
     * @param \LarpManager\Entities\GroupeEnemy $groupeEnemy
     * @return \LarpManager\Entities\Groupe
     */
    public function removeGroupeEnemyRelatedByGroupeId(GroupeEnemy $groupeEnemy)
    {
        $this->groupeEnemyRelatedByGroupeIds->removeElement($groupeEnemy);

        return $this;
    }

    /**
     * Get GroupeEnemy entity related by `groupe_id` collection (one to many).
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getGroupeEnemyRelatedByGroupeIds()
    {
        return $this->groupeEnemyRelatedByGroupeIds;
    }

    /**
     * Add GroupeEnemy entity related by `groupe_enemy_id` to collection (one to many).
     *
     * @param \LarpManager\Entities\GroupeEnemy $groupeEnemy
     * @return \LarpManager\Entities\Groupe
     */
    public function addGroupeEnemyRelatedByGroupeEnemyId(GroupeEnemy $groupeEnemy)
    {
        $this->groupeEnemyRelatedByGroupeEnemyIds[] = $groupeEnemy;

        return $this;
    }

    /**
     * Remove GroupeEnemy entity related by `groupe_enemy_id` from collection (one to many).
     *
     * @param \LarpManager\Entities\GroupeEnemy $groupeEnemy
     * @return \LarpManager\Entities\Groupe
     */
    public function removeGroupeEnemyRelatedByGroupeEnemyId(GroupeEnemy $groupeEnemy)
    {
        $this->groupeEnemyRelatedByGroupeEnemyIds->removeElement($groupeEnemy);

        return $this;
    }

    /**
     * Get GroupeEnemy entity related by `groupe_enemy_id` collection (one to many).
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getGroupeEnemyRelatedByGroupeEnemyIds()
    {
        return $this->groupeEnemyRelatedByGroupeEnemyIds;
    }

    /**
     * Add Participant entity to collection (one to many).
     *
     * @param \LarpManager\Entities\Participant $participant
     * @return \LarpManager\Entities\Groupe
     */
    public function addParticipant(Participant $participant)
    {
        $this->participants[] = $participant;

        return $this;
    }

    /**
     * Remove Participant entity from collection (one to many).
     *
     * @param \LarpManager\Entities\Participant $participant
     * @return \LarpManager\Entities\Groupe
     */
    public function removeParticipant(Participant $participant)
    {
        $this->participants->removeElement($participant);

        return $this;
    }

    /**
     * Get Participant entity collection (one to many).
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getParticipants()
    {
        return $this->participants;
    }

    /**
     * Add Personnage entity to collection (one to many).
     *
     * @param \LarpManager\Entities\Personnage $personnage
     * @return \LarpManager\Entities\Groupe
     */
    public function addPersonnage(Personnage $personnage)
    {
        $this->personnages[] = $personnage;

        return $this;
    }

    /**
     * Remove Personnage entity from collection (one to many).
     *
     * @param \LarpManager\Entities\Personnage $personnage
     * @return \LarpManager\Entities\Groupe
     */
    public function removePersonnage(Personnage $personnage)
    {
        $this->personnages->removeElement($personnage);

        return $this;
    }

    /**
     * Get Personnage entity collection (one to many).
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getPersonnages()
    {
        return $this->personnages;
    }

    /**
     * Add Territoire entity to collection (one to many).
     *
     * @param \LarpManager\Entities\Territoire $territoire
     * @return \LarpManager\Entities\Groupe
     */
    public function addTerritoire(Territoire $territoire)
    {
        $this->territoires[] = $territoire;

        return $this;
    }

    /**
     * Remove Territoire entity from collection (one to many).
     *
     * @param \LarpManager\Entities\Territoire $territoire
     * @return \LarpManager\Entities\Groupe
     */
    public function removeTerritoire(Territoire $territoire)
    {
        $this->territoires->removeElement($territoire);

        return $this;
    }

    /**
     * Get Territoire entity collection (one to many).
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getTerritoires()
    {
        return $this->territoires;
    }

    /**
     * Set User entity related by `scenariste_id` (many to one).
     *
     * @param \LarpManager\Entities\User $user
     * @return \LarpManager\Entities\Groupe
     */
    public function setUserRelatedByScenaristeId(User $user = null)
    {
        $this->userRelatedByScenaristeId = $user;

        return $this;
    }

    /**
     * Get User entity related by `scenariste_id` (many to one).
     *
     * @return \LarpManager\Entities\User
     */
    public function getUserRelatedByScenaristeId()
    {
        return $this->userRelatedByScenaristeId;
    }

    /**
     * Set User entity related by `responsable_id` (many to one).
     *
     * @param \LarpManager\Entities\User $user
     * @return \LarpManager\Entities\Groupe
     */
    public function setUserRelatedByResponsableId(User $user = null)
    {
        $this->userRelatedByResponsableId = $user;

        return $this;
    }

    /**
     * Get User entity related by `responsable_id` (many to one).
     *
     * @return \LarpManager\Entities\User
     */
    public function getUserRelatedByResponsableId()
    {
        return $this->userRelatedByResponsableId;
    }

    /**
     * Set Topic entity (many to one).
     *
     * @param \LarpManager\Entities\Topic $topic
     * @return \LarpManager\Entities\Groupe
     */
    public function setTopic(Topic $topic = null)
    {
        $this->topic = $topic;

        return $this;
    }

    /**
     * Get Topic entity (many to one).
     *
     * @return \LarpManager\Entities\Topic
     */
    public function getTopic()
    {
        return $this->topic;
    }

    /**
     * Add Gn entity to collection.
     *
     * @param \LarpManager\Entities\Gn $gn
     * @return \LarpManager\Entities\Groupe
     */
    public function addGn(Gn $gn)
    {
        $this->gns[] = $gn;

        return $this;
    }

    /**
     * Remove Gn entity from collection.
     *
     * @param \LarpManager\Entities\Gn $gn
     * @return \LarpManager\Entities\Groupe
     */
    public function removeGn(Gn $gn)
    {
        $this->gns->removeElement($gn);

        return $this;
    }

    /**
     * Get Gn entity collection.
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getGns()
    {
        return $this->gns;
    }

    public function __sleep()
    {
        return array('id', 'nom', 'description', 'numero', 'code', 'jeu_maritime', 'jeu_strategique', 'scenariste_id', 'classe_open', 'responsable_id', 'topic_id', 'pj', 'materiel');
    }
}