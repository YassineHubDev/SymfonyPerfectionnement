<?php

namespace App\Entity;

use Cocur\Slugify\Slugify;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Validator\Constraints as Assert;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ProductRepository")
 * @ORM\HasLifecycleCallbacks
 * @Vich\Uploadable
 */
class Product
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=128)
     * @Assert\Length(
     *     min=4,
     *     max=128
     *)
     */
    private $name;

    /**
     * @ORM\Column(type="text")
     * @Assert\Length(
     *     min=25,
     *     max=4000
     * )
     */
    private $Description;


    /**
     * @ORM\Column(type="decimal", precision=9, scale=2)
     * @Assert\Type(type="float")
     * @Assert\Range(
     *     min=0,
     *     max=9999999.99
     * )
     */
    private $Price;

    /**
     * @ORM\Column(type="integer")
     */
    private $nbViews;

    /**
     * @ORM\Column(type="datetime")
     */
    private $dateCreation;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $dateModification;

    /**
     * @ORM\Column(type="boolean")
     */
    private $etatPublication;

    /**
     * @ORM\Column(type="string", length=128)
     */
    private $imageName;

    /**
     * @var File
     * @Vich\UploadableField(mapping="miniature_produit",
     * fileNameProperty="imageName")
     */
    private $imageFile;


    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Tag", inversedBy="products")
     */
    private $tags;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Category", inversedBy="products")
     * @ORM\JoinColumn(nullable=false)
     */
    private $category;

    /**
     * @ORM\Column(type="string", length=128, nullable=false, unique=true)
     */
    private $slug;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="no")
     * @ORM\JoinColumn(nullable=false)
     */
    private $publisher;

    /**
     * @return File
     */
    public function getImageFile(): ?File
    {
        return $this->imageFile;
    }

    /**
     * @param File $imageFile
     */
    public function setImageFile(?File $imageFile = null): void
    {
        if (!is_null($imageFile)) {
            $this->dateModification = new \DateTimeImmutable();
        }
        $this->imageFile = $imageFile;
    }

    public function __construct()
    {
        $this->tags = new ArrayCollection();

        $this->nbViews = 0;
        $this->dateCreation = new \DateTime();
    }

    /**
     * @ORM\PreFlush
     */
    public function initCreatedAt()
    {

        $this->dateCreation = new \DateTime();
        $this->updateSlug();
    }
    /**
     * @ORM\PrePersist()
     */
    public function ffff()
    {
        $this->dateCreation = new \DateTime();
        $this->updateSlug();
    }
    /**
     * ORM\PreUpdate
     */
    public function refresh()
    {
        $this->dateModification = new \DateTime();
    }

    /**
     * Met à jour le slug par rapport au name
     * @return Product
     */
    public function updateSlug(): self
    {
        //On récupère le slugger
        $slugify = new Slugify();
        //On utilise le slugger...
        //...sur la name
        //...pour mettre à jour le slug
        $this->slug = $slugify->slugify($this->name);

        //Pour le chainage
        return $this;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {

        $this->name = $name;
        $this->updateSlug();

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->Description;
    }

    public function setDescription(string $Description): self
    {
        $this->Description = $Description;

        return $this;
    }

    public function getPrice()
    {
        return $this->Price;
    }

    public function setPrice($Price): self
    {
        $this->Price = $Price;

        return $this;
    }

    public function getNbViews(): ?int
    {
        return $this->nbViews;
    }

    public function setNbViews(int $nbViews): self
    {
        $this->nbViews = $nbViews;

        return $this;
    }

    public function getDateCreation(): ?\DateTimeInterface
    {
        return $this->dateCreation;
    }

    public function setDateCreation(\DateTimeInterface $dateCreation): self
    {
        $this->dateCreation = $dateCreation;

        return $this;
    }

    public function getDateModification(): ?\DateTimeInterface
    {
        return $this->dateModification;
    }

    public function setDateModification(\DateTimeInterface $dateModification): self
    {
        $this->dateModification = $dateModification;

        return $this;
    }

    public function getEtatPublication(): ?bool
    {
        return $this->etatPublication;
    }

    public function setEtatPublication(bool $etatPublication): self
    {
        $this->etatPublication = $etatPublication;

        return $this;
    }

    public function getImageName(): ?string
    {
        return $this->imageName;
    }

    public function setImageName(?string $imageName = null): self
    {
        $this->imageName = $imageName;

        return $this;
    }

    /**
     * @return Collection|Tag[]
     */
    public function getTags(): Collection
    {
        return $this->tags;
    }

    public function addTag(Tag $tag): self
    {
        if (!$this->tags->contains($tag)) {
            $this->tags[] = $tag;
        }

        return $this;
    }

    public function removeTag(Tag $tag): self
    {
        if ($this->tags->contains($tag)) {
            $this->tags->removeElement($tag);
        }

        return $this;
    }

    /**
     * @return mixed
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * @param mixed $category
     */
    public function setCategory($category): void
    {
        $this->category = $category;
    }


    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(?string $slug): self
    {
        $this->slug = $slug;

        return $this;
    }

    public function getPublisher(): ?User
    {
        return $this->publisher;
    }

    public function setPublisher(?User $publisher): self
    {
        $this->publisher = $publisher;

        return $this;
    }

    public function __toString()
    {
        return $this->name;
    }
}
