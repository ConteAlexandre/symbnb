<?php

namespace App\Entity;

use App\Repository\UsersRepository;
use Cocur\Slugify\Slugify;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=UsersRepository::class)
 * @ORM\HasLifecycleCallbacks()
 * @UniqueEntity(
 *     fields={"email"},
 *     message="This email is already used."
 * )
 */
class Users implements UserInterface
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(name="id", type="integer")
     */
    private $id;

    /**
     * @ORM\Column(name="first_name", type="string", length=255)
     * @Assert\NotBlank(message="This field is missing.")
     */
    private $firstName;

    /**
     * @ORM\Column(name="last_name", type="string", length=255)
     * @Assert\NotBlank(message="This field is missing.")
     */
    private $lastName;

    /**
     * @ORM\Column(name="email", type="string", length=255)
     * @Assert\Email(message="The fields {{ fields }} were not expected.")
     */
    private $email;

    /**
     * @ORM\Column(name="picture", type="string", length=255, nullable=true)
     * @Assert\Url(message="This field is not valid")
     */
    private $picture;

    /**
     * @ORM\Column(name="password", type="string", length=255)
     */
    private $password;

    /**
     * @Assert\EqualTo(propertyPath="password", message="This fields not equal at field password")
     */
    public $passwordConfirm;

    /**
     * @ORM\Column(name="introduction", type="string", length=255)
     * @Assert\Length(min="10", minMessage="The introduction must be minimum 10 charcaters")
     */
    private $introduction;

    /**
     * @ORM\Column(name="description", type="text")
     * @Assert\Length(min="100", minMessage="The description must be minimum 100 charcaters")
     */
    private $description;

    /**
     * @ORM\Column(name="slug", type="string", length=255)
     */
    private $slug;

    /**
     * @ORM\Column(name="salt", type="string")
     */
    private $salt;

    /**
     * @ORM\OneToMany(targetEntity=Ad::class, mappedBy="author")
     */
    private $ads;

    /**
     * @ORM\PrePersist()
     * @ORM\PreUpdate()
     */
    public function initialSlug()
    {
        if (empty($this->slug)) {
            $slugify = new Slugify();
            $this->slug = $slugify->slugify($this->firstName. ' '. $this->lastName);
        }
    }

    public function __construct()
    {
        $this->ads = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function setFirstName(string $firstName): self
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

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getPicture(): ?string
    {
        return $this->picture;
    }

    public function setPicture(?string $picture): self
    {
        $this->picture = $picture;

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

    public function getIntroduction(): ?string
    {
        return $this->introduction;
    }

    public function setIntroduction(string $introduction): self
    {
        $this->introduction = $introduction;

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

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): self
    {
        $this->slug = $slug;

        return $this;
    }

    /**
     * @return Collection|Ad[]
     */
    public function getAds(): Collection
    {
        return $this->ads;
    }

    public function addAd(Ad $ad): self
    {
        if (!$this->ads->contains($ad)) {
            $this->ads[] = $ad;
            $ad->setAuthor($this);
        }

        return $this;
    }

    public function removeAd(Ad $ad): self
    {
        if ($this->ads->contains($ad)) {
            $this->ads->removeElement($ad);
            // set the owning side to null (unless already changed)
            if ($ad->getAuthor() === $this) {
                $ad->setAuthor(null);
            }
        }

        return $this;
    }

    public function getRoles()
    {
        return ['ROLE_USER'];
    }

    public function setSalt($salt)
    {
        $this->salt = $salt;
    }

    public function getSalt()
    {
    }

    public function getUsername()
    {
        return $this->email;
    }

    public function eraseCredentials()
    {
    }
}
