<?php

namespace Monolith\Module\Slider\Entity;

use Doctrine\ORM\Mapping as ORM;
use Monolith\Bundle\CMSBundle\Entity\Folder;
use Smart\CoreBundle\Doctrine\ColumnTrait;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity
 * @ORM\Table(name="slides",
 *      indexes={
 *          @ORM\Index(columns={"position"}),
 *          @ORM\Index(columns={"user_id"}),
 *      }
 * )
 */
class Slide
{
    use ColumnTrait\Id;
    use ColumnTrait\IsEnabled;
    use ColumnTrait\CreatedAt;
    use ColumnTrait\Position;
    use ColumnTrait\Title;
    use ColumnTrait\FosUser;

    /**
     * @Assert\File(maxSize="2000000")
     */
    private $file;

    /**
     * @var string
     *
     * @ORM\Column(length=64, unique=true)
     */
    private $file_name;

    /**
     * @var string
     *
     * @ORM\Column(length=255)
     */
    private $original_file_name;

    /**
     * @ORM\Column(type="array", nullable=true)
     */
    private $properties;

    /**
     * @var string|null
     *
     * @ORM\Column(type="string", nullable=true)
     */
    protected $uri;

    /**
     * @var Folder|null
     *
     * @ORM\ManyToOne(targetEntity="Monolith\Bundle\CMSBundle\Entity\Folder")
     */
    protected $folder;

    /**
     * @var Slider
     *
     * @ORM\ManyToOne(targetEntity="Slider", inversedBy="slides")
     * @ORM\JoinColumn(name="slider_id", nullable=false)
     * @Assert\NotBlank()
     */
    private $slider;

    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->created_at   = new \DateTime();
        $this->is_enabled   = true;
        $this->position     = 0;
        $this->properties   = [];
    }

    /**
     * @param string $file_name
     *
     * @return $this
     */
    public function setFileName($file_name)
    {
        $this->file_name = $file_name;

        return $this;
    }

    /**
     * @return string
     */
    public function getFileName()
    {
        return $this->file_name;
    }

    /**
     * @param string $original_file_name
     *
     * @return $this
     */
    public function setOriginalFileName($original_file_name)
    {
        $this->original_file_name = $original_file_name;

        return $this;
    }

    /**
     * @return string
     */
    public function getOriginalFileName()
    {
        return $this->original_file_name;
    }

    /**
     * @param \Monolith\Module\Slider\Entity\Slider $slider
     *
     * @return $this
     */
    public function setSlider(Slider $slider)
    {
        $this->slider = $slider;

        return $this;
    }

    /**
     * @return \Monolith\Module\Slider\Entity\Slider
     */
    public function getSlider()
    {
        return $this->slider;
    }

    /**
     * @param mixed $properties
     *
     * @return $this
     */
    public function setProperties($properties)
    {
        $this->properties = $properties;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getProperties()
    {
        return $this->properties;
    }

    /**
     * @param UploadedFile $file
     */
    public function setFile(UploadedFile $file = null)
    {
        $this->file = $file;
    }

    /**
     * @return UploadedFile
     */
    public function getFile()
    {
        return $this->file;
    }

    /**
     * @return null|string
     */
    public function getUri(): ?string
    {
        return $this->uri;
    }

    /**
     * @param null|string $uri
     *
     * @return $this
     */
    public function setUri($uri)
    {
        $this->uri = $uri;

        return $this;
    }

    /**
     * @param Folder|null $folder
     *
     * @return $this
     */
    public function setFolder(?Folder $folder = null): ?Slide
    {
        $this->folder = $folder;

        return $this;
    }

    /**
     * @return Folder|null
     */
    public function getFolder(): ?Folder
    {
        return $this->folder;
    }
}
