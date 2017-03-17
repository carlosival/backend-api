<?php

namespace DietaBundle\Entity;

use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;
use Hateoas\Configuration\Annotation as Hateoas;
#use Sylius\Component\Resource\Model\ResourceInterface;

/**
 * User
 *
 * @ORM\Table(name="usuario")
 * @ORM\Entity(repositoryClass="DietaBundle\Repository\UserRepository")
 * @Hateoas\Relation("self", href = "expr('/api/user/' ~ object.getId())")
 *
 *
 */
class User extends BaseUser
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * One User own Many Dietas.
     * @ORM\OneToMany(targetEntity="DietaBundle\Entity\Dieta", mappedBy="user")
     */
    private $dietas;

    /**
     * One User own Many Recetas.
     * @ORM\OneToMany(targetEntity="DietaBundle\Entity\Receta", mappedBy="user")
     */
    private $recetas;

    /**
     * Many Users follow Many Dietas.
     * @ORM\ManyToMany(targetEntity="Dieta", inversedBy="usuarios_seguidores")
     * @ORM\JoinTable(name="users_dietaseguidas")
     */

    private $dieta_seguidas;


    /**
     * Many Users follow Many Recetas.
     * @ORM\ManyToMany(targetEntity="DietaBundle\Entity\Receta", inversedBy="usuario_seguidores")
     * @ORM\JoinTable(name="users_recetaseguidas")
     */
    private $recetas_seguidas;

    /**
     * Many Users have me as friend Many Users.
     * @ORM\ManyToMany(targetEntity="User", mappedBy="myFriends")
     */
    private $friendsWithMe;

    /**
     * I have Many Users friends.
     * @ORM\ManyToMany(targetEntity="User", inversedBy="friendsWithMe")
     * @ORM\JoinTable(name="friends",
     *      joinColumns={@ORM\JoinColumn(name="user_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="friend_user_id", referencedColumnName="id")}
     *      )
     */
    private $myFriends;


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
        $this->dietas = new \Doctrine\Common\Collections\ArrayCollection();
        $this->recetas = new \Doctrine\Common\Collections\ArrayCollection();
        $this->dieta_seguidas = new \Doctrine\Common\Collections\ArrayCollection();
        $this->recetas_seguidas = new \Doctrine\Common\Collections\ArrayCollection();
        $this->friendsWithMe = new \Doctrine\Common\Collections\ArrayCollection();
        $this->myFriends = new \Doctrine\Common\Collections\ArrayCollection();

        parent::__construct();

    }

    /**
     * Add dieta
     *
     * @param \DietaBundle\Entity\Dieta $dieta
     *
     * @return User
     */
    public function addDieta(\DietaBundle\Entity\Dieta $dieta)
    {
        $this->dietas[] = $dieta;

        return $this;
    }

    /**
     * Remove dieta
     *
     * @param \DietaBundle\Entity\Dieta $dieta
     */
    public function removeDieta(\DietaBundle\Entity\Dieta $dieta)
    {
        $this->dietas->removeElement($dieta);
    }

    /**
     * Get dietas
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getDietas()
    {
        return $this->dietas;
    }

    /**
     * Add receta
     *
     * @param \DietaBundle\Entity\Receta $receta
     *
     * @return User
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

    /**
     * Add dietaSeguida
     *
     * @param \DietaBundle\Entity\Dieta $dietaSeguida
     *
     * @return User
     */
    public function addDietaSeguida(\DietaBundle\Entity\Dieta $dietaSeguida)
    {
        $this->dieta_seguidas[] = $dietaSeguida;

        return $this;
    }

    /**
     * Remove dietaSeguida
     *
     * @param \DietaBundle\Entity\Dieta $dietaSeguida
     */
    public function removeDietaSeguida(\DietaBundle\Entity\Dieta $dietaSeguida)
    {
        $this->dieta_seguidas->removeElement($dietaSeguida);
    }

    /**
     * Get dietaSeguidas
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getDietaSeguidas()
    {
        return $this->dieta_seguidas;
    }

    /**
     * Add recetasSeguida
     *
     * @param \DietaBundle\Entity\Receta $recetasSeguida
     *
     * @return User
     */
    public function addRecetasSeguida(\DietaBundle\Entity\Receta $recetasSeguida)
    {
        $this->recetas_seguidas[] = $recetasSeguida;

        return $this;
    }

    /**
     * Remove recetasSeguida
     *
     * @param \DietaBundle\Entity\Receta $recetasSeguida
     */
    public function removeRecetasSeguida(\DietaBundle\Entity\Receta $recetasSeguida)
    {
        $this->recetas_seguidas->removeElement($recetasSeguida);
    }

    /**
     * Get recetasSeguidas
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getRecetasSeguidas()
    {
        return $this->recetas_seguidas;
    }

    /**
     * Add friendsWithMe
     *
     * @param \DietaBundle\Entity\User $friendsWithMe
     *
     * @return User
     */
    public function addFriendsWithMe(\DietaBundle\Entity\User $friendsWithMe)
    {
        $this->friendsWithMe[] = $friendsWithMe;

        return $this;
    }

    /**
     * Remove friendsWithMe
     *
     * @param \DietaBundle\Entity\User $friendsWithMe
     */
    public function removeFriendsWithMe(\DietaBundle\Entity\User $friendsWithMe)
    {
        $this->friendsWithMe->removeElement($friendsWithMe);
    }

    /**
     * Get friendsWithMe
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getFriendsWithMe()
    {
        return $this->friendsWithMe;
    }

    /**
     * Add myFriend
     *
     * @param \DietaBundle\Entity\User $myFriend
     *
     * @return User
     */
    public function addMyFriend(\DietaBundle\Entity\User $myFriend)
    {
        $this->myFriends[] = $myFriend;

        return $this;
    }

    /**
     * Remove myFriend
     *
     * @param \DietaBundle\Entity\User $myFriend
     */
    public function removeMyFriend(\DietaBundle\Entity\User $myFriend)
    {
        $this->myFriends->removeElement($myFriend);
    }

    /**
     * Get myFriends
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getMyFriends()
    {
        return $this->myFriends;
    }
}
