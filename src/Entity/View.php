<?php

namespace App\Entity;

use App\Model\SortableInterface;
use App\Service\Form\WeightService;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;

use Vich\UploaderBundle\Entity\File as EmbeddedFile;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ViewRepository")
 * @Vich\Uploadable
 */
class View implements SortableInterface
{

    public function isFirst() :bool
    {
        return WeightService::isFirst( $this, $this->getMenu()->getViews() );
    }

    public function isLast() :bool
    {
        return WeightService::isLast( $this, $this->getMenu()->getViews() );
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
    * @Gedmo\Slug(handlers={
    *   @Gedmo\SlugHandler(class="Gedmo\Sluggable\Handler\RelativeSlugHandler", options={
    *       @Gedmo\SlugHandlerOption(name="relationField", value="menu"),
    *       @Gedmo\SlugHandlerOption(name="relationSlugField", value="slug"),
    *       @Gedmo\SlugHandlerOption(name="separator", value="--")
    *   }),
    *
    *  }, fields={"name"}, updatable=true )
    * @ORM\Column(length=128, unique=true)
    */
    private $slug;

    /**
     * @Gedmo\SortableGroup
     * @ORM\ManyToOne(targetEntity="App\Entity\Menu", inversedBy="views")
     * @ORM\JoinColumn(nullable=false)
     */
    private $menu;

    /**
     * @ORM\Column(type="string", length=255,  nullable=true)
     */
    private $module;


    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $content;


    /**
     * @ORM\Column(type="boolean")
     */
    private $active;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $title;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $subtitle;


    /**
     * @Vich\UploadableField(mapping="view_image", fileNameProperty="image")
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
     * @ORM\Column(type="boolean")
     */
    private $fixed;

    /**
     * @ORM\Column(type="boolean")
     */
    private $deleted;

    /**
     * @Gedmo\SortablePosition
     * @ORM\Column(type="integer")
     */
    private $position;



    public function __construct()
    {

    }

    public function __toString(): string
    {
        return $this->name ?? '';
    }

    public function getFilter()
    {
        return ['menu' => $this->getMenu()->getId()];
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

    public function getMenu(): ?Menu
    {
        return $this->menu;
    }

    public function setMenu(?Menu $menu): self
    {
        $this->menu = $menu;

        return $this;
    }

    public function getModule()
    {
        return $this->module;
    }

    public function setModule($module): self
    {
        $this->module = $module;

        return $this;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(?string $content): self
    {
        $this->content = $content;

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

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getSubtitle(): ?string
    {
        return $this->subtitle;
    }

    public function setSubtitle(string $subtitle): self
    {
        $this->subtitle = $subtitle;

        return $this;
    }


    public function setImageFile( ?File $image = null )
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

    public function setImage($image)
    {
        $this->image = $image;
    }

    public function getImage()
    {
        return $this->image;
    }

    public function getFixed(): ?bool
    {
        return $this->fixed;
    }

    public function setFixed(bool $fixed): self
    {
        $this->fixed = $fixed;

        return $this;
    }

    public function getDeleted(): ?bool
    {
        return $this->deleted;
    }

    public function setDeleted(bool $deleted): self
    {
        $this->deleted = $deleted;

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
