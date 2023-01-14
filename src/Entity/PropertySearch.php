<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;

class PropertySearch
{
    /**
     * @var int|null
     */
    private $maxPrice;

    /**
     * @var int|null
     * @Assert\Range(min=10, max=400)
     */
    private $minSurface;

    /**
     * @var ArrayCollection
     */
    private $options;

    #[Assert\Length(min: 0, max: 50)]
    private $city;

    #[Assert\Range(min: 0, max: 200)]
    private $distance;

    private $lng;

    private $lat;

    /**
     * @param int|null $maxPrice
     * @return PropertySearch
     */
    public function __construct()
    {
        $this->options = new ArrayCollection();
    }

    public function setMaxPrice(int $maxprice): PropertySearch
    {
        $this->maxPrice = $maxprice;
        return $this;
    }

    /**
     * @return int|null
     */
    public function getMaxPrice(): ?int
    {
        return $this->maxPrice;
    }

    /**
     * @param int|null $maxPrice
     * @return PropertySearch
     */
    public function setMinSurface(int $minSurface): PropertySearch
    {
        $this->minSurface = $minSurface;
        return $this;
    }

    /**
     * @return int|null
     */
    public function getMinSurface(): ?int
    {
        return $this->minSurface;
    }

    /**
     * @param ArrayCollection
     */
    public function setOptions(ArrayCollection $options): void
    {   
        $this->options = $options;
    }

    /**
     * @return ArrayCollection
     */
    public function getOptions(): ArrayCollection
    {
        return $this->options;
    }

    public function setCity($city): void
    {   
        $this->city = $city;
    }

    public function getCity()
    {
        return $this->city;
    }

    public function setDistance($distance): void
    {   
        $this->distance = $distance;
    }

    public function getDistance()
    {
        return $this->distance;
    }

    public function setLng($lng): void
    {   
        $this->lng = $lng;
    }

    public function getLng()
    {
        return $this->lng;
    }

    public function setLat($lat): void
    {   
        $this->lat = $lat;
    }

    public function getLat()
    {
        return $this->lat;
    }
}