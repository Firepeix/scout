<?php


namespace Scout\Source\Domain;


use App\Infrastructure\Sources\MangaDexSource;
use App\Infrastructure\Sources\MklotSource;
use App\Infrastructure\Sources\MNatoSource;
use Illuminate\Support\Collection;
use Scout\Source\Domain\ValueObject\SourceId;
use Scout\Source\Domain\ValueObject\Template;
use Scout\Source\Domain\ValueObject\Type;

class Source implements SourceInterface
{
    private SourceId                  $id;
    protected Type                    $type;
    private ?Template                 $template;
    protected ConcreteSourceInterface $concreteSource;
    
    public function __construct(SourceId $id, Type $type, Template $template = null)
    {
        $this->id             = $id;
        $this->type           = $type;
        $this->template       = $template;
        $this->concreteSource = $this->createConcrete();
    }
    
    public function hasObject(SourcedObject $object): bool
    {
        return $this->concreteSource->belongsToSource($object);
    }
    
    protected function createConcrete(): ConcreteSourceInterface
    {
        $type = $this->type->value();
        return [
                   MklotSource::TYPE    => fn() => new MklotSource($this->template->value(), $type),
                   MNatoSource::TYPE    => fn() => new MNatoSource($this->template->value(), $type),
                   MangaDexSource::TYPE => fn() => new MangaDexSource($type)
               ][$type]();
    }
    
    public function getFollowedSourcedObjects(): Collection
    {
        return $this->concreteSource->getFollowedSourcedObjects();
    }
    
    public function getId(): SourceId
    {
        return $this->id;
    }
}
