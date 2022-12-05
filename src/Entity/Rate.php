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

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'rate')]
    public User $participant;

    #[ORM\ManyToOne(targetEntity: Meeting::class, inversedBy: 'rate')]
    public Meeting $meeting;

    public function __construct(int $value, User $participant, Meeting $meeting)
    {
        $this->id = uniqid();
        $this->value = $value;
        $this->meeting = $meeting;
        $this->participant = $participant;

        $this->checkValue();
        $this->checkParticipant();
    }

    private function checkParticipant()
    {
        if(!$this->meeting->participants->contains($this->participant))
        {
            throw new \Exception("This user hasn't participated in this meeting");
        }
    }

    private function checkValue()
    {
        if($this->value > 5 || $this->value < 1)
        {
            throw new \Exception("Rate value is not valid");
        }
    }




}