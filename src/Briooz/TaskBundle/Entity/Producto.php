<?php

namespace Briooz\TaskBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Producto
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Briooz\TaskBundle\Entity\ProductoRepository")
 */
class Producto {

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
     * @ORM\Column(name="codigo_interno", type="string", length=255)
     */
    private $codigoInterno;

    /**
     * @var string
     *
     * @ORM\Column(name="codigo_proveedor", type="string", length=255)
     */
    private $codigoProveedor;

    /**
     * @var string
     *
     * @ORM\Column(name="detalle", type="text")
     */
    private $detalle;

    /**
     * @var integer
     *
     * @ORM\Column(name="total", type="integer")
     */
    private $total;

    /**
     * @var integer
     *
     * @ORM\Column(name="minimo", type="integer")
     */
    private $minimo;

    /**
     * @var integer
     *
     * @ORM\Column(name="maximo", type="integer")
     */
    private $maximo;

    /**
     * @var string
     *
     * @ORM\Column(name="calificacion", type="string", length=3,nullable=true)
     */
    private $calificacion;

    /**
     * @var string
     *
     * @ORM\Column(name="fila", type="string", length=50,nullable=true)
     */
    private $fila;

    /**
     * @var float
     *
     * @ORM\Column(name="precio", type="float")
     */
    private $precio;

    /**
     * @var float
     *
     * @ORM\Column(name="pvp", type="float")
     */
    private $pvp;

    /**
     * @ORM\ManyToOne(targetEntity="Briooz\TaskBundle\Entity\Proveedor", inversedBy="producto")
     * @ORM\JoinColumn(name="proveedor_id", referencedColumnName="id")
     * @var int
     */
    private $proveedor;

    /**
     * @ORM\ManyToOne(targetEntity="Briooz\TaskBundle\Entity\Color", inversedBy="producto")
     * @ORM\JoinColumn(name="color_id", referencedColumnName="id")
     * @var int
     */
    private $color;

    /**
     * @ORM\ManyToOne(targetEntity="Briooz\TaskBundle\Entity\Modelo", inversedBy="producto")
     * @ORM\JoinColumn(name="modelo_id", referencedColumnName="id")
     * @var int
     */
    private $modelo;

    /**
     * @ORM\ManyToOne(targetEntity="Briooz\TaskBundle\Entity\Taco", inversedBy="producto")
     * @ORM\JoinColumn(name="taco_id", referencedColumnName="id")
     * @var int
     */
    private $taco;

    /**
     * @ORM\ManyToOne(targetEntity="Briooz\TaskBundle\Entity\Bodega", inversedBy="producto")
     * @ORM\JoinColumn(name="bodega_id", referencedColumnName="id")
     * @var int
     */
    private $bodega;

    /**
     * @ORM\ManyToOne(targetEntity="Briooz\TaskBundle\Entity\Categoria", inversedBy="producto")
     * @ORM\JoinColumn(name="categoria_id", referencedColumnName="id")
     * @var int
     */
    private $categoria;

    /**
     * @ORM\ManyToOne(targetEntity="Briooz\VentasBundle\Entity\Compra", inversedBy="producto")
     * @ORM\JoinColumn(name="compra_id", referencedColumnName="id")
     * @var int
     */
    private $compra;

    /**
     * @ORM\ManyToOne(targetEntity="Briooz\TaskBundle\Entity\EstadoProducto", inversedBy="producto")
     * @ORM\JoinColumn(name="estado_id", referencedColumnName="id")
     * @var int
     */
    private $estado;

    /**
     * @ORM\OneToMany(targetEntity="Briooz\TaskBundle\Entity\ProductoTalla", mappedBy="producto")
     * @var int
     */
    protected $producto_talla;

    /**
     * @ORM\OneToMany(targetEntity="Briooz\TaskBundle\Entity\VentaProducto", mappedBy="producto")
     * @var int
     */
    protected $venta_producto;

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId() {
        return $this->id;
    }

    /**
     * Set codigoInterno
     *
     * @param string $codigoInterno
     * @return Producto
     */
    public function setCodigoInterno($codigoInterno) {
        $this->codigoInterno = $codigoInterno;

        return $this;
    }

    /**
     * Get codigoInterno
     *
     * @return string 
     */
    public function getCodigoInterno() {
        return $this->codigoInterno;
    }

    /**
     * Set detalle
     *
     * @param string $detalle
     * @return Producto
     */
    public function setDetalle($detalle) {
        $this->detalle = $detalle;

        return $this;
    }

    /**
     * Get detalle
     *
     * @return string 
     */
    public function getDetalle() {
        return $this->detalle;
    }

