<?php

namespace AppBundle\Controller;

use AppBundle\Hydrator\Car as Hydrator;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class CarController
 *
 * @package AppBundle\Controller
 */
class CarController extends \Symfony\Bundle\FrameworkBundle\Controller\Controller
{
    /**
     * Renders the list cars page.
     *
     * Route: /
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
     * Renders the edit car page.
     *
     * Route: /car/{id}
     *
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
     * Edit car form submit action.
     *
     * Route: /car/{id}
     *
     * @param \Symfony\Component\HttpFoundation\Request $request
     *  Request.
     * @param integer $id
     *  Car identifier.
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function editSubmitAction(Request $request, $id)
    {
        // Fetch the data, both required for the test to clear.
        $data = (array) $request->getContent();
        $data += $request->request->all();

        // Find the existing car entity.
        $car      = $this->getCarOrFail($id);
        $hydrator = new Hydrator();
        $em       = $this->getDoctrine()->getManager();

        // Hydrate th car entity
        $hydrator->hydrate($car, $data);
        $car->setUpdated(new \DateTime());

        $em->persist($car);
        $em->flush();

        return $this->redirectToRoute('app_home');
    }

    /**
     * Create car form.
     *
     * Route: /create-car
     *
     * @param \Symfony\Component\HttpFoundation\Request $request
     *  Request.
     */
    public function createAction(Request $request)
    {
    }

    /**
     * Create car form submit action.
     *
     * Route: /create-car
     *
     * @param \Symfony\Component\HttpFoundation\Request $request
     *  Request.
     */
    public function createSubmitAction(Request $request)
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
