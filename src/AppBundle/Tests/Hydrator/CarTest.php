<?php

namespace AppBundle\Tests\Hydrator;

use AppBundle\Entity\Car;
use AppBundle\Hydrator\Car as Hydrator;

class CarTest extends \PHPUnit_Framework_TestCase
{
    private $data = [];

    public function setup()
    {
        $now        = new \DateTime();
        $this->data = [
            'name'            => 'polo',
            'manufacturer'    => 'vw',
            'colour'          => 'red',
            'airConditioning' => true,
            'centralLocking'  => false,
            'created'         => $now,
            'updated'         => $now,
        ];
    }

    /**
     * @return \AppBundle\Entity\Car
     */
    public function getCar()
    {
        return new Car();
    }

    /**
     * @return \AppBundle\Hydrator\Car
     */
    public function getHydrator()
    {
        return new Hydrator();
    }

    public function testHydrate()
    {
        $car      = $this->getCar();
        $hydrator = $this->getHydrator();

        $hydrator->hydrate($car, $this->data);

        $this->assertEquals($this->data['name'], $car->getName());
        $this->assertEquals($this->data['manufacturer'], $car->getManufacturer());
        $this->assertEquals($this->data['colour'], $car->getColour());
        $this->assertEquals($this->data['airConditioning'], $car->getAirConditioning());
        $this->assertEquals($this->data['centralLocking'], $car->getCentralLocking());
        $this->assertEquals($this->data['created'], $car->getCreated());
        $this->assertEquals($this->data['updated'], $car->getUpdated());
    }

    public function testExtract()
    {
        $car      = $this->getCar();
        $hydrator = $this->getHydrator();

        $hydrator->hydrate($car, $this->data);

        $output = $hydrator->extract($car);

        $this->assertEquals($output['name'], $this->data['name']);
        $this->assertEquals($output['manufacturer'], $this->data['manufacturer']);
        $this->assertEquals($output['colour'], $this->data['colour']);
        $this->assertEquals($output['airConditioning'], $this->data['airConditioning']);
        $this->assertEquals($output['centralLocking'], $this->data['centralLocking']);
        $this->assertEquals($output['created'], $this->data['created']);
        $this->assertEquals($output['updated'], $this->data['updated']);
    }
}