    /**
     * Set total
     *
     * @param integer $total
     * @return Producto
     */
    public function setTotal($total) {
        $this->total = $total;

        return $this;
    }

    /**
     * Get total
     *
     * @return integer 
     */
    public function getTotal() {
        return $this->total;
    }

    /**
     * Set fila
     *
     * @param string $fila
     * @return Producto
     */
    public function setFila($fila) {
        $this->fila = $fila;

        return $this;
    }

    /**
     * Get fila
     *
     * @return string 
     */
    public function getFila() {
        return $this->fila;
    }

    /**
     * Set precio
     *
     * @param float $precio
     * @return Producto
     */
    public function setPrecio($precio) {
        $this->precio = $precio;

        return $this;
    }

    /**
     * Get precio
     *
     * @return float 
     */
    public function getPrecio() {
        return $this->precio;
    }

    /**
     * Set pvp
     *
     * @param float $pvp
     * @return Producto
     */
    public function setPvp($pvp) {
        $this->pvp = $pvp;

        return $this;
    }

    /**
     * Get pvp
     *
     * @return float 
     */
    public function getPvp() {
        return $this->pvp;
    }

    /**
     * Set proveedor
     * @param int $proveedor
     * @return Producto
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
     * Set color
     * @param int $color
     * @return Producto
     */
    public function setColor($color) {
        $this->color = $color;

        return $this;
    }

    /**
     * Get color
     * @return int
     */
    public function getColor() {
        return $this->color;
    }

    /**
     * Set modelo
     * @param int $modelo
     * @return Producto
     */
    public function setModelo($modelo) {
        $this->modelo = $modelo;

        return $this;
    }

    /**
     * Get modelo
     * @return int
     */
    public function getModelo() {
        return $this->modelo;
    }

    /**
     * Set taco
     * @param int $taco
     * @return Producto
     */
    public function setTaco($taco) {
        $this->taco = $taco;

        return $this;
    }

    /**
     * Get taco
     * @return int
     */
    public function getTaco() {
        return $this->taco;
    }

    /**
     * Set bodega
     * @param int $bodega
     * @return Producto
     */
    public function setBodega($bodega) {
        $this->bodega = $bodega;

        return $this;
    }

    /**
     * Get bodega
     * @return int
     */
    public function getBodega() {
        return $this->bodega;
    }

    /**
     * Set categoria
     * @param int $categoria
     * @return Producto
     */
    public function setCategoria($categoria) {
        $this->categoria = $categoria;

        return $this;
    }

    /**
     * Get categoria
     * @return int
     */
    public function getCategoria() {
        return $this->categoria;
    }

    /**
     * Set codigoProveedor
     *
     * @param string $codigoInterno
     * @return Producto
     */
    public function setCodigoProveedor($codigoProveedor) {
        $this->codigoProveedor = $codigoProveedor;

        return $this;
    }

    /**
     * Get codigoProveedor
     *
     * @return string 
     */
    public function getCodigoProveedor() {
        return $this->codigoProveedor;
    }

    /**
     * Set compra
     * @param int $compra
     * @return Producto
     */
    public function setCompra($compra) {
        $this->compra = $compra;

        return $this;
    }

    /**
     * Get compra
     * @return int
     */
    public function getCompra() {
        return $this->compra;
    }

    /**
     * Set minimo
     *
     * @param integer $minimo
     * @return Producto
     */
    public function setMinimo($minimo) {
        $this->minimo = $minimo;

        return $this;
    }

    /**
     * Get minimo
     *
     * @return integer 
     */
    public function getMinimo() {
        return $this->minimo;
    }

    /**
     * Set maximo
     *
     * @param integer $maximo
     * @return Producto
     */
    public function setMaximo($maximo) {
        $this->maximo = $maximo;

        return $this;
    }

    /**
     * Get maximo
     *
     * @return integer 
     */
    public function getMaximo() {
        return $this->maximo;
    }

    /**
     * Set calificacion
     *
     * @param string $calificacion
     * @return Producto
     */
    public function setCalificacion($calificacion) {
        $this->calificacion = $calificacion;

        return $this;
    }

    /**
     * Get calificacion
     *
     * @return string 
     */
    public function getCalificacion() {
        return $this->calificacion;
    }

    /**
     * Set estado
     * @param int $estado
     * @return Producto
     */
    public function setEstado($estado) {
        $this->estado = $estado;

        return $this;
    }

    /**
     * Get estado
     * @return int
     */
    public function getEstado() {
        return $this->estado;
    }

}
