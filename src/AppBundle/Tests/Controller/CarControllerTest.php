<?php

namespace AppBundle\Tests\Controller;

use AppBundle\Entity\Car;
use AppBundle\Hydrator\Car as Hydrator;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class CarControllerTest extends WebTestCase
{
    /**
     * @var \Doctrine\ORM\EntityManager
     */
    private $em;

    /**
     * @var \Symfony\Bundle\FrameworkBundle\Client
     */
    private $client;

    /**
     * @var \AppBundle\Entity\Car
     */
    private $car;

    public function setup()
    {
        self::bootKernel();

        $this->em     = static::$kernel->getContainer()->get('doctrine')->getManager();
        $this->client = static::createClient();
        $this->car    = new Car();
    }

    public function teardown()
    {
        $this->em->remove($this->car);
        $this->em->flush();
        $this->em->close();
    }

    /**
     * Test the edit form submit method.
     */
    public function testEditSubmit()
    {
        $now      = new \DateTime();
        $hydrator = new Hydrator();

        // Hydrate the car entity with some example data.
        $hydrator->hydrate($this->car, [
            'name'            => 'polo',
            'manufacturer'    => 'vw',
            'colour'          => 'red',
            'airConditioning' => true,
            'centralLocking'  => false,
            'created'         => $now,
            'updated'         => $now,
        ]);

        // Persist the entity to the database.
        $this->em->persist($this->car);
        $this->em->flush();

        $carId   = $this->car->getId();
        $newData = [
            'name'            => 'astra',
            'manufacturer'    => 'vauxhall',
            'colour'          => 'blue',
            'airConditioning' => false,
            'centralLocking'  => true,
        ];

        // Issue the post request to update the existing car with new data.
        $this->client->request('POST', "/car/$carId", [], [], [], $newData);

        // Reload the car object.
        $car = static::$kernel->getContainer()
            ->get('doctrine')
            ->getRepository('AppBundle\Entity\Car')
            ->find($carId);

        // Test for matching data.
        $this->assertEquals($car->getName(), $newData['name']);
        $this->assertEquals($car->getManufacturer(), $newData['manufacturer']);
        $this->assertEquals($car->getColour(), $newData['colour']);
        $this->assertEquals($car->getAirConditioning(), $newData['airConditioning']);
        $this->assertEquals($car->getCentralLocking(), $newData['centralLocking']);
    }

    /**
     * Test the create form submit method
     */
    public function testCreateSubmit()
    {
    }
}