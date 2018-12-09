<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 * @UniqueEntity("email", message="Cet e-mail est déjà utilisé")
 * @UniqueEntity("username", message="Ce pseudo est déjà utilisé")
 */
class User implements UserInterface, \Serializable
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank()
     */
    private $username;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank()
     */
    private $firstname;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank()
     */
    private $lastname;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank()
     * @Assert\Email()
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank()
     */
    private $password;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $hash;

    /**
     * @ORM\Column(type="boolean")
     */
    private $valid;

    /**
     * @ORM\Column(name="is_active", type="boolean")
     */
    private $isActive;

    /**
     * @ORM\Column(type="datetime")
     */
    private $created;

    /**
     * @ORM\Column(type="datetime")
     */
    private $updated;

    /**
     * @ORM\Column(type="array", length=255)
     */
    private $roles;


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
        $this->activities = new ArrayCollection();
        $this->masteredActivities = new ArrayCollection();
        $this->isActive = true;
        $this->rights = new ArrayCollection();
        $this->events = new ArrayCollection();
    }

    public function  __toString() {
        return $this->getUsername();
    }


    public function eraseCredentials()
    {
    }

    public function getSalt()
    {
        return null;
    }

    /** @see \Serializable::serialize() */
    public function serialize()
    {
        return serialize(array(
            $this->id,
            $this->username,
            $this->password,
            // see section on salt below
            // $this->salt,
        ));
    }

    /** @see \Serializable::unserialize() */
    public function unserialize($serialized)
    {
        list (
            $this->id,
            $this->username,
            $this->password,
            // see section on salt below
            // $this->salt
            ) = unserialize($serialized);
    }


    public function getId()
    {
        return $this->id;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }

    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function setFirstname(string $firstname): self
    {
        $this->firstname = $firstname;

        return $this;
    }

    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    public function setLastName(string $lastname): self
    {
        $this->lastname = $lastname;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEMail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    public function getHash(): ?string
    {
        return $this->hash;
    }

    public function setHash(string $hash): self
    {
        $this->hash = $hash;

        return $this;
    }

    public function getValid(): ?bool
    {
        return $this->valid;
    }

    public function setValid(bool $valid): self
    {
        $this->valid = $valid;

        return $this;
    }

    public function getActive(): ?bool
    {
        return $this->isActive;
    }

    public function setActive(bool $isActive): self
    {
        $this->isActive = $isActive;

        return $this;
    }

    public function isActive(): ?bool
    {
        return  $this->isActive;
    }

    public function getCreated(): ?\DateTimeInterface
    {
        return $this->created;
    }

    public function setCreated(\DateTimeInterface $created): self
    {
        $this->created = $created;

        return $this;
    }

    public function getUpdated(): ?\DateTimeInterface
    {
        return $this->updated;
    }

    public function setUpdated(\DateTimeInterface $updated): self
    {
        $this->updated = $updated;

        return $this;
    }

    public function getRoles()
    {
        return $this->roles;
    }

    public function setRoles($roles): self
    {
        $this->roles = $roles;

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
