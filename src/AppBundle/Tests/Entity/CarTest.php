<?php

namespace AppBundle\Tests\Entity;

use AppBundle\Entity\Car;

class CarTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @return Car
     */
    public function getCar()
    {
        return new Car();
    }

    public function testSetName()
    {
        $car  = $this->getCar();
        $name = 'polo';

        $car->setName($name);
        $this->assertEquals($name, $car->getName());
    }

}
