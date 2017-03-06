<?php

namespace DietaBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Receta
 *
 * @ORM\Table(name="receta")
 * @ORM\Entity(repositoryClass="DietaBundle\Repository\RecetaRepository")
 */
class Receta
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
     *
     * @ORM\Column(type="simple_array")
     * @var array string exmaple [' 2 spone sugar ','2 egg' ,' 1 gr apple']
     *
     *
     */

    private $ingredientes;
    /**
     * @var array string exmaple ['step1 do thing','step2 do next thing' ]
     * @ORM\Column(type="simple_array")
     *
     *
     */
    private $preparacion;

    /**
     * @ORM\Column(type="string")
     * @var string
     */
    private $foto;

    /**
     * @ORM\Column(type="string")
     * @var string
     */
    private $tiempo_preparacion;

    /**
     * @ORM\Column(type="string")
     * @var string
     */
    private $raciones;

    /**
     * Many Recetas have Many Users.
     * @ORM\ManyToMany(targetEntity="User", mappedBy="recetas_seguidas")
     */
    private $usuario_seguidores;

    private $comentarios;

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
        $this->usuario_seguidores = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set nombre
     *
     * @param string $nombre
     *
     * @return Receta
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
     * Set ingredientes
     *
     * @param array $ingredientes
     *
     * @return Receta
     */
    public function setIngredientes($ingredientes)
    {
        $this->ingredientes = $ingredientes;

        return $this;
    }

    /**
     * Get ingredientes
     *
     * @return array
     */
    public function getIngredientes()
    {
        return $this->ingredientes;
    }

    /**
     * Set preparacion
     *
     * @param array $preparacion
     *
     * @return Receta
     */
    public function setPreparacion($preparacion)
    {
        $this->preparacion = $preparacion;

        return $this;
    }

    /**
     * Get preparacion
     *
     * @return array
     */
    public function getPreparacion()
    {
        return $this->preparacion;
    }

    /**
     * Set foto
     *
     * @param string $foto
     *
     * @return Receta
     */
    public function setFoto($foto)
    {
        $this->foto = $foto;

        return $this;
    }

    /**
     * Get foto
     *
     * @return string
     */
    public function getFoto()
    {
        return $this->foto;
    }

    /**
     * Set tiempoPreparacion
     *
     * @param string $tiempoPreparacion
     *
     * @return Receta
     */
    public function setTiempoPreparacion($tiempoPreparacion)
    {
        $this->tiempo_preparacion = $tiempoPreparacion;

        return $this;
    }

    /**
     * Get tiempoPreparacion
     *
     * @return string
     */
    public function getTiempoPreparacion()
    {
        return $this->tiempo_preparacion;
    }

    /**
     * Set raciones
     *
     * @param string $raciones
     *
     * @return Receta
     */
    public function setRaciones($raciones)
    {
        $this->raciones = $raciones;

        return $this;
    }

    /**
     * Get raciones
     *
     * @return string
     */
    public function getRaciones()
    {
        return $this->raciones;
    }

    /**
     * Add usuarioSeguidore
     *
     * @param \DietaBundle\Entity\User $usuarioSeguidore
     *
     * @return Receta
     */
    public function addUsuarioSeguidore(\DietaBundle\Entity\User $usuarioSeguidore)
    {
        $this->usuario_seguidores[] = $usuarioSeguidore;

        return $this;
    }

    /**
     * Remove usuarioSeguidore
     *
     * @param \DietaBundle\Entity\User $usuarioSeguidore
     */
    public function removeUsuarioSeguidore(\DietaBundle\Entity\User $usuarioSeguidore)
    {
        $this->usuario_seguidores->removeElement($usuarioSeguidore);
    }

    /**
     * Get usuarioSeguidores
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getUsuarioSeguidores()
    {
        return $this->usuario_seguidores;
    }
}
