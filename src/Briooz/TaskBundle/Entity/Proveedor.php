<?php

namespace Briooz\TaskBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Proveedor
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Briooz\TaskBundle\Entity\ProveedorRepository")
 */
class Proveedor
{
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
     * @ORM\Column(name="codigo", type="string", length=255)
     */
    private $codigo;

    /**
     * @var string
     *
     * @ORM\Column(name="descripcion", type="text",nullable=true)
     */
    private $descripcion;

    /**
     * @var string
     *
     * @ORM\Column(name="nombres", type="string", length=255,nullable=true)
     */
    private $nombres;
    
    /**
     * @var string
     *
     * @ORM\Column(name="empresa", type="string", length=255,nullable=false)
     */
    private $empresa;

    /**
     * @var string
     *
     * @ORM\Column(name="apellidos", type="string", length=255,nullable=true)
     */
    private $apellidos;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=255,nullable=true)
     */
    private $email;

    /**
     * @var string
     *
     * @ORM\Column(name="telefono", type="string", length=255,nullable=true)
     */
    private $telefono;

    /**
     * @var string
     *
     * @ORM\Column(name="celular", type="string", length=255,nullable=true)
     */
    private $celular;
    
    /**
     * @ORM\OneToMany(targetEntity="Briooz\TaskBundle\Entity\Producto", mappedBy="proveedor")
     * @var int
     */
    protected $producto;
    
        
    /**
     * @ORM\OneToMany(targetEntity="Briooz\VentasBundle\Entity\Compra", mappedBy="proveedor")
     * @var int
     */
    protected $compra;


    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set codigo
     *
     * @param string $codigo
     * @return Proveedor
     */
    public function setCodigo($codigo)
    {
        $this->codigo = $codigo;

        return $this;
    }

    /**
     * Get codigo
     *
     * @return string 
     */
    public function getCodigo()
    {
        return $this->codigo;
    }

    /**
     * Set descripcion
     *
     * @param string $descripcion
     * @return Proveedor
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

    /**
     * Set nombres
     *
     * @param string $nombres
     * @return Proveedor
     */
    public function setNombres($nombres)
    {
        $this->nombres = $nombres;

        return $this;
    }

    /**
     * Get nombres
     *
     * @return string 
     */
    public function getNombres()
    {
        return $this->nombres;
    }

    /**
     * Set apellidos
     *
     * @param string $apellidos
     * @return Proveedor
     */
    public function setApellidos($apellidos)
    {
        $this->apellidos = $apellidos;

        return $this;
    }

    /**
     * Get apellidos
     *
     * @return string 
     */
    public function getApellidos()
    {
        return $this->apellidos;
    }

    /**
     * Set email
     *
     * @param string $email
     * @return Proveedor
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string 
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set telefono
     *
     * @param string $telefono
     * @return Proveedor
     */
    public function setTelefono($telefono)
    {
        $this->telefono = $telefono;

        return $this;
    }

    /**
     * Get telefono
     *
     * @return string 
     */
    public function getTelefono()
    {
        return $this->telefono;
    }

    /**
     * Set celular
     *
     * @param string $celular
     * @return Proveedor
     */
    public function setCelular($celular)
    {
        $this->celular = $celular;

        return $this;
    }

    /**
     * Get celular
     *
     * @return string 
     */
    public function getCelular()
    {
        return $this->celular;
    }
    
    
    /**
     * Set empresa
     *
     * @param string $empresa
     * @return Proveedor
     */
    public function setEmpresa($empresa)
    {
        $this->empresa = $empresa;

        return $this;
    }

    /**
     * Get empresa
     *
     * @return string 
     */
    public function getEmpresa()
    {
        return $this->empresa;
    }
    
}
