<?php

namespace App\Entity;

use App\Repository\MembreRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=MembreRepository::class)
 */
class Membre
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $Pseudo;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $Mail;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $Mp;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $Mp_H;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $IP;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPseudo(): ?string
    {
        return $this->Pseudo;
    }

    public function setPseudo(string $Pseudo): self
    {
        $this->Pseudo = $Pseudo;

        return $this;
    }

    public function getMail(): ?string
    {
        return $this->Mail;
    }

    public function setMail(string $Mail): self
    {
        $this->Mail = $Mail;

        return $this;
    }

    public function getMp(): ?string
    {
        return $this->Mp;
    }

    public function setMp(string $Mp): self
    {
        $this->Mp = $Mp;

        return $this;
    }

    public function getMpH(): ?string
    {
        return $this->Mp_H;
    }

    public function setMpH(string $Mp_H): self
    {
        $this->Mp_H = $Mp_H;

        return $this;
    }

    public function getIP(): ?string
    {
        return $this->IP;
    }

    public function setIP(string $IP): self
    {
        $this->IP = $IP;

        return $this;
    }
}
