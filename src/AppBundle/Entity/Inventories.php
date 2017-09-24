<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Inventories
 *
 * @ORM\Table(name="inventories")
 * @ORM\Entity
 */
class Inventories
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="room_code", type="string", length=8, nullable=false)
     */
    private $roomCode;

    /**
     * @var integer
     *
     * @ORM\Column(name="allotment", type="integer", nullable=true)
     */
    private $allotment = '0';

    /**
     * @var float
     *
     * @ORM\Column(name="price", type="float", precision=10, scale=0, nullable=false)
     */
    private $price;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="datetime", nullable=true)
     */
    private $date;

    /**
     * @var integer
     *
     * @ORM\Column(name="discount", type="integer", nullable=true)
     */
    private $discount;

    /**
     * @var integer
     *
     * @ORM\Column(name="max_pax", type="integer", nullable=true)
     */
    private $maxPax = '0';



    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set roomCode
     *
     * @param string $roomCode
     *
     * @return Inventories
     */
    public function setRoomCode($roomCode)
    {
        $this->roomCode = $roomCode;

        return $this;
    }

    /**
     * Get roomCode
     *
     * @return string
     */
    public function getRoomCode()
    {
        return $this->roomCode;
    }

    /**
     * Set allotment
     *
     * @param integer $allotment
     *
     * @return Inventories
     */
    public function setAllotment($allotment)
    {
        $this->allotment = $allotment;

        return $this;
    }

    /**
     * Get allotment
     *
     * @return integer
     */
    public function getAllotment()
    {
        return $this->allotment;
    }

    /**
     * Set price
     *
     * @param float $price
     *
     * @return Inventories
     */
    public function setPrice($price)
    {
        $this->price = $price;

        return $this;
    }

    /**
     * Get price
     *
     * @return float
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * Set date
     *
     * @param \DateTime $date
     *
     * @return Inventories
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get date
     *
     * @return \DateTime
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Set discount
     *
     * @param integer $discount
     *
     * @return Inventories
     */
    public function setDiscount($discount)
    {
        $this->discount = $discount;

        return $this;
    }

    /**
     * Get discount
     *
     * @return integer
     */
    public function getDiscount()
    {
        return $this->discount;
    }

    /**
     * Set maxPax
     *
     * @param integer $maxPax
     *
     * @return Inventories
     */
    public function setMaxPax($maxPax)
    {
        $this->maxPax = $maxPax;

        return $this;
    }

    /**
     * Get maxPax
     *
     * @return integer
     */
    public function getMaxPax()
    {
        return $this->maxPax;
    }
}
