<?php

namespace Briooz\TaskBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Security\Core\User\AdvancedUserInterface;

/**
 * Usuario
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Briooz\TaskBundle\Entity\UsuarioRepository")
 */
class Usuario implements AdvancedUserInterface, \Serializable {

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="usuario", type="string", length=50)
     */
    private $usuario;

    /**
     * @var string
     *
     * @ORM\Column(name="nombre", type="string", length=100)
     */
    private $nombre;

    /**
     * @var string
     *
     * @ORM\Column(name="avatar", type="string", length=100, nullable=true))
     */
    private $avatar;

    /**
     * @var string
     *
     * @ORM\Column(name="apellidos", type="string", length=100,nullable=true))
     */
    private $apellidos;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=100,nullable=true))
     */
    private $email;

    /**
     * @var int
     *
     * @ORM\Column(name="telefono", type="integer", length=10,nullable=true))
     */
    private $telefono;

    /**
     * @var string
     *
     * @ORM\Column(name="password", type="string", length=255)
     */
    private $password;

    /**
     * @var string
     *
     * @ORM\Column(name="role", type="string",columnDefinition="ENUM('ROLE_SUPERADMIN','ROLE_ADMIN','ROLE_USER')" , length=50, nullable=true))
     */
    private $role;

    /**
     * @var boolean
     *
     * @ORM\Column(name="is_active", type="boolean")
     */
    private $isActive;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="ultima_conexion", type="datetime", nullable=true))
     */
    private $ultimaConexion;

    /**
     * @ORM\OneToMany(targetEntity="Briooz\VentasBundle\Entity\Venta", mappedBy="usuario")
     * @var int
     */
    protected $venta;

    public function __construct() {
        
    }

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId() {
        return $this->id;
    }

    /**
     * Set usuario
     *
     * @param string $usuario
     * @return Usuario
     */
    public function setUsuario($usuario) {
        $this->usuario = $usuario;

        return $this;
    }

    /**
     * Get usuario
     *
     * @return string 
     */
    public function getUsuario() {
        return $this->usuario;
    }

    /**
     * Set nombre
     *
     * @param string $nombre
     * @return Usuario
     */
    public function setNombre($nombre) {
        $this->nombre = $nombre;

        return $this;
    }

    /**
     * Get nombre
     *
     * @return string 
     */
    public function getNombre() {
        return $this->nombre;
    }

    /**
     * Set avatar
     *
     * @param string $avatar
     * @return Usuario
     */
    public function setAvatar($avatar) {
        $this->avatar = $avatar;

        return $this;
    }

    /**
     * Get avatar
     *
     * @return string 
     */
    public function getAvatar() {
        return $this->avatar;
    }

    /**
     * Set apellidos
     *
     * @param string $apellidos
     * @return Usuario
     */
    public function setApellidos($apellidos) {
        $this->apellidos = $apellidos;

        return $this;
    }

    /**
     * Get apellidos
     *
     * @return string 
     */
    public function getApellidos() {
        return $this->apellidos;
    }

    /**
     * Set email
     *
     * @param string $email
     * @return Usuario
     */
    public function setEmail($email) {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string 
     */
    public function getEmail() {
        return $this->email;
    }

    /**
     * Set telefono
     *
     * @param integer $telefono
     * @return Usuario
     */
    public function setTelefono($telefono) {
        $this->telefono = $telefono;

        return $this;
    }

    /**
     * Get telefono
     *
     * @return integer 
     */
    public function getTelefono() {
        return $this->telefono;
    }

    /**
     * Set password
     *
     * @param string $password
     * @return Usuario
     */
    public function setPassword($password) {
        $this->password = $password;

        return $this;
    }

    /**
     * Get password
     *
     * @return string 
     */
    public function getPassword() {
        return $this->password;
    }

    /**
     * Set role
     *
     * @param string $role
     * @return Usuario
     */
    public function setRole($role) {
        $this->role = $role;

        return $this;
    }

    /**
     * Get role
     *
     * @return string 
     */
    public function getRole() {
        return $this->role;
    }

    /**
     * Set isActive
     *
     * @param boolean $isActive
     * @return Usuario
     */
    public function setIsActive($isActive) {
        $this->isActive = $isActive;

        return $this;
    }

    /**
     * Get isActive
     *
     * @return boolean 
     */
    public function getIsActive() {
        return $this->isActive;
    }

    /**
     * Set ultimaConexion
     *
     * @param \DateTime $ultimaConexion
     * @return Usuario
     */
    public function setUltimaConexion($ultimaConexion) {
        $this->ultimaConexion = $ultimaConexion;

        return $this;
    }

    /**
     * Get ultimaConexion
     *
     * @return \DateTime 
     */
    public function getUltimaConexion() {
        return $this->ultimaConexion;
    }

    public function eraseCredentials() {
        
    }

    public function getRoles() {
        return array($this->role);
    }

    public function getSalt() {
        return null;
    }

    public function getUsername() {
        
    }

    /** @see \Serializable::serialize() */
    public function serialize() {
        return serialize(array(
            $this->id,
            $this->usuario,
            $this->password,
            $this->isActive
        ));
    }

    /** @see \Serializable::unserialize() */
    public function unserialize($serialized) {
        list (
                $this->id,
                $this->usuario,
                $this->password,
                $this->isActive
                ) = unserialize($serialized);
    }

    public function isEnabled() {
        return $this->isActive;
    }

    public function isAccountNonExpired() {
        return true;
    }

    public function isAccountNonLocked() {
        return true;
    }

    public function isCredentialsNonExpired() {
        return true;
    }



}
