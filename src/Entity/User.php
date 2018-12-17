<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use FOS\UserBundle\Model\User as BaseUser;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 * @UniqueEntity("email", message="Cet e-mail est déjà utilisé")
 * @UniqueEntity("username", message="Ce pseudo est déjà utilisé")
 */
class User extends BaseUser
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    protected $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank()
     */
    private $firstName;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank()
     */
    private $lastName;


    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Activity", mappedBy="players")
     */
    private $activities;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Activity", mappedBy="master")
     */
    private $masteredActivities;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $sleep;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Menu")
     */
    private $rights;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Event", inversedBy="users")
     */
    private $events;



    public function __construct() {
        parent::__construct();
        $this->firstName = '';
        $this->lastName = '';
        $this->activities = new ArrayCollection();
        $this->masteredActivities = new ArrayCollection();
        $this->rights = new ArrayCollection();
        $this->events = new ArrayCollection();
    }

    public function  __toString() {
        return $this->getUsername();
    }


    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function setFirstName( string $firstName): self
    {
        $this->firstName = $firstName;

        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function setLastName(string $lastName): self
    {
        $this->lastName = $lastName;

        return $this;
    }

    /**
     * @return Collection|Activity[]
     */
    public function getActivities(): Collection
    {
        return $this->activities;
    }

    public function addActivity( Activity $activity): self
    {
        if (!$this->activities->contains($activity)) {
            $this->activities[] = $activity;
            $activity->addPlayer($this);
        }

        return $this;
    }

    public function removeActivity( Activity $activity): self
    {
        if ($this->activities->contains($activity)) {
            $this->activities->removeElement($activity);
            $activity->removePlayer($this);
        }

        return $this;
    }

    /**
     * @return Collection|Activity[]
     */
    public function getMasteredActivities(): Collection
    {
        return $this->masteredActivities;
    }

    public function addMasteredActivity( Activity $activity): self
    {
        if (!$this->masteredActivities->contains($activity)) {
            $this->masteredActivities[] = $activity;
            $activity->setMaster($this);
        }

        return $this;
    }

    public function removeMasteredActivity( Activity $activity): self
    {
        if ($this->masteredActivities->contains($activity)) {
            $this->masteredActivities->removeElement($activity);
            // set the owning side to null (unless already changed)
            if ($activity->getMaster() === $this) {
                $activity->setMaster(null);
            }
        }

        return $this;
    }

    public function getSleep(): ?string
    {
        return $this->sleep;
    }

    public function setSleep(?string $sleep): self
    {
        $this->sleep = $sleep;

        return $this;
    }

    /**
     * @return Collection|Menu[]
     */
    public function getRights(): Collection
    {
        return $this->rights;
    }

    public function addRight(Menu $right): self
    {
        if (!$this->rights->contains($right)) {
            $this->rights[] = $right;
        }

        return $this;
    }

    public function removeRight(Menu $right): self
    {
        if ($this->rights->contains($right)) {
            $this->rights->removeElement($right);
        }

        return $this;
    }

    /**
     * @return Collection|Event[]
     */
    public function getEvents(): Collection
    {
        return $this->events;
    }

    public function addEvent( Event $event): self
    {
        if (!$this->events->contains($event)) {
            $this->events[] = $event;
        }

        return $this;
    }

    public function removeEvent( Event $event): self
    {
        if ($this->events->contains($event)) {
            $this->events->removeElement($event);
        }

        return $this;
    }


}
