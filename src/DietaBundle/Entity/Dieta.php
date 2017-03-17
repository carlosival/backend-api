<?php

namespace DietaBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Dieta
 *
 * @ORM\Table(name="dieta")
 * @ORM\Entity(repositoryClass="DietaBundle\Repository\DietaRepository")
 */
class Dieta
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(type="string")
     * @var string
     */
    private $nombre;

    /**
     * One Dieta have Many DietaItems o Rutinas.
     * @ORM\ManyToMany(targetEntity="DietaItem")
     * @ORM\JoinTable(name="dietas_dietaitems",
     *      joinColumns={@ORM\JoinColumn(name="dieta_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="dietaitem_id", referencedColumnName="id", unique=true)}
     *      )
     */
    private $dieta_items;

    /**
     * Many Dietas have Many Users.
     * @ORM\ManyToMany(targetEntity="User", mappedBy="dieta_seguidas")
     */
    private $usuarios_seguidores;

    /**
     * Many Dietas belongs One User.
     * @ORM\ManyToOne(targetEntity="DietaBundle\Entity\User", inversedBy="dietas")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     */
    private $user;


    private $commentarios;

    private $valoracion;
    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->dieta_items = new \Doctrine\Common\Collections\ArrayCollection();
        $this->usuarios_seguidores = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set nombre
     *
     * @param string $nombre
     *
     * @return Dieta
     */
    public function setNombre($nombre)
    {
        $this->nombre = $nombre;

        return $this;
    }

    /**
     * Get nombre
     *
     * @return string
     */
    public function getNombre()
    {
        return $this->nombre;
    }

    /**
     * Add dietaItem
     *
     * @param \DietaBundle\Entity\DietaItem $dietaItem
     *
     * @return Dieta
     */
    public function addDietaItem(\DietaBundle\Entity\DietaItem $dietaItem)
    {
        $this->dieta_items[] = $dietaItem;

        return $this;
    }

    /**
     * Remove dietaItem
     *
     * @param \DietaBundle\Entity\DietaItem $dietaItem
     */
    public function removeDietaItem(\DietaBundle\Entity\DietaItem $dietaItem)
    {
        $this->dieta_items->removeElement($dietaItem);
    }

    /**
     * Get dietaItems
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getDietaItems()
    {
        return $this->dieta_items;
    }

    /**
     * Add usuariosSeguidore
     *
     * @param \DietaBundle\Entity\User $usuariosSeguidore
     *
     * @return Dieta
     */
    public function addUsuariosSeguidore(\DietaBundle\Entity\User $usuariosSeguidore)
    {
        $this->usuarios_seguidores[] = $usuariosSeguidore;

        return $this;
    }

    /**
     * Remove usuariosSeguidore
     *
     * @param \DietaBundle\Entity\User $usuariosSeguidore
     */
    public function removeUsuariosSeguidore(\DietaBundle\Entity\User $usuariosSeguidore)
    {
        $this->usuarios_seguidores->removeElement($usuariosSeguidore);
    }

    /**
     * Get usuariosSeguidores
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getUsuariosSeguidores()
    {
        return $this->usuarios_seguidores;
    }

    /**
     * Set user
     *
     * @param \DietaBundle\Entity\User $user
     *
     * @return Dieta
     */
    public function setUser(\DietaBundle\Entity\User $user = null)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \DietaBundle\Entity\User
     */
    public function getUser()
    {
        return $this->user;
    }
}
