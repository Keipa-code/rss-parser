<?php

namespace App\Entity;

use App\Repository\NewsItemRepository;
use Doctrine\DBAL\Types\GuidType;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=NewsItemRepository::class)
 */
class NewsItem
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private ?int $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private string $title;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private string $description;

    /**
     * @ORM\Column(type="guid")
     */
    private string $guid;
    /**
     * @ORM\Column(type="datetime_immutable")
     */
    private \DateTimeImmutable $pubDate;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private ?string $author;

    /**
     * @ORM\Column(type="json", nullable=true)
     */
    private ?array $enclosure=[];



    public function __construct(
        string $title,
        string $description,
        string $guid,
        \DateTimeImmutable $pudDate,
        string $author = null,
        array $enclosure = null
    )
    {
        $this->title       = $title;
        $this->description = $description;
        $this->guid        = $guid;
        $this->pubDate     = $pudDate;
        $this->author      = $author;
        $this->enclosure       = $enclosure;
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getPubDate(): ?\DateTimeImmutable
    {
        return $this->pubDate;
    }

    public function setPubDate(\DateTimeImmutable $pubDate): self
    {
        $this->pubDate = $pubDate;

        return $this;
    }

    public function getAuthor(): ?string
    {
        return $this->author;
    }

    public function setAuthor(?string $author): self
    {
        $this->author = $author;

        return $this;
    }

    public function getEnclosure(): ?array
    {
        return $this->enclosure;
    }

    public function setEnclosure(?string $enclosure): self
    {
        $this->enclosure = $enclosure;

        return $this;
    }

    public function getGuid(): ?string
    {
        return $this->guid;
    }

    public function setGuid(string $guid): self
    {
        $this->guid = $guid;

        return $this;
    }
}
