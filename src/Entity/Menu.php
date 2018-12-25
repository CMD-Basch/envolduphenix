<?php

namespace App\Entity;


use App\Model\SortableInterface;
use App\Service\Form\WeightService;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;


use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * @ORM\Entity(repositoryClass="App\Repository\MenuRepository")
 * @Vich\Uploadable()
 */
class Menu implements SortableInterface
{

    public function isFirst() :bool
    {
        return WeightService::isFirst( $this, $this->getEvent()->getMenus() );
    }

    public function isLast() :bool
    {
        return WeightService::isLast( $this, $this->getEvent()->getMenus() );
    }

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
     * @Vich\UploadableField(mapping="menu_image", fileNameProperty="image")
     * @var File
     */
    private $imageFile;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @var string
     */
    private $image;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     * @var \DateTime
     */
    private $updatedAt;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $color;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\View", mappedBy="menu", orphanRemoval=true)
     * @ORM\OrderBy({"position" = "ASC"})
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


    public function setImageFile( File $image = null )
    {
        $this->imageFile = $image;

        if ( $image ) {
            $this->updatedAt = new \DateTime('now');
        }
    }

    public function getImageFile()
    {
        return $this->imageFile;
    }

    public function setImage( $image)
    {
        $this->image = $image;
    }

    public function getImage()
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
