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
        $hydrator     = new Hydrator();
        $now          = new \DateTime();

        $hydrator->hydrate($this->car, [
            'name'            => 'polo',
            'manufacturer'    => 'vw',
            'colour'          => 'red',
            'airConditioning' => true,
            'centralLocking'  => false,
            'created'         => $now,
            'updated'         => $now,
        ]);

        $this->em->persist($this->car);
        $this->em->flush();
    }

    public function teardown()
    {
        $this->em->remove($this->car);
        $this->em->flush();
        $this->em->close();
    }

    public function testEditSubmit()
    {
        $this->client->request('POST', '/car/' . $this->car->getId());


    }
}