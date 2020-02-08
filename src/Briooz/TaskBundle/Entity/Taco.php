<?php

namespace Briooz\TaskBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Taco
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Briooz\TaskBundle\Entity\TacoRepository")
 */
class Taco
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
     * @ORM\OneToMany(targetEntity="Briooz\TaskBundle\Entity\Producto", mappedBy="taco")
     * @var int
     */
    protected $producto;

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
     * @return Taco
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
}
