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
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $start;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $end;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\User", inversedBy="events")
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
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="masteredEvents")
     * @ORM\JoinColumn(nullable=false)
     */
    private $master;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $style;

  /**
   * @ORM\ManyToOne(targetEntity="App\Entity\EventType", inversedBy="events")
   * @ORM\JoinColumn(nullable=true)
   */
    private $eventType;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Round", inversedBy="events")
     */
    private $round;

    /**
     * @ORM\Column(type="integer")
     */
    private $slots;

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

    public function getStart()
    {
        return $this->start;
    }

    public function getFinalStart()
    {
        if( $this->start == null ) {
            return $this->getRound()->getStart();
        }
        return $this->start;
    }

    public function setStart( $start ): self
    {
        $this->start = $start;

        return $this;
    }

    public function getEnd()
    {
        return $this->end;
    }

    public function getFinalEnd()
    {
        if( $this->end == null ) {
            return $this->getRound()->getEnd();
        }
        return $this->end;
    }

    public function setEnd( $end): self
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

    public function isPlayer( $user ): bool
    {
        return $this->getPlayers()->contains( $user );
    }

    public function isUser( $user ): bool
    {
        return $this->getPlayers()->contains( $user ) || $this->getMaster() == $user;
    }

    public function addPlayer(User $player): self
    {
        if (!$this->players->contains($player)) {
            $this->players[] = $player;
        }

        return $this;
    }

    public function removePlayer(User $player): self
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

    public function getEventType(): ?EventType
    {
        return $this->eventType;
    }

    public function setEventType(?EventType $eventType): self
    {
        $this->eventType = $eventType;

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

    public function getSlots(): ?int
    {
        return $this->slots;
    }

    public function getFreeSlots(): ?int
    {
        return $this->getSlots() - count($this->getPlayers());
    }

    public function setSlots(int $slots): self
    {
        $this->slots = $slots;

        return $this;
    }
}
