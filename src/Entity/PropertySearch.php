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
     */
    private $minPrice;

    /**
     * @var int|null
     * @Assert\Range(min=10, max=400)
     */
    private $minSurface;

    /**
     * @var int|null
     * @Assert\Range(min=10, max=400)
     */
    private $maxSurface;

    /**
     * @var ArrayCollection
     */
    private $options;
    
    /**
     * @var PropertyType|null
     */
    private $typeOfProperty;

    /**
     * @var bool
     */
    private $isInitialized;

    #[Assert\Length(min: 0, max: 50)]
    private $city;

    #[Assert\Range(min: 0, max: 200)]
    private $distance;

    /**
     * @var float|null
     */
    private $lng;

    /**
     * @var float|null
     */
    private $lat;

    /**
     * @param int|null $maxPrice
     * @return PropertySearch
     */
    public function __construct()
    {
        $this->options = new ArrayCollection();
        $this->isInitialized = false ;
    }

    public function setMaxPrice(int $maxprice): PropertySearch
    {
        $this->maxPrice = $maxprice;
        $this->isInitialized = true;
        return $this;
    }

    /**
     * @return int|null
     */
    public function getMaxPrice(): ?int
    {
        return $this->maxPrice;
    }

    public function setMinPrice(int $minprice): PropertySearch
    {
        $this->minPrice = $minprice;
        $this->isInitialized = true;
        return $this;
    }

    /**
     * @return int|null
     */
    public function getMinPrice(): ?int
    {
        return $this->minPrice;
    }

    /**
     * @param int|null $maxPrice
     * @return PropertySearch
     */
    public function setMinSurface(int $minSurface): PropertySearch
    {
        $this->minSurface = $minSurface;
        $this->isInitialized = true;
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
     * @param int|null $maxPrice
     * @return PropertySearch
     */
    public function setMaxSurface(int $maxSurface): PropertySearch
    {
        $this->maxSurface = $maxSurface;
        $this->isInitialized = true;
        return $this;
    }

    /**
     * @return int|null
     */
    public function getMaxSurface(): ?int
    {
        return $this->maxSurface;
    }

    /**
     * @param ArrayCollection
     */
    public function setOptions(ArrayCollection $options): void
    {   
        $this->options = $options;
        $this->isInitialized = true;
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
        $this->isInitialized = true;
    }

    public function getCity()
    {
        return $this->city;
    }

    public function setDistance($distance): void
    {   
        $this->distance = $distance;
        $this->isInitialized = true;
    }

    public function getDistance()
    {
        return $this->distance;
    }

    /**
     * @param float|null
     */
    public function setLng(?float $lng): void
    {   
        $this->lng = $lng;
        $this->isInitialized = true;
    }

    /**
     * @return float|null
     */
    public function getLng(): float|null
    {
        return $this->lng;
    }

    /**
     * @param float|null
     */
    public function setLat(?float $lat): void
    {   
        $this->lat = $lat;
        $this->isInitialized = true;
    }

    /**
     * @return float|null
     */
    public function getLat(): float|null
    {
        return $this->lat;
    }

    /**
     * @param PropertyType
     * @return PropertySearch
     */
    public function setTypeOfProperty(PropertyType $test): PropertySearch
    {
        $this->typeOfProperty = $test;
        $this->isInitialized = true;
        return $this;
    }

    /**
     * @return PropertyType|null
     */
    public function getTypeOfProperty (): ?PropertyType
    {
        return $this->typeOfProperty;
    }

    /**
     * @return bool
     */
    public function getisInitialized(): bool
    {
        return $this->isInitialized;
    }
}