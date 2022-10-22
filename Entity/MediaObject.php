<?php

namespace Svs\Core\Entity;

use ApiPlatform\Core\Annotation\ApiProperty;
use ApiPlatform\Core\Annotation\ApiResource;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

use App\Controller\CreateMediaObjectAction;

use Google\Cloud\Storage\StorageClient;

/**
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks
 * @ApiResource(
 *     iri="http://schema.org/MediaObject",
 *     normalizationContext={
 *         "groups"={"media_object_read"},
 *     },
 *     collectionOperations={
 *         "get",
 *         "post"={
 *             "controller"=CreateMediaObjectAction::class,
 *             "deserialize"=false,
 *             "defaults"={
 *                 "_api_receive"=false,
 *             },
 *             "validation_groups"={"Default", "media_object_create"},
 *             "openapi_context"={
 *                 "requestBody"={
 *                     "content"={
 *                         "multipart/form-data"={
 *                             "schema"={
 *                                 "type"="object",
 *                                 "properties"={
 *                                     "file"={
 *                                         "type"="string",
 *                                         "format"="binary",
 *                                     },
 *                                 },
 *                             },
 *                         },
 *                     },
 *                 },
 *             },
 *         },
 *     },
 *     itemOperations={
 *         "get",
 *         "put",
 *     },
 * )
 */
class MediaObject
{
    /**
     * @var int|null
     *
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue
     * @ORM\Id
     */
    protected $id;

    /**
     * @var string|null
     *
     * @ORM\Column(type="string", nullable=false)
     */
    public $filename;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(type="datetime", nullable=true)
     */
    public $updated;

    /**
     * @ORM\ManyToOne(targetEntity=Place::class, inversedBy="images")
     * @Groups({"media_object_read"})
     */
    protected $place;

    /**
     * Unmapped property to handle file uploads
     */
    private ?UploadedFile $file = null;

    public function getId()
    {
        return $this->id;
    }

    public function setFile(?UploadedFile $file = null): void
    {
        $this->file = $file;
    }

    public function getFile(): ?UploadedFile
    {
        return $this->file;
    }

    /**
     * Manages the copying of the file to the relevant place on the server
     */
    public function upload(): void
    {
        // the file property can be empty if the field is not required
        if (null === $this->getFile()) {
            return;
        }

        // we use the original file name here but you should
        // sanitize it at least to avoid any security issues

        $storage = new StorageClient();

        $bucket = $storage->bucket($_ENV['GCS_MEDIA_BUCKET_NAME']);

        $bucket->upload(
            fopen($this->getFile()->getPathname(), 'r'),
            [
                'name' => 'images/' . $this->getFile()->getClientOriginalName(),
            ]
        );

        // set the path property to the filename where you've saved the file
        $this->filename = $this->getFile()->getClientOriginalName();

        // clean up the file property as you won't need it anymore
        $this->setFile(null);
    }

    /**
     * Lifecycle callback to upload the file to the server.
     *
     * @ORM\PrePersist
     * @ORM\PreUpdate
     */
    public function lifecycleFileUpload(): void
    {
        $this->upload();
    }

    /**
     * Updates the hash value to force the preUpdate and postUpdate events to fire.
     */
    public function refreshUpdated(): void
    {
        $this->setUpdated(new \DateTime());
    }

    /**
     * @return string
     */
    public function getFilename(): string
    {
        return $this->filename;
    }

    /**
     * @param string $filename
     * @return $this
     */
    public function setFilename(string $filename): self
    {
        $this->filename = $filename;

        return $this;
    }

    /**
     * @return null|\DateTime
     */
    public function getUpdated(): ?\DateTime
    {
        return $this->updated;
    }

    /**
     * @param null|\DateTime $updated
     * @return $this
     */
    public function setUpdated(?\DateTime $updated): self
    {
        $this->updated = $updated;

        return $this;
    }

    /**
     * @return null|Place
     */
    public function getPlace(): ?Place
    {
        return $this->place;
    }

    /**
     * @param null|Place $place
     * @return $this
     */
    public function setPlace(?Place $place): self
    {
        $this->place = $place;

        return $this;
    }
}
