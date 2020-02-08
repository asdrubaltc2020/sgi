<?php

namespace Briooz\VentasBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * VentaFormaPago
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Briooz\VentasBundle\Entity\VentaFormaPagoRepository")
 */
class VentaFormaPago {

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
     * @ORM\Column(name="descuento", type="float")
     */
    private $descuento;

    /**
     * @var float
     *
     * @ORM\Column(name="recargo", type="float")
     */
    private $recargo;

    /**
     * @var float
     *
     * @ORM\Column(name="monto", type="float")
     */
    private $monto;

    /**
     * @ORM\ManyToOne(targetEntity="Briooz\VentasBundle\Entity\Venta", inversedBy="venta_formapago")
     * @ORM\JoinColumn(name="venta_id", referencedColumnName="id")
     * @var int
     */
    private $venta;

    /**
     * @ORM\ManyToOne(targetEntity="Briooz\TaskBundle\Entity\FormaPago", inversedBy="venta_formapago")
     * @ORM\JoinColumn(name="formapago_id", referencedColumnName="id")
     * @var int
     */
    private $forma_pago;

    /**
     * Set venta
     * @param int $venta
     * @return VentaFormaPago
     */
    public function setVenta($venta) {
        $this->venta = $venta;

        return $this;
    }

    /**
     * Get venta
     * @return int
     */
    public function getVenta() {
        return $this->venta;
    }

    /**
     * Set forma_pago
     * @param int $forma_pago
     * @return VentaFormaPago
     */
    public function setFormaPago($forma_pago) {
        $this->forma_pago = $forma_pago;

        return $this;
    }

    /**
     * Get forma_pago
     * @return int
     */
    public function getFormaPago() {
        return $this->forma_pago;
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
     * Set descuento
     *
     * @param float $descuento
     * @return VentaFormaPago
     */
    public function setDescuento($descuento) {
        $this->descuento = $descuento;

        return $this;
    }

    /**
     * Get descuento
     *
     * @return float 
     */
    public function getDescuento() {
        return $this->descuento;
    }

    /**
     * Set recargo
     *
     * @param float $recargo
     * @return VentaFormaPago
     */
    public function setRecargo($recargo) {
        $this->recargo = $recargo;

        return $this;
    }

    /**
     * Get recargo
     *
     * @return float 
     */
    public function getRecargo() {
        return $this->recargo;
    }

    /**
     * Set monto
     *
     * @param float $monto
     * @return VentaFormaPago
     */
    public function setMonto($monto) {
        $this->monto = $monto;

        return $this;
    }

    /**
     * Get monto
     *
     * @return float 
     */
    public function getMonto() {
        return $this->monto;
    }

}
