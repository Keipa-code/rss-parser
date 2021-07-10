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
     * @ORM\Column(type="string", length=3000)
     */
    private string $title;

    /**
     * @ORM\Column(type="string")
     */
    private string $link;

    /**
     * @ORM\Column(type="string", length=3000)
     */
    private string $description;

    /**
     * @ORM\Column(type="string")
     */
    private string $guid;
    /**
     * @ORM\Column(type="datetime_immutable")
     */
    private \DateTimeImmutable $pubDate;

    /**
     * @ORM\Column(type="string", length=3000, nullable=true)
     */
    private ?string $author;

    /**
     * @ORM\Column(type="json", nullable=true)
     */
    private ?array $enclosure=[];

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private ?bool $last;


    public function __construct(
        string $title,
        string $link,
        string $description,
        string $guid,
        \DateTimeImmutable $pudDate,
        string $author = null,
        array $enclosure = null,
        bool $last = null
    )
    {
        $this->title       = $title;
        $this->link        = $link;
        $this->description = $description;
        $this->guid        = $guid;
        $this->pubDate     = $pudDate;
        $this->author      = $author;
        $this->enclosure   = $enclosure;
        $this->last        = $last;
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

    public function getLink(): ?string
    {
        return $this->link;
    }

    public function setLink(string $link): self
    {
        $this->link = $link;

        return $this;
    }

    public function getLast(): ?bool
    {
        return $this->last;
    }

    public function setLast(?bool $last): self
    {
        $this->last = $last;

        return $this;
    }
}
