<?php

namespace App\Entity;

use App\Repository\PropertyRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Faker\Provider\Image;
use Symfony\Component\String\Slugger\AsciiSlugger as Slugger;
use Symfony\Component\Validator\Constraints as Assert;


#[ORM\Entity(repositoryClass: PropertyRepository::class)]
class Property
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $title = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $description = null;

    #[ORM\Column]
    private ?int $surface = null;

    #[ORM\Column]
    private ?int $rooms = null;

    #[ORM\Column]
    private ?int $bedrooms = null;

    #[ORM\Column]
    private ?int $floor = null;

    #[ORM\Column]
    private ?int $price = null;

    #[ORM\ManyToOne(inversedBy: 'properties')]
    #[ORM\JoinColumn(nullable: false)]
    private ?PropertyHeat $heat = null;

    #[ORM\Column(length: 255)]
    private ?string $city = null;

    #[ORM\Column(length: 255)]
    private ?string $address = null;

    #[ORM\Column]
    private ?int $postal_code = null;

    #[ORM\Column]
    private ?bool $sold = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $created_at = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $updated_at = null;

    #[ORM\ManyToMany(targetEntity: PropertyOptions::class, inversedBy: 'properties')]
    private Collection $options;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $thumb = null;

    #[ORM\OneToMany(mappedBy: 'property', targetEntity: PropertyPicture::class, orphanRemoval: true)]
    private Collection $propertyPictures;

    #[Assert\All([
        new Assert\Image([
            'mimeTypes' => ['image/png','image/jpeg', 'image/webp'],
            'mimeTypesMessage' => 'Seul les images au format PNG, JPG et WEBP sont accépté.',
            'maxSize' => '2M',
            'maxSizeMessage' => 'Le fichier {{ name }} est trop volumineux.'
        ])
    ])]
    private $picturesArray;

    // Scale est le nombre de chiffre aprés la virgule, precision est le nombre total de chiffre
    #[ORM\Column(type: 'float', scale: 4, precision: 6)]
    private ?float $lat = null;

    #[ORM\Column(type: 'float', scale: 4, precision: 7)]
    private ?float $lng = null;

    #[ORM\ManyToOne(inversedBy: 'properties')]
    #[ORM\JoinColumn(nullable: false)]
    private ?PropertyType $propertyType = null;

    public function __construct()
    {
        $this->options = new ArrayCollection();
        $this->created_at = new \DateTimeImmutable();
        $this->propertyPictures = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getSurface(): ?int
    {
        return $this->surface;
    }

    public function setSurface(int $surface): self
    {
        $this->surface = $surface;

        return $this;
    }

    public function getRooms(): ?int
    {
        return $this->rooms;
    }

    public function setRooms(int $rooms): self
    {
        $this->rooms = $rooms;

        return $this;
    }

    public function getBedrooms(): ?int
    {
        return $this->bedrooms;
    }

    public function setBedrooms(int $bedrooms): self
    {
        $this->bedrooms = $bedrooms;

        return $this;
    }

    public function getFloor(): ?int
    {
        return $this->floor;
    }

    public function setFloor(int $floor): self
    {
        $this->floor = $floor;

        return $this;
    }

    public function getPrice(): ?int
    {
        return $this->price;
    }

    public function setPrice(int $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getFormatedPrice(): string
    {
        return number_format($this->price, 0 , '', ' ');
    }

    public function getHeat(): ?PropertyHeat
    {
        return $this->heat;
    }

    public function setHeat(?PropertyHeat $heat): self
    {
        $this->heat = $heat;

        return $this;
    }

    public function getHeatCategory(): string
    {
        return $this->heat->getName();
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setCity(string $city): self
    {
        $this->city = $city;

        return $this;
    }

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress(string $address): self
    {
        $this->address = $address;

        return $this;
    }

    public function getPostalCode(): ?int
    {
        return $this->postal_code;
    }

    public function setPostalCode(int $postal_code): self
    {
        $this->postal_code = $postal_code;

        return $this;
    }

    public function isSold(): ?bool
    {
        return $this->sold;
    }

    public function setSold(bool $sold): self
    {
        $this->sold = $sold;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->created_at;
    }

    public function setCreatedAt(\DateTimeImmutable $created_at): self
    {
        $this->created_at = $created_at;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updated_at;
    }

    public function setUpdatedAt(?\DateTimeInterface $updated_at): self
    {
        $this->updated_at = $updated_at;

        return $this;
    }

    /**
     * @return Collection<int, PropertyOptions>
     */
    public function getOptions(): Collection
    {
        return $this->options;
    }

    public function addOption(PropertyOptions $option): self
    {
        if (!$this->options->contains($option)) {
            $this->options->add($option);
        }

        return $this;
    }

    public function removeOption(PropertyOptions $option): self
    {
        $this->options->removeElement($option);

        return $this;
    }

    public function getSlug()
    {
        $slug = (new Slugger())->slug($this->title);
        return mb_strtolower($slug);
    }

    public function getThumb(): ?string
    {
        return $this->thumb;
    }

    public function setThumb(?string $thumb): self
    {
        $this->thumb = $thumb;

        return $this;
    }

    public function getPicturesArray()
    {
        return $this->picturesArray;
    }

    public function setPicturesArray($picturesArray): self
    {
        $this->picturesArray = $picturesArray;

        return $this;
    }

    /**
     * @return Collection<int, PropertyPicture>
     */
    public function getPropertyPictures(): Collection
    {
        return $this->propertyPictures;
    }

    public function getPropertyPicture(): ?PropertyPicture
    {
        if ($this->getPropertyPictures()->isEmpty()) {
            return null;
        }
        return $this->propertyPictures[0];
    }

    public function addPropertyPicture(PropertyPicture $propertyPicture): self
    {
        if (!$this->propertyPictures->contains($propertyPicture)) {
            $this->propertyPictures->add($propertyPicture);
            $propertyPicture->setProperty($this);
        }

        return $this;
    }

    public function removePropertyPicture(PropertyPicture $propertyPicture): self
    {
        if ($this->propertyPictures->removeElement($propertyPicture)) {
            // set the owning side to null (unless already changed)
            if ($propertyPicture->getProperty() === $this) {
                $propertyPicture->setProperty(null);
            }
        }

        return $this;
    }

    public function getLat(): ?float
    {
        return $this->lat;
    }

    public function setLat(float $lat): self
    {
        $this->lat = $lat;

        return $this;
    }

    public function getLng(): ?float
    {
        return $this->lng;
    }

    public function setLng(float $lng): self
    {
        $this->lng = $lng;

        return $this;
    }

    public function getPropertyType(): ?PropertyType
    {
        return $this->propertyType;
    }

    public function setPropertyType(?PropertyType $propertyType): self
    {
        $this->propertyType = $propertyType;

        return $this;
    }

}
