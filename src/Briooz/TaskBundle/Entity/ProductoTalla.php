<?php

namespace Briooz\TaskBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ProductoTalla
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Briooz\TaskBundle\Entity\ProductoTallaRepository")
 */
class ProductoTalla {

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="Briooz\TaskBundle\Entity\Producto", inversedBy="producto_talla")
     * @ORM\JoinColumn(name="producto_id", referencedColumnName="id")
     * @var int
     */
    private $producto;

    /**
     * @ORM\ManyToOne(targetEntity="Briooz\TaskBundle\Entity\Talla", inversedBy="producto_talla")
     * @ORM\JoinColumn(name="talla_id", referencedColumnName="id")
     * @var int
     */
    private $talla;

    /**
     * @var integer
     *
     * @ORM\Column(name="cantidad", type="integer")
     */
    private $cantidad;

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId() {
        return $this->id;
    }

    /**
     * Set producto
     * @param int $producto
     * @return ProductoTalla
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
     * Set talla
     * @param int $talla
     * @return ProductoTalla
     */
    public function setTalla($talla) {
        $this->talla = $talla;

        return $this;
    }

    /**
     * Get talla
     * @return int
     */
    public function getTalla() {
        return $this->talla;
    }

    /**
     * Set cantidad
     *
     * @param integer $cantidad
     * @return Producto
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

}
