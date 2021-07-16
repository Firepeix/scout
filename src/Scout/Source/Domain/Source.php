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
    
    protected function createConcrete(): ConcreteSourceInterface
    {
        $type = $this->type->value();
        return [
                   MklotSource::TYPE    => fn() => new MklotSource($this->template->value(), $type, class_basename(MklotSource::class)),
                   MNatoSource::TYPE    => fn() => new MNatoSource($this->template->value(), $type, class_basename(MNatoSource::class)),
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
    
    public function getType(): Type
    {
        return $this->type;
    }
    
    public function getLastUpdate(SourcedObject $object): string
    {
        return $this->concreteSource->getLastUpdate($object);
    }
    
    public function toArray(): array
    {
        return $this->concreteSource->toArray();
    }
}
