<?php

namespace AppBundle\Controller;

use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\Annotations\View;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

class DefaultController extends FOSRestController
{
    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function getHotelsAvailableAction(Request $request)
    {
        $checkIn = $request->query->get('checkIn');
        $checkOut = $request->query->get('checkOut');
        $pax = (int)$request->query->get('pax');

        $checkInDate = \DateTime::createFromFormat('Y-m-d', $checkIn);
        $checkOutDate = \DateTime::createFromFormat('Y-m-d', $checkOut);

        if (!$checkOutDate || !$checkInDate || !$pax) {
            return new JsonResponse([
                'error' => 400,
                'message' => 'Bad request'
            ]);
        }

        $checkInDate->setTime(0, 0, 0);
        $checkOutDate->setTime(0, 0, 0);

        $inventories = $this->getInventories($checkInDate, $checkOutDate);

        $data = [];

        foreach ($inventories as $inventory) {
            $roomCode = $inventory['roomCode'];
            $maxPax = $inventory['maxPax'];
            $allotment = $inventory['allotment'];

            $data[$roomCode] = $data[$roomCode] ?? 0;

            if ($maxPax < $pax || $allotment < 1) {
                $data[$roomCode] = null;
            }

            if ($data[$roomCode] !== null) {
                $price = $inventory['price'];
                $discount = $inventory['discount'];

                if ($discount) {
                    $price = $price - ($price / 100 * $discount);
                }

                $data[$roomCode] += $price;
            }
        }

        $result = [];
        foreach ($data as $key => $value) {
            if ($value !== null) {
                $result[] = [
                    'roomCode' => $key,
                    'price' => $value
                ];
            }
        }

        $view = $this->view($result, 200);
        return $this->handleView($view);
    }

    /**
     * @param \DateTime $checkInDate
     * @param \DateTime $checkOutDate
     * @return mixed
     */
    private function getInventories(\DateTime $checkInDate, \DateTime $checkOutDate)
    {
        return $this->getDoctrine()->getRepository('AppBundle:Inventories')
            ->createQueryBuilder('i')
            ->where('i.date >= :checkIn')
            ->andWhere('i.date < :checkOut')
            ->setParameter('checkIn', $checkInDate)
            ->setParameter('checkOut', $checkOutDate)
            ->getQuery()
            ->getArrayResult();
    }
}
