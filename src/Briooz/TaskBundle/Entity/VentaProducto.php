<?php

namespace Briooz\TaskBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * VentaProducto
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Briooz\TaskBundle\Entity\VentaProductoRepository")
 */
class VentaProducto {

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var integer
     *
     * @ORM\Column(name="cantidad", type="integer")
     */
    private $cantidad;


    /**
     * @ORM\ManyToOne(targetEntity="Briooz\TaskBundle\Entity\Producto", inversedBy="venta_producto")
     * @ORM\JoinColumn(name="producto_id", referencedColumnName="id")
     * @var int
     */
    private $producto;

    /**
     * @ORM\ManyToOne(targetEntity="Briooz\VentasBundle\Entity\Venta", inversedBy="venta_producto")
     * @ORM\JoinColumn(name="venta_id", referencedColumnName="id")
     * @var int
     */
    private $venta;

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId() {
        return $this->id;
    }

    /**
     * Set cantidad
     *
     * @param integer $cantidad
     * @return VentaProducto
     */
    public function setCantidad($cantidad) {
        $this->cantidad = $cantidad;

        return $this;
    }

    /**
     * Get cantidad
     *
     * @return integer 
     */
    public function getCantidad() {
        return $this->cantidad;
    }


    /**
     * Set producto
     * @param int $producto
     * @return VentaProducto
     */
    public function setProducto($producto) {
        $this->producto = $producto;

        return $this;
    }

    /**
     * Get producto
     * @return int
     */
    public function getProducto() {
        return $this->producto;
    }

    /**
     * Set venta
     * @param int $venta
     * @return VentaProducto
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

}
