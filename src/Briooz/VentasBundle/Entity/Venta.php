<?php

namespace Briooz\VentasBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Venta
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Briooz\VentasBundle\Entity\VentaRepository")
 */
class Venta {

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var float
     *
     * @ORM\Column(name="descuentos", type="float" ,nullable=true)
     */
    private $descuentos;

    /**
     * @var float
     *
     * @ORM\Column(name="total", type="float",nullable=true)
     */
    private $total;

    /**
     * @var float
     *
     * @ORM\Column(name="subtotal", type="float",nullable=true)
     */
    private $subtotal;

    /**
     * @var float
     *
     * @ORM\Column(name="iva", type="float",nullable=true)
     */
    private $iva;
    
     /**
     * @var integer
     *
     * @ORM\Column(name="factura", type="string",length=50,nullable=true)
     */
    private $factura;

    /**
     * @var float
     *
     * @ORM\Column(name="descuentofijo", type="float",nullable=true)
     */
    private $descuentofijo;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fecha", type="date",nullable=true)
     */
    private $fecha;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="hora", type="time",nullable=true)
     */
    private $hora;

    /**
     * @var integer
     *
     * @ORM\Column(name="cantproductos", type="integer",nullable=true)
     */
    private $cantproductos;

    /**
     * @ORM\ManyToOne(targetEntity="Briooz\TaskBundle\Entity\Cliente", inversedBy="venta")
     * @ORM\JoinColumn(name="cliente_id", referencedColumnName="id")
     * @var int
     */
    private $cliente;

    /**
     * @ORM\ManyToOne(targetEntity="Briooz\TaskBundle\Entity\Usuario", inversedBy="venta")
     * @ORM\JoinColumn(name="usuario_id", referencedColumnName="id")
     * @var int
     */
    private $usuario;

    /**
     * @ORM\OneToMany(targetEntity="Briooz\TaskBundle\Entity\VentaProducto", mappedBy="venta")
     * @var int
     */
    protected $venta_producto;
    
    /**
     * @ORM\OneToMany(targetEntity="Briooz\VentasBundle\Entity\VentaFormaPago", mappedBy="venta")
     * @var int
     */
    protected $venta_formapago;

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId() {
        return $this->id;
    }

    /**
     * Set descuentos
     *
     * @param float $descuentos
     * @return Venta
     */
    public function setDescuentos($descuentos) {
        $this->descuentos = $descuentos;

        return $this;
    }

    /**
     * Get descuentos
     *
     * @return float 
     */
    public function getDescuentos() {
        return $this->descuentos;
    }

    /**
     * Set total
     *
     * @param float $total
     * @return Venta
     */
    public function setTotal($total) {
        $this->total = $total;

        return $this;
    }

    /**
     * Get total
     *
     * @return float 
     */
    public function getTotal() {
        return $this->total;
    }

    /**
     * Set fecha
     *
     * @param \DateTime $fecha
     * @return Venta
     */
    public function setFecha($fecha) {
        $this->fecha =new \DateTime($fecha);

        return $this;
    }

    /**
     * Get fecha
     *
     * @return \DateTime 
     */
    public function getFecha() {
        return $this->fecha;
    }

    /**
     * Set hora
     *
     * @param \DateTime $hora
     * @return Venta
     */
    public function setHora($hora) {
        $this->hora = new \DateTime($hora);

        return $this;
    }

    /**
     * Get hora
     *
     * @return \DateTime 
     */
    public function getHora() {
        return $this->hora;
    }

    /**
     * Set cantproductos
     *
     * @param integer $cantproductos
     * @return Venta
     */
    public function setCantproductos($cantproductos) {
        $this->cantproductos = $cantproductos;

        return $this;
    }

    /**
     * Get cantproductos
     *
     * @return integer 
     */
    public function getCantproductos() {
        return $this->cantproductos;
    }

    /**
     * Set usuario
     * @param int $usuario
     * @return Venta
     */
    public function setUsuario($usuario) {
        $this->usuario = $usuario;

        return $this;
    }

    /**
     * Get usuario
     * @return int
     */
    public function getUsuario() {
        return $this->usuario;
    }

    /**
     * Set cliente
     * @param int $cliente
     * @return Venta
     */
    public function setCliente($cliente) {
        $this->cliente = $cliente;

        return $this;
    }

    /**
     * Get cliente
     * @return int
     */
    public function getCliente() {
        return $this->cliente;
    }

    /**
     * Set subtotal
     *
     * @param float $subtotal
     * @return Venta
     */
    public function setSubTotal($subtotal) {
        $this->subtotal = $subtotal;

        return $this;
    }

    /**
     * Get subtotal
     *
     * @return float 
     */
    public function getSubTotal() {
        return $this->subtotal;
    }

    /**
     * Set iva
     *
     * @param float $iva
     * @return Venta
     */
    public function setIva($iva) {
        $this->iva = $iva;

        return $this;
    }

    /**
     * Get iva
     *
     * @return float 
     */
    public function getIva() {
        return $this->iva;
    }

    /**
     * Set descuentofijo
     *
     * @param float $descuentofijo
     * @return Venta
     */
    public function setDescuentoFijo($descuentofijo) {
        $this->descuentofijo = $descuentofijo;

        return $this;
    }

    /**
     * Get descuentofijova
     *
     * @return float 
     */
    public function getDescuentoFijo() {
        return $this->descuentofijo;
    }
    
     /**
     * Set factura
     *
     * @param float $factura
     * @return Venta
     */
    public function setNoFactura($factura) {
        $this->factura = $factura;

        return $this;
    }

    /**
     * Get factura
     *
     * @return integer 
     */
    public function getNoFactura() {
        return $this->factura;
    }

}
