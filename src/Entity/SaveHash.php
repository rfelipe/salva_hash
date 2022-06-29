<?php

namespace App\Entity;

use App\Repository\SaveHashRepository;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Persistence\ObjectManager;

#[ORM\Entity(repositoryClass: SaveHashRepository::class)]
class SaveHash
{
    // #[ORM\Entity]
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    // #[ORM\Table(name: "save_hash")]
    private $id;

    #[ORM\Column(type: 'datetime')]
    private $Batch;

    #[ORM\Column(type: 'string', length: 255)]
    private $entrada;

    #[ORM\Column(type: 'string', length: 255)]
    private $chave;

    #[ORM\Column(type: 'string', length: 255)]
    private $hash;

    #[ORM\Column(type: 'integer')]
    private $tentativas;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getBatch(): ?\DateTimeInterface
    {
        return $this->Batch;
    }

    public function setBatch(\DateTimeInterface $Batch): self
    {
        $this->Batch = $Batch;

        return $this;
    }

    public function getEntrada(): ?string
    {
        return $this->entrada;
    }

    public function setEntrada(string $entrada): self
    {
        $this->entrada = $entrada;

        return $this;
    }

    public function getChave(): ?string
    {
        return $this->chave;
    }

    public function setChave(string $chave): self
    {
        $this->chave = $chave;

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

    public function getTentativas(): ?int
    {
        return $this->tentativas;
    }

    public function setTentativas(int $tentativas): self
    {
        $this->tentativas = $tentativas;

        return $this;
    }
}
