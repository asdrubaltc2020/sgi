<?php

namespace Briooz\TaskBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Modelo
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Briooz\TaskBundle\Entity\ModeloRepository")
 */
class Modelo
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
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="descripcion", type="string", length=255 , nullable=true)
     */
    private $descripcion;
    
    /**
     * @var integer
     *
     * @ORM\Column(name="categoria", type="integer")
     */
    private $categoria;
    
        /**
     * @ORM\OneToMany(targetEntity="Briooz\TaskBundle\Entity\Producto", mappedBy="modelo")
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
     * @return Modelo
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
     * Set categoria
     * @param int $categoria
     * @return Modelo
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
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }


    
}
