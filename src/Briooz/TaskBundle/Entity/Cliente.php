<?php

namespace Briooz\TaskBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Cliente
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Briooz\TaskBundle\Entity\ClienteRepository")
 */
class Cliente {

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
     * @ORM\Column(name="nombres", type="string", length=255)
     */
    private $nombres;
    
    /**
     * @var string
     *
     * @ORM\Column(name="nombreepresa", type="string", length=255)
     */
    private $nombreempresa;

    /**
     * @var string
     *
     * @ORM\Column(name="tipocliente", type="string",columnDefinition="ENUM('PERSONA','EMPRESA')" , length=50)
     */
    private $tipocliente;

    /**
     * @var string
     *
     * @ORM\Column(name="apellidos", type="string", length=255)
     */
    private $apellidos;

    /**
     * @var string
     *
     * @ORM\Column(name="ci", type="string", length=11)
     */
    private $ci;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=255)
     */
    private $email;

    /**
     * @var string
     *
     * @ORM\Column(name="celular", type="string", length=11)
     */
    private $celular;

    /**
     * @var string
     *
     * @ORM\Column(name="telefono", type="string", length=255)
     */
    private $telefono;

    /**
     * @var string
     *
     * @ORM\Column(name="direccion", type="text")
     */
    private $direccion;

    /**
     * @var string
     *
     * @ORM\Column(name="razonsocial", type="text")
     */
    private $razonsocial;

    /**
     * @var string
     *
     * @ORM\Column(name="ruc", type="string", length=255)
     */
    private $ruc;

    /**
     * @ORM\OneToMany(targetEntity="Briooz\VentasBundle\Entity\Venta", mappedBy="cliente")
     * @var int
     */
    protected $venta;

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId() {
        return $this->id;
    }

    /**
     * Set nombres
     *
     * @param string $nombres
     * @return Cliente
     */
    public function setNombres($nombres) {
        $this->nombres = $nombres;

        return $this;
    }

    /**
     * Get nombres
     *
     * @return string 
     */
    public function getNombres() {
        return $this->nombres;
    }

    /**
     * Set apellidos
     *
     * @param string $apellidos
     * @return Cliente
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
     * Set ci
     *
     * @param string $ci
     * @return Cliente
     */
    public function setCi($ci) {
        $this->ci = $ci;

        return $this;
    }

    /**
     * Get ci
     *
     * @return string 
     */
    public function getCi() {
        return $this->ci;
    }

    /**
     * Set email
     *
     * @param string $email
     * @return Cliente
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
     * Set celular
     *
     * @param string $celular
     * @return Cliente
     */
    public function setCelular($celular) {
        $this->celular = $celular;

        return $this;
    }

    /**
     * Get celular
     *
     * @return string 
     */
    public function getCelular() {
        return $this->celular;
    }

    /**
     * Set telefono
     *
     * @param string $telefono
     * @return Cliente
     */
    public function setTelefono($telefono) {
        $this->telefono = $telefono;

        return $this;
    }

    /**
     * Get telefono
     *
     * @return string 
     */
    public function getTelefono() {
        return $this->telefono;
    }

    /**
     * Set direccion
     *
     * @param string $direccion
     * @return Cliente
     */
    public function setDireccion($direccion) {
        $this->direccion = $direccion;

        return $this;
    }

    /**
     * Get direccion
     *
     * @return string 
     */
    public function getDireccion() {
        return $this->direccion;
    }

    /**
     * Set ruc
     *
     * @param string $ruc
     * @return Cliente
     */
    public function setRuc($ruc) {
        $this->ruc = $ruc;

        return $this;
    }

    /**
     * Get ruc
     *
     * @return string 
     */
    public function getRuc() {
        return $this->ruc;
    }

    /**
     * Set razonsocial
     *
     * @param string $razonsocial
     * @return Cliente
     */
    public function setRazonSocial($razonsocial) {
        $this->razonsocial = $razonsocial;

        return $this;
    }

    /**
     * Get razonsocial
     *
     * @return string 
     */
    public function getRazonSocial() {
        return $this->razonsocial;
    }

    /**
     * Set tipocliente
     *
     * @param string $tipocliente
     * @return Usuario
     */
    public function setTipoCliente($tipocliente) {
        $this->tipocliente = $tipocliente;

        return $this;
    }

    /**
     * Get tipocliente
     *
     * @return string 
     */
    public function getTipoCliente() {
        return $this->tipocliente;
    }
    
    /**
     * Set nombreempresa
     *
     * @param string $nombreempresa
     * @return Cliente
     */
    public function setNombreEmpresa($nombreempresa) {
        $this->nombreempresa = $nombreempresa;

        return $this;
    }

    /**
     * Get nombreempresa
     *
     * @return string 
     */
    public function getNombreEmpresa() {
        return $this->nombreempresa;
    }

}
