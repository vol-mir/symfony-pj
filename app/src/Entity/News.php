<?php

namespace App\Entity;

use DateTime;
use DateTimeInterface;
use App\Repository\NewsRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass=NewsRepository::class)
 * @ORM\Table(name="news")
 * @ORM\HasLifecycleCallbacks()
 * @UniqueEntity(
 *     fields={"news_id"},
 *     message="duplicate"
 * )
 */
class News
{
    /**
     * @var int
     *
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="bigint", options={"unsigned"=true}, nullable=false)
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=255, nullable=false)
     * @Assert\NotBlank
     * @Assert\Length(max=255)
     */
    private $title;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=255, nullable=false)
     * @Assert\NotBlank
     * @Assert\Length(max=255)
     */
    private $link;

    /**
     * @var DateTime
     *
     * @ORM\Column(type="datetime", nullable=false)
     * @Assert\Type("datetime")
     * @Assert\NotBlank
     */
    private $date_news;

    /**
     * @var string
     *
     * @ORM\Column(type="text", nullable=true)
     */
    private $full_text;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=255, nullable=false, unique=true)
     * @Assert\NotBlank
     * @Assert\Length(max=255)
     */
    private $news_id;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Assert\Length(max=255)
     */
    private $category;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Assert\Length(max=255)
     */
    private $author;

    /**
     * @var DateTime
     *
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $created_at;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Assert\Length(max=255)
     */
    private $image;

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

    public function getLink(): ?string
    {
        return $this->link;
    }

    public function setLink(string $link): self
    {
        $this->link = $link;

        return $this;
    }

    public function getDateNews(): ?\DateTimeInterface
    {
        return $this->date_news;
    }

    public function setDateNews(\DateTimeInterface $date_news): self
    {
        $this->date_news = $date_news;

        return $this;
    }

    public function getFullText(): ?string
    {
        return $this->full_text;
    }

    public function setFullText(string $full_text): self
    {
        $this->full_text = $full_text;

        return $this;
    }

    public function getNewsId(): ?string
    {
        return $this->news_id;
    }

    public function setNewsId(string $news_id): self
    {
        $this->news_id = $news_id;

        return $this;
    }

    public function getCategory(): ?string
    {
        return $this->category;
    }

    public function setCategory(?string $category): self
    {
        $this->category = $category;

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

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->created_at;
    }

    /**
     * @ORM\PrePersist
     */
    public function prePersist(): void
    {
        $this->created_at = new DateTime();
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(?string $image): self
    {
        $this->image = $image;

        return $this;
    }
}
