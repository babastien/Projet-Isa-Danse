<?php

namespace App\Entity;

class Video {

    private int $id;
    private int $packId;
    private string $title;
    private string $filename;
    private int $rankOrder;

    public function __construct(array $data = [])
    {
        foreach ($data as $propertyName => $value) {
            $setter = 'set' . ucfirst($propertyName);
            if (method_exists($this, $setter)) {
                $this->$setter($value);
            }
        }
    }

    /**
     * Get the value of id
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * Set the value of id
     */
    public function setId(int $id): self
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Get the value of packId
     */
    public function getPackId(): int
    {
        return $this->packId;
    }

    /**
     * Set the value of packId
     */
    public function setPackId(int $packId): self
    {
        $this->packId = $packId;

        return $this;
    }

    /**
     * Get the value of title
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * Set the value of title
     */
    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get the value of filename
     */
    public function getFilename(): string
    {
        return $this->filename;
    }

    /**
     * Set the value of filename
     */
    public function setFilename(string $filename): self
    {
        $this->filename = $filename;

        return $this;
    }

    /**
     * Get the value of rankOrder
     */
    public function getRankOrder(): int
    {
        return $this->rankOrder;
    }

    /**
     * Set the value of rankOrder
     */
    public function setRankOrder(int $rankOrder): self
    {
        $this->rankOrder = $rankOrder;

        return $this;
    }
}