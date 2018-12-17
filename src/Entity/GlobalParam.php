<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\GlobalParamRepository")
 */
class GlobalParam
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
    private $siteName;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $mainText;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSiteName(): ?string
    {
        return $this->siteName;
    }

    public function setSiteName(string $siteName): self
    {
        $this->siteName = $siteName;

        return $this;
    }


    public function getMainText(): ?string
    {
        return $this->mainText;
    }

    public function setMainText( string $mainText ): self
    {
        $this->mainText = $mainText;

        return $this;
    }


}
