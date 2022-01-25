<?php


namespace Scout\Book\Application\Postpone;
use Carbon\Carbon;
use Scout\Book\Domain\ValueObject\Id;
use Shared\Domain\Bus\CommandInterface;
use Shared\Infrastructure\Application\ApplicationCommand;

#[ApplicationCommand(name: "POSTPONE_BOOK")]
class PostponeBookCommand implements CommandInterface
{
    private int $id;
    private Carbon $until;
    
    public function __construct(int $id, Carbon $until = null)
    {
        $this->id           = $id;
        $this->until        = $until ?? Carbon::now()->addYear();
    }
    
    public function getId(): Id
    {
        return new Id($this->id);
    }
    
    public function until(): Carbon
    {
        return $this->until;
    }
}
