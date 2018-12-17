<?php

namespace App\Entity;


use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;


use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;

use Vich\UploaderBundle\Entity\File as EmbeddedFile;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * @ORM\Entity(repositoryClass="App\Repository\MenuRepository")
 * @Vich\Uploadable()
 */
class Menu
{

//    use WeightTrait;
//
//    public function weightFilters(): array
//    {
//        return ['event'];
//    }
//
//    public function getParentClass(): string
//    {
//        return Event::class;
//    }
//
//    public function getParent()
//    {
//        return $this->getEvent();
//    }
//
//    public function setParent( $parent ) {
//        $this->setEvent( $parent );
//    }
//
//    public function isFirst() :bool
//    {
//        return $this->getParent()->getMenus()->first()->getId() == $this->getId();
//    }
//
//    public function isLast() :bool
//    {
//        return $this->getParent()->getMenus()->last()->getId() == $this->getId();
//    }

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @Gedmo\Slug(fields={"name"})
     * @ORM\Column(length=128, unique=true)
     */
    private $slug;

    /**
     * @Vich\UploadableField(mapping="view_image", fileNameProperty="image.name", size="image.size", mimeType="image.mimeType", originalName="image.originalName", dimensions="image.dimensions")
     * @var File
     */
    private $imageFile;

    /**
     * @ORM\Embedded(class="Vich\UploaderBundle\Entity\File")
     * @var EmbeddedFile
     */
    private $image;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $color;


    /**
     * @ORM\OneToMany(targetEntity="App\Entity\View", mappedBy="menu", orphanRemoval=true)
     * @ORM\OrderBy({"weight" = "ASC"})
     */
    private $views;

    /**
     * @ORM\Column(name="active", type="boolean")
     */
    private $active;

    /**
     * @Gedmo\SortableGroup
     * @ORM\ManyToOne(targetEntity="App\Entity\Event", inversedBy="menus")
     * @ORM\JoinColumn(nullable=false)
     */
    private $event;

    /**
     * @Gedmo\SortablePosition
     * @ORM\Column(type="integer")
     */
    private $position;


    public function __construct()
    {
        $this->views = new ArrayCollection();
        $this->image = new EmbeddedFile();
    }

    public function __toString(){
        return $this->getName();
    }

    public function getId()
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
        return $this;
    }

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): self
    {
        $this->slug = $slug;
        return $this;
    }


    /**
     * @param File|UploadedFile $image
     */
    public function setImageFile( ?File $image = null )
    {
        $this->imageFile = $image;

        if ( null !== $image ) {
            // It is required that at least one field changes if you are using doctrine
            // otherwise the event listeners won't be called and the file is lost
            $this->updatedAt = new \DateTime('now');
        }
    }

    public function getImageFile(): ?File
    {
        return $this->imageFile;
    }

    public function setImage(EmbeddedFile $image)
    {
        $this->image = $image;
    }

    public function getImage(): ?EmbeddedFile
    {
        return $this->image;
    }

    public function getColor(): ?string
    {
        return $this->color;
    }

    public function setColor(string $color): self
    {
        $this->color = $color;
        return $this;
    }

    public function getPic(): ?string
    {
        return $this->pic;
    }

    public function setPic(string $pic): self
    {
        $this->pic = $pic;
        return $this;
    }

    public function getActive(): ?bool
    {
        return $this->active;
    }

    public function setActive(bool $active): self
    {
        $this->active = $active;
        return $this;
    }

    /**
     * @return Collection|View[]
     */
    public function getViews(): Collection
    {
        return $this->views;
    }

    public function addView(View $view): self
    {
        if (!$this->views->contains($view)) {
            $this->views[] = $view;
            $view->setMenu($this);
        }

        return $this;
    }

    public function removeView(View $view): self
    {
        if ($this->views->contains($view)) {
            $this->views->removeElement($view);
            // set the owning side to null (unless already changed)
            if ($view->getMenu() === $this) {
                $view->setMenu(null);
            }
        }

        return $this;
    }

    public function getEvent(): ?Event
    {
        return $this->event;
    }

    public function setEvent(?Event $event): self
    {
        $this->event = $event;

        return $this;
    }

    public function setPosition($position)
    {
        $this->position = $position;
    }

    public function getPosition()
    {
        return $this->position;
    }


}
