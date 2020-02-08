<?php

namespace Briooz\TaskBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * FormaPago
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Briooz\TaskBundle\Entity\FormaPagoRepository")
 */
class FormaPago
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
     * @ORM\Column(name="descripcion", type="string", length=255)
     */
    private $descripcion;

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
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set descripcion
     *
     * @param string $descripcion
     * @return FormaPago
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
     * Set descuento
     *
     * @param float $descuento
     * @return FormaPago
     */
    public function setDescuento($descuento)
    {
        $this->descuento = $descuento;

        return $this;
    }

    /**
     * Get descuento
     *
     * @return float 
     */
    public function getDescuento()
    {
        return $this->descuento;
    }

    /**
     * Set recargo
     *
     * @param float $recargo
     * @return FormaPago
     */
    public function setRecargo($recargo)
    {
        $this->recargo = $recargo;

        return $this;
    }

    /**
     * Get recargo
     *
     * @return float 
     */
    public function getRecargo()
    {
        return $this->recargo;
    }
}
