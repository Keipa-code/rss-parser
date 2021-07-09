<?php

namespace App\Entity;

use App\Repository\ParseLogRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ParseLogRepository::class)
 */
class ParseLog
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="datetime_immutable")
     */
    private \DateTimeImmutable $date;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private string $requestMethod;

    /**
     * @ORM\Column(name="request_url", type="string", length=255)
     */
    private string $requestURL;

    /**
     * @ORM\Column(name="response_http_code", type="integer")
     */
    private int $responseHTTPCode;

    /**
     * @ORM\Column(name="response_body", type="json")
     */
    private array $responseBody = [];

    public function __construct(
        \DateTimeImmutable $date,
        string $requestMethod,
        string $requestURL,
        int $responseHTTPCode,
        array $responseBody
    )
    {

        $this->date             = $date;
        $this->requestMethod    = $requestMethod;
        $this->requestURL       = $requestURL;
        $this->responseHTTPCode = $responseHTTPCode;
        $this->responseBody     = $responseBody;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDate(): ?\DateTimeImmutable
    {
        return $this->date;
    }

    public function setDate(\DateTimeImmutable $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getRequestMethod(): ?string
    {
        return $this->requestMethod;
    }

    public function setRequestMethod(string $requestMethod): self
    {
        $this->requestMethod = $requestMethod;

        return $this;
    }

    public function getRequestURL(): ?string
    {
        return $this->requestURL;
    }

    public function setRequestURL(string $requestURL): self
    {
        $this->requestURL = $requestURL;

        return $this;
    }

    public function getResponseHTTPCode(): ?string
    {
        return $this->responseHTTPCode;
    }

    public function setResponseHTTPCode(string $responseHTTPCode): self
    {
        $this->responseHTTPCode = $responseHTTPCode;

        return $this;
    }

    public function getResponseBody(): ?array
    {
        return $this->responseBody;
    }

    public function setResponseBody(array $responseBody): self
    {
        $this->responseBody = $responseBody;

        return $this;
    }
}
