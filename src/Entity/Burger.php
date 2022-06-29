<?php

namespace App\Entity;

use App\Entity\User;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\BurgerRepository;
use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: BurgerRepository::class)]
#[ApiResource(
    subresourceOperations: [
        'api_users_burgers_get_subresource' => [
            'method' => 'GET',
            'normalization_context' => ['groups' => ['foobar'],],
            "security"=>"is_granted('ROLE_GESTIONNAIRE')",
            "security_message"=>"Vous n'avez pas access à cette Ressource",    
        ]
    ],
    collectionOperations:[
        "get"=>[
            'method' => 'get',
            'status' => Response::HTTP_OK,
            'normalization_context' => ['groups' => ['simple']],
        ]
    ,"post"=>[
        'denormalization_context' => ['groups' => ['write']],
        'normalization_context' => ['groups' => ['all']], 
        "security"=>"is_granted('ROLE_GESTIONNAIRE')",
        "security_message"=>"Vous n'avez pas access à cette Ressource",
    ]
    ],
    itemOperations:[
        "put"=>[
            "security"=>"is_granted('ROLE_GESTIONNAIRE')",
            "security_message"=>"Vous n'avez pas access à cette Ressource",
        ],
    "get"=>[
        'method' => 'get',
        'status' => Response::HTTP_OK,
        'normalization_context' => ['groups' => ['all']],
    ]
    ]
)]

class Burger
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    #[Groups(["simple","all",])]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    #[Groups(["simple","all","write","foobar"])]
    private $nom;

    #[ORM\Column(type: 'float')]
    #[Groups(["simple","all","write","foobar"])] 
    private $prix;

    #[ORM\Column(type: 'boolean')]
    #[Groups(["all","foobar"])]
    private $isEtat=true;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'burgers')]
    #[Groups(["all","write"])]
    private $user;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getPrix(): ?float
    {
        return $this->prix;
    }

    public function setPrix(float $prix): self
    {
        $this->prix = $prix;

        return $this;
    }

    public function isIsEtat(): ?bool
    {
        return $this->isEtat;
    }

    public function setIsEtat(bool $isEtat): self
    {
        $this->isEtat = $isEtat;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }
}
