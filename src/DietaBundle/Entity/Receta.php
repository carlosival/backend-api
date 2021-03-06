<?php

namespace DietaBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;


/**
 * Receta
 *
 * @ORM\Table(name="receta")
 * @ORM\Entity(repositoryClass="DietaBundle\Repository\RecetaRepository")
 * @Vich\Uploadable
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
     * @ORM\Column(type="string" ,nullable=true)
     * @var string
     */
    private $tiempopreparacion;

    /**
     * @ORM\Column(type="text" ,nullable=true)
     * @var string
     *
     */

    private $descripcion;

    /**
     * @ORM\Column(type="string" ,nullable=true)
     * @var string
     */
    private $raciones;

    /**
     * Many Recetas have Many Users.
     * @ORM\ManyToMany(targetEntity="User", inversedBy="recetas_seguidas")
     */
    private $usuario_seguidores;

    /**
     * Many Recetas belongs One User.
     * @ORM\ManyToOne(targetEntity="DietaBundle\Entity\User", inversedBy="recetas")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     */
    private $user;

    /**
     * NOTE: This is not a mapped field of entity metadata, just a simple property.
     *
     * @Vich\UploadableField(mapping="receta_image", fileNameProperty="imageName")
     *
     * @var File
     */
    private $imageFile;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     *
     * @var string
     */
    private $imageName;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     *
     * @var \DateTime
     */
    private $updatedAt;

    /**
     * If manually uploading a file (i.e. not using Symfony Form) ensure an instance
     * of 'UploadedFile' is injected into this setter to trigger the  update. If this
     * bundle's configuration parameter 'inject_on_load' is set to 'true' this setter
     * must be able to accept an instance of 'File' as the bundle will inject one here
     * during Doctrine hydration.
     *
     * @param File|\Symfony\Component\HttpFoundation\File\UploadedFile $image
     *
     * @return Receta
     */
    public function setImageFile(File $image = null)
    {
        $this->imageFile = $image;

        if ($image) {
            // It is required that at least one field changes if you are using doctrine
            // otherwise the event listeners won't be called and the file is lost
            $this->updatedAt = new \DateTimeImmutable();
        }

        return $this;
    }

    /**
     * @return File|null
     */
    public function getImageFile()
    {
        return $this->imageFile;
    }

    /**
     * @param string $imageName
     *
     * @return Receta
     */
    public function setImageName($imageName)
    {
        $this->imageName = $imageName;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getImageName()
    {
        return $this->imageName;
    }

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
     * Add usuarioSeguidores
     *
     * @param \DietaBundle\Entity\User $usuarioSeguidores
     *
     * @return Receta
     */
    public function addUsuarioSeguidores(\DietaBundle\Entity\User $usuarioSeguidores)
    {
        if ($this->usuario_seguidores->contains($usuarioSeguidores)) {
            return $this;
        }

        $usuarioSeguidores ->addRecetasSeguida($this); // synchronously updating inverse side

        $this->usuario_seguidores[] = $usuarioSeguidores;

        return $this;
    }

    /**
     * Remove usuarioSeguidores
     *
     * @param \DietaBundle\Entity\User $usuarioSeguidores
     */
    public function removeUsuarioSeguidores(\DietaBundle\Entity\User $usuarioSeguidores)
    {
        $this->usuario_seguidores->removeElement($usuarioSeguidores);
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

    /**
     * Set user
     *
     * @param \DietaBundle\Entity\User $user
     *
     * @return Receta
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

    public function getUri()
    {
        $domain = 'http://localhost/images/recetas/';
        return $domain . $this->getImageName() ;

    }


    /**
     * Set updatedAt
     *
     * @param \DateTime $updatedAt
     *
     * @return Receta
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * Get updatedAt
     *
     * @return \DateTime
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * Set tiempopreparacion
     *
     * @param string $tiempopreparacion
     *
     * @return Receta
     */
    public function setTiempopreparacion($tiempopreparacion)
    {
        $this->tiempopreparacion = $tiempopreparacion;

        return $this;
    }

    /**
     * Get tiempopreparacion
     *
     * @return string
     */
    public function getTiempopreparacion()
    {
        return $this->tiempopreparacion;
    }

    /**
     * Set descripcion
     *
     * @param string $descripcion
     *
     * @return Receta
     */
    public function setDescripcion($descripcion)
    {
        $this->descripcion = $descripcion;

        return $this;
    }

    /**
     * Get descripcion
     *
     * @return string
     */
    public function getDescripcion()
    {
        return $this->descripcion;
    }
}
