<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ActivityRepository")
 */

class Activity
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
     * @Gedmo\Slug(fields={"name"})
     * @ORM\Column(length=128, unique=true)
     */
    private $slug;

    /**
     * @ORM\Column(type="datetime")
     */
    private $start;

    /**
     * @ORM\Column(type="datetime")
     */
    private $end;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\User", inversedBy="activities")
     */
    private $players;

    /**
     * @ORM\Column(type="text")
     */
    private $description;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $game;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="masteredActivities")
     * @ORM\JoinColumn(nullable=true)
     */
    private $master;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $style;


    /**
     * @ORM\Column(type="integer")
     */
    private $slots;


    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Event", inversedBy="activities")
     * @ORM\JoinColumn(nullable=false)
     */
    private $event;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\ActivityType", inversedBy="activities")
     * @ORM\JoinColumn(nullable=false)
     */
    private $type;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Round", inversedBy="activities")
     */
    private $round;

    public function __construct()
    {
        $this->players = new ArrayCollection();
    }

    public function __toString()
    {
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


    public function getStart():? \DateTimeInterface
    {
        return $this->start;
    }

    public function setStart($start ): self
    {
        $this->start = $start;

        return $this;
    }


    public function getEnd():? \DateTimeInterface
    {
        return $this->end;
    }


    public function setEnd($end): self
    {
        $this->end = $end;

        return $this;
    }


    /**
     * @return Collection|User[]
     */
    public function getPlayers(): Collection
    {
        return $this->players;
    }

    public function isPlayer( ?User $user ): bool
    {
        return $this->getPlayers()->contains( $user );

    }

    public function isUser( User $user ): bool
    {
        return $this->getPlayers()->contains( $user ) || $this->getMaster() === $user;
    }

    public function addPlayer( User $player ): self
    {
        if (!$this->players->contains( $player )) {
            $this->players[] = $player;
        }

        return $this;
    }

    public function removePlayer( User $player ): self
    {
        if ($this->players->contains($player)) {
            $this->players->removeElement($player);
        }

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

    public function getGame(): ?string
    {
        return $this->game;
    }

    public function setGame(string $game): self
    {
        $this->game = $game;

        return $this;
    }

    public function getMaster(): ?User
    {
        return $this->master;
    }

    public function setMaster(?User $master): self
    {
        $this->master = $master;

        return $this;
    }

    public function getStyle(): ?string
    {
        return $this->style;
    }

    public function setStyle(string $style): self
    {
        $this->style = $style;

        return $this;
    }

    public function getSlots(): ?int
    {
        return $this->slots;
    }

    public function getFreeSlots(): ?int
    {
        return $this->getSlots() - count($this->getPlayers());
    }

    public function isFreeSlots(): bool
    {
        return $this->getFreeSlots() > 0;
    }

    public function setSlots(int $slots): self
    {
        $this->slots = $slots;

        return $this;
    }


    public function getLength() {
        return $this->getStart()->diff( $this->getEnd() )->h ;
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

    public function getType(): ?ActivityType
    {
        return $this->type;
    }

    public function setType(?ActivityType $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getRound(): ?Round
    {
        return $this->round;
    }

    public function setRound(?Round $round): self
    {
        $this->round = $round;

        return $this;
    }
}
