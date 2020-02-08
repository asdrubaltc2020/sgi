<?php

namespace Briooz\VentasBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Compra
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Briooz\VentasBundle\Entity\CompraRepository")
 */
class Compra {

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
     * @ORM\Column(name="lote", type="string", length=255)
     */
    private $lote;
    
    /**
     * @var string
     *
     * @ORM\Column(name="factura", type="string", length=255)
     */
    private $factura;

    /**
     * @var integer
     *
     * @ORM\Column(name="items", type="integer")
     */
    private $items;

    /**
     * @var float
     *
     * @ORM\Column(name="subtotal", type="float")
     */
    private $subtotal;

    /**
     * @var float
     *
     * @ORM\Column(name="iva", type="float")
     */
    private $iva;

    /**
     * @var float
     *
     * @ORM\Column(name="total", type="float")
     */
    private $total;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fecha", type="datetime")
     */
    private $fecha;

    /**
     * @ORM\ManyToOne(targetEntity="Briooz\TaskBundle\Entity\Proveedor", inversedBy="compra")
     * @ORM\JoinColumn(name="proveedor_id", referencedColumnName="id")
     * @var int
     */
    private $proveedor;

    /**
     * @ORM\OneToMany(targetEntity="Briooz\TaskBundle\Entity\Producto", mappedBy="compra")
     * @var int
     */
    protected $producto;

    /**
     * @var text
     *
     * @ORM\Column(name="nota", type="text")
     */
    private $nota;

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId() {
        return $this->id;
    }

    /**
     * Set lote
     *
     * @param string $lote
     * @return Compra
     */
    public function setLote($lote) {
        $this->lote = $lote;

        return $this;
    }

    /**
     * Get lote
     *
     * @return string 
     */
    public function getLote() {
        return $this->lote;
    }
    
    /**
     * Set factura
     *
     * @param string $factura
     * @return Compra
     */
    public function setFactura($factura) {
        $this->factura = $factura;

        return $this;
    }

    /**
     * Get factura
     *
     * @return string 
     */
    public function getFactura() {
        return $this->factura;
    }

    /**
     * Set items
     *
     * @param integer $items
     * @return Compra
     */
    public function setItems($items) {
        $this->items = $items;

        return $this;
    }

    /**
     * Get items
     *
     * @return integer 
     */
    public function getItems() {
        return $this->items;
    }

    /**
     * Set subtotal
     *
     * @param float $subtotal
     * @return Compra
     */
    public function setSubtotal($subtotal) {
        $this->subtotal = $subtotal;

        return $this;
    }

    /**
     * Get subtotal
     *
     * @return float 
     */
    public function getSubtotal() {
        return $this->subtotal;
    }

    /**
     * Set iva
     *
     * @param float $iva
     * @return Compra
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
     * Set total
     *
     * @param float $total
     * @return Compra
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
     * @return Compra
     */
    public function setFecha($fecha) {
        $this->fecha =  new \DateTime($fecha);

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
     * Set proveedor
     * @param int $proveedor
     * @return Compra
     */
    public function setProveedor($proveedor) {
        $this->proveedor = $proveedor;

        return $this;
    }

    /**
     * Get proveedor
     * @return int
     */
    public function getProveedor() {
        return $this->proveedor;
    }

    /**
     * @return text
     */
    public function getNota()
    {
        return $this->nota;
    }

    /**
     * @param text $nota
     */
    public function setNota($nota)
    {
        $this->nota = $nota;
    }

}
