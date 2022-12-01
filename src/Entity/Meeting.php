<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: '`meetings`')]
class Meeting
{
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: "NONE")]
    #[ORM\Column]
    public readonly string $id;

    #[ORM\Column(length: 255)]
    public readonly string $name;

    #[ORM\Column(type: Types::DATETIME_IMMUTABLE)]
    public readonly \DateTimeImmutable $startTime;

    #[ORM\Column(type: Types::DATETIME_IMMUTABLE)]
    public readonly \DateTimeImmutable $endTime;

    #[ORM\ManyToMany(targetEntity: User::class)]
    public Collection $participants;

    private const DONE = 'done';
    private const FULL = 'full';
    private const IN_SESSION = 'in session';
    private const OPEN = 'open to registration';

    public function __construct(string $name, \DateTimeImmutable $startTime)
    {
        $this->id = uniqid();
        $this->name = $name;
        $this->startTime = $startTime;
        $this->endTime = $startTime->add(\DateInterval::createFromDateString('1 hour'));
        $this->participants = new ArrayCollection();
    }

    public function addAParticipant(User $participant): void
    {
        $this->participants->add($participant);
    }

    /**
     * Returns a current status of meeting
     * @return string
     */
    public function getStatus():string
    {
        $now = new \DateTime();

        //if meeting has fewer than 5 participants and didn't start yet
        if($this->participants->count() < 5 && $this->startTime > $now) return self::OPEN;

        // if there are 5 participants, but it didn't start yet
        if($this->participants->count() == 5 && $this->startTime > $now) return self::FULL;

        //if it has started but didn't finish
        if($this->startTime < $now && $this->endTime > $now) return self::IN_SESSION;

        //when the meeting is finished
        if($this->endTime < $now) return self::DONE;

    }
}
