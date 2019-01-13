<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\EventRepository")
 */
class Event
{
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
     * @ORM\Column(type="datetime")
     */
    private $start;

    /**
     * @ORM\Column(type="datetime")
     */
    private $end;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Menu", mappedBy="event", orphanRemoval=true)
     * @ORM\OrderBy({"position" = "ASC"})
     */
    private $menus;

    /**
     * @ORM\Column(type="boolean")
     */
    private $active;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $description;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Parrainer", mappedBy="event", orphanRemoval=true)
     * @ORM\OrderBy({"position" = "ASC"})
     */
    private $parrainers;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Article", mappedBy="event", orphanRemoval=true)
     * @ORM\OrderBy({"position" = "ASC"})
     */
    private $articles;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Booking", mappedBy="event", orphanRemoval=true)
     */
    private $bookings;

    /**
     * @ORM\Column(type="array", nullable=true)
     */
    private $options = [];

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Activity", mappedBy="event", orphanRemoval=true)
     */
    private $activities;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Round", mappedBy="event", orphanRemoval=true)
     */
    private $rounds;

    /**
     * @ORM\Column(type="array", nullable=true)
     */
    private $topLinks = [];

    /**
     * @ORM\Column(type="text")
     */
    private $footerText;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $facebookLink;

    /**
     * @ORM\Column(type="boolean")
     */
    private $open;

    /**
     * @ORM\Column(type="boolean")
     */
    private $openToPlayers;

    /**
     * @ORM\Column(type="boolean")
     */
    private $openToMasters;

    public function __construct()
    {
        $this->menus = new ArrayCollection();
        $this->parrainers = new ArrayCollection();
        $this->articles = new ArrayCollection();
        $this->bookings = new ArrayCollection();
        $this->activities = new ArrayCollection();
        $this->rounds = new ArrayCollection();
    }

    public function __toString()
    {
        return $this->getName();
    }

    public function isPlayerCanRegister() {
        return $this->getOpen() && $this->getOpenToPlayers();
    }

    public function isMasterCanRegister() {
        return $this->getOpen() && $this->getOpenToMasters();
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

        return $this;
    }

    public function getStart(): ?\DateTimeInterface
    {
        return $this->start;
    }

    public function setStart(\DateTimeInterface $start): self
    {
        $this->start = $start;

        return $this;
    }

    public function getEnd(): ?\DateTimeInterface
    {
        return $this->end;
    }

    public function setEnd(\DateTimeInterface $end): self
    {
        $this->end = $end;

        return $this;
    }


    /**
     * @return Collection|Menu[]
     */
    public function getMenus(): Collection
    {
        return $this->menus;
    }

    public function addMenu(Menu $menu): self
    {
        if (!$this->menus->contains($menu)) {
            $this->menus[] = $menu;
            $menu->setEvent($this);
        }

        return $this;
    }

    public function removeMenu(Menu $menu): self
    {
        if ($this->menus->contains($menu)) {
            $this->menus->removeElement($menu);
            // set the owning side to null (unless already changed)
            if ($menu->getEvent() === $this) {
                $menu->setEvent(null);
            }
        }

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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @return Collection|Parrainer[]
     */
    public function getParrainers(): Collection
    {
        return $this->parrainers;
    }

    public function addParrainer(Parrainer $parrainer): self
    {
        if (!$this->parrainers->contains($parrainer)) {
            $this->parrainers[] = $parrainer;
            $parrainer->setEvent($this);
        }

        return $this;
    }

    public function removeParrainer(Parrainer $parrainer): self
    {
        if ($this->parrainers->contains($parrainer)) {
            $this->parrainers->removeElement($parrainer);
            // set the owning side to null (unless already changed)
            if ($parrainer->getEvent() === $this) {
                $parrainer->setEvent(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Article[]
     */
    public function getArticles(): Collection
    {
        return $this->articles;
    }

    public function addArticle(Article $article): self
    {
        if (!$this->articles->contains($article)) {
            $this->articles[] = $article;
            $article->setEvent($this);
        }

        return $this;
    }

    public function removeArticle(Article $article): self
    {
        if ($this->articles->contains($article)) {
            $this->articles->removeElement($article);
            // set the owning side to null (unless already changed)
            if ($article->getEvent() === $this) {
                $article->setEvent(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Booking[]
     */
    public function getBookings(): Collection
    {
        return $this->bookings;
    }

    public function addBooking(Booking $booking): self
    {
        if (!$this->bookings->contains($booking)) {
            $this->bookings[] = $booking;
            $booking->setEvent($this);
        }

        return $this;
    }

    public function removeBooking(Booking $booking): self
    {
        if ($this->bookings->contains($booking)) {
            $this->bookings->removeElement($booking);
            // set the owning side to null (unless already changed)
            if ($booking->getEvent() === $this) {
                $booking->setEvent(null);
            }
        }

        return $this;
    }

    public function getOptions(): ?array
    {
        return $this->options;
    }

    public function setOptions(?array $options): self
    {
        $this->options = $options;

        return $this;
    }

    /**
     * @return Collection|Activity[]
     */
    public function getActivities(): Collection
    {
        return $this->activities;
    }

    public function addActivity(Activity $activity): self
    {
        if (!$this->activities->contains($activity)) {
            $this->activities[] = $activity;
            $activity->setEvent($this);
        }

        return $this;
    }

    public function removeActivity(Activity $activity): self
    {
        if ($this->activities->contains($activity)) {
            $this->activities->removeElement($activity);
            // set the owning side to null (unless already changed)
            if ($activity->getEvent() === $this) {
                $activity->setEvent(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Round[]
     */
    public function getRounds(): Collection
    {
        return $this->rounds;
    }

    /**
     * @return Collection|Round[]
     */
    public function getRoundsByActivityType(ActivityType $activityType): Collection
    {
        return $this->rounds->filter( function ( Round $r ) use ( $activityType ) {
            return $r->getActivityType() == $activityType;
        });
    }

    public function addRound(Round $round): self
    {
        if (!$this->rounds->contains($round)) {
            $this->rounds[] = $round;
            $round->setEvent($this);
        }

        return $this;
    }

    public function removeRound(Round $round): self
    {
        if ($this->rounds->contains($round)) {
            $this->rounds->removeElement($round);
            // set the owning side to null (unless already changed)
            if ($round->getEvent() === $this) {
                $round->setEvent(null);
            }
        }

        return $this;
    }

    public function getTopLinks(): ?array
    {
        return $this->topLinks;
    }

    public function setTopLinks(?array $topLinks): self
    {
        $this->topLinks = $topLinks;

        return $this;
    }

    public function getFooterText(): ?string
    {
        return $this->footerText;
    }

    public function setFooterText(string $footerText): self
    {
        $this->footerText = $footerText;

        return $this;
    }

    public function getFacebookLink(): ?string
    {
        return $this->facebookLink;
    }

    public function setFacebookLink(string $facebookLink): self
    {
        $this->facebookLink = $facebookLink;

        return $this;
    }

    public function getOpen(): ?bool
    {
        return $this->open;
    }

    public function setOpen(bool $open): self
    {
        $this->open = $open;

        return $this;
    }

    public function getOpenToPlayers(): ?bool
    {
        return $this->openToPlayers;
    }

    public function setOpenToPlayers(bool $openToPlayers): self
    {
        $this->openToPlayers = $openToPlayers;

        return $this;
    }

    public function getOpenToMasters(): ?bool
    {
        return $this->openToMasters;
    }

    public function setOpenToMasters(bool $openToMasters): self
    {
        $this->openToMasters = $openToMasters;

        return $this;
    }
}
