<?php

namespace DietaBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * DietaItem
 *
 * @ORM\Table(name="dieta_item")
 * @ORM\Entity(repositoryClass="DietaBundle\Repository\DietaItemRepository")
 */
class DietaItem
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
     * @var string clasificacion semantica (desayuno,aperitivo,comida,merienda,cena)
     *
     * @ORM\Column(type="string")
     *
     *
     */
    private $clasificacion;


    /**
     * Many DietaItems have Many Recetas.
     * @ORM\ManyToMany(targetEntity="Receta")
     * @ORM\JoinTable(name="dietaitem_recetas",
     *      joinColumns={@ORM\JoinColumn(name="dietaitem_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="receta_id", referencedColumnName="id")}
     *      )
     */
    private $recetas;

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
        $this->recetas = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set clasificacion
     *
     * @param string $clasificacion
     *
     * @return DietaItem
     */
    public function setClasificacion($clasificacion)
    {
        $this->clasificacion = $clasificacion;

        return $this;
    }

    /**
     * Get clasificacion
     *
     * @return string
     */
    public function getClasificacion()
    {
        return $this->clasificacion;
    }

    /**
     * Add receta
     *
     * @param \DietaBundle\Entity\Receta $receta
     *
     * @return DietaItem
     */
    public function addReceta(\DietaBundle\Entity\Receta $receta)
    {
        $this->recetas[] = $receta;

        return $this;
    }

    /**
     * Remove receta
     *
     * @param \DietaBundle\Entity\Receta $receta
     */
    public function removeReceta(\DietaBundle\Entity\Receta $receta)
    {
        $this->recetas->removeElement($receta);
    }

    /**
     * Get recetas
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getRecetas()
    {
        return $this->recetas;
    }
}
