<?php

namespace AppBundle\Entity;

class Car
{
    protected $id;
    protected $name;
    protected $manufacturer;
    protected $colour;
    protected $airConditioning;
    protected $centralLocking;
    protected $created;
    protected $updated;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return mixed
     */
    public function getManufacturer()
    {
        return $this->manufacturer;
    }

    /**
     * @param mixed $manufacturer
     */
    public function setManufacturer($manufacturer)
    {
        $this->manufacturer = $manufacturer;
    }

    /**
     * @return mixed
     */
    public function getColour()
    {
        return $this->colour;
    }

    /**
     * @param mixed $colour
     */
    public function setColour($colour)
    {
        $this->colour = $colour;
    }

    /**
     * @return mixed
     */
    public function getAirConditioning()
    {
        return $this->airConditioning;
    }

    /**
     * @param mixed $airConditioning
     */
    public function setAirConditioning($airConditioning)
    {
        $this->airConditioning = $airConditioning;
    }

    /**
     * @return mixed
     */
    public function getCentralLocking()
    {
        return $this->centralLocking;
    }

    /**
     * @param mixed $centralLocking
     */
    public function setCentralLocking($centralLocking)
    {
        $this->centralLocking = $centralLocking;
    }

    /**
     * @return mixed
     */
    public function getCreated()
    {
        return $this->created;
    }

    /**
     * @param mixed $created
     */
    public function setCreated($created)
    {
        $this->created = $created;
    }

    /**
     * @return mixed
     */
    public function getUpdated()
    {
        return $this->updated;
    }

    /**
     * @param mixed $updated
     */
    public function setUpdated($updated)
    {
        $this->updated = $updated;
    }
}
