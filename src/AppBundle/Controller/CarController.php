<?php

namespace AppBundle\Controller;

use AppBundle\Hydrator\Car as Hydrator;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Validator\Constraints\DateTime;

/**
 * Class CarController
 *
 * @package AppBundle\Controller
 */
class CarController extends \Symfony\Bundle\FrameworkBundle\Controller\Controller
{
    /**
     * List action.
     *
     * @param \Symfony\Component\HttpFoundation\Request $request
     *  Request.
     *
     * @return \Symfony\Component\HttpFoundation\Response
     *  Response.
     */
    public function listAction(Request $request)
    {
        $results  = $this->getDoctrine()->getRepository('AppBundle\Entity\Car')->findAll();
        $cars     = [];
        $hydrator = new Hydrator();

        foreach ($results as $result) {
            $car                    = $hydrator->extract($result);
            $car['name']            = ucfirst($car['name']);
            $car['manufacturer']    = ucfirst($car['manufacturer']);
            $car['airConditioning'] = $car['airConditioning'] ? 'Yes' : 'No';
            $car['centralLocking']  = $car['centralLocking'] ? 'Yes' : 'No';

            $cars[] = $car;
        }

        $html = $this->get('templating')->render('AppBundle::list.html.twig', ['cars' => $cars]);

        return new Response($html);
    }

    /**
     * @param \Symfony\Component\HttpFoundation\Request $request
     *  Request.
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function editAction(Request $request, $id)
    {
        $car      = $this->getCarOrFail($id);
        $hydrator = new Hydrator();

        $html = $this->get('templating')->render('AppBundle::edit.html.twig', ['car' => $hydrator->extract($car)]);

        return new Response($html);
    }

    /**
     * @param \Symfony\Component\HttpFoundation\Request $request
     *  Request.
     * @param integer $id
     *  Car identifier.
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function editSubmitAction(Request $request, $id)
    {
        $data     = $request->request->all();
        $car      = $this->getCarOrFail($id);
        $hydrator = new Hydrator();
        $em       = $this->getDoctrine()->getManager();

        $hydrator->hydrate($car, $data);
        $car->setUpdated(new \DateTime());

        $em->persist($car);
        $em->flush();

        return $this->redirectToRoute('app_home');
    }

    /**
     *
     */
    public function createAction()
    {

    }

    public function createSubmitAction()
    {

    }

    /**
     * Fetches a specified car entity, or throws 404 if not found.
     *
     * @param integer $id
     *  Car identifier.
     *
     * @return \AppBundle\Entity\Car
     *  Car.
     */
    public function getCarOrFail($id)
    {
        $car = $this->getDoctrine()->getRepository('AppBundle\Entity\Car')->find($id);

        if (!$car) {
            throw $this->createNotFoundException('Car not found.');
        }

        return $car;
    }
}
