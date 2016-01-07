<?php

namespace AppBundle\Hydrator;

use AppBundle\Entity\Car as CarEntity;

class Car
{
    public function hydrate(CarEntity $entity, $data)
    {
        if (isset($data['name'])) {
            $entity->setName($data['name']);
        }
        if (isset($data['manufacturer'])) {
            $entity->setManufacturer($data['manufacturer']);
        }
        if (isset($data['colour'])) {
            $entity->setColour($data['colour']);
        }
        if (isset($data['airConditioning'])) {
            $entity->setAirConditioning($data['airConditioning']);
        }
        if (isset($data['centralLocking'])) {
            $entity->setCentralLocking($data['centralLocking']);
        }
        if (isset($data['created'])) {
            $entity->setCreated($data['created']);
        }
        if (isset($data['updated'])) {
            $entity->setUpdated($data['updated']);
        }
    }

    public function extract(CarEntity $entity)
    {
        $data = [];

        $data['id']              = $entity->getId();
        $data['name']            = $entity->getName();
        $data['manufacturer']    = $entity->getManufacturer();
        $data['colour']          = $entity->getColour();
        $data['airConditioning'] = $entity->getAirConditioning();
        $data['centralLocking']  = $entity->getCentralLocking();
        $data['created']         = $entity->getCreated();
        $data['updated']         = $entity->getUpdated();

        return $data;
    }
}
