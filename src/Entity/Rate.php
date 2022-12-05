<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: '`rate`')]
class Rate
{
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: "NONE")]
    #[ORM\Column(length: 13)]
    public readonly string $id;

    #[ORM\Column()]
    public int $value;


    public function __construct(int $value)
    {
        $this->id = uniqid();
        $this->value = $value;
    }



}