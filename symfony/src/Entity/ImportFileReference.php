<?php
namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\ImportFileReferenceRepository;
use Symfony\Component\Validator\Constraints\File;

/**
 * @ORM\Entity(repositoryClass=ImportFileReferenceRepository::class)
 * @ORM\Table(name="inported_files")
 */
class ImportFileReference
{
    /**
     * @var int
     *
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(type="string", unique=true)
     */
    private $filename;

    /**
     * @var string
     *
     * @ORM\Column(type="string")
     */
    private $data;

    public function getId(): int
    {
        return $this->id;
    }

    public function getFilename(): string
    {
        return $this->filename;
    }

    public function setFilename(string $filename): self
    {
        $this->filename = $filename;
        return $this;
    }

    public function getData(): string
    {
        return $this->data;
    }

    public function setData(string $data): self
    {
        $this->data = $data;
        return $this;
    }
}
