<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

class DefaultController extends Controller
{
    /**
     * @param Request $request
     * @return JsonResponse
     *
     * @Route("/hotels", name="hotels")
     */
    public function getAction(Request $request)
    {
        $checkIn = $request->query->get('checkIn');
        $checkOut = $request->query->get('checkOut');
        $pax = $request->query->get('pax');

        $checkInDate = new \DateTime($checkIn);
        $checkOutDate = new \DateTime($checkOut);

        if (!$checkOutDate || !$checkInDate || !$pax) {
            return new JsonResponse([
                'error' => 400,
                'message' => 'Bad request'
            ]);
        }

        $inventories = $this->getInventories($checkInDate, $checkOutDate);

        $data = [];

        foreach ($inventories as $inventory) {
            $roomCode = $inventory['roomCode'];
            $maxPax = $inventory['maxPax'];
            $allotment = $inventory['allotment'];

            if (!isset($data[$roomCode])) {
                $data[$roomCode] = 0;
            }

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

        return new JsonResponse($result);
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
