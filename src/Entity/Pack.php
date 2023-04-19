<?php

namespace App\Entity;

class Course {

    private int $id;
    private string $title;
    private int $price;
    private string $image;

    public function __construct(array $data = []) {

        foreach ($data as $propertyName => $value) {
            $setter = 'set' . ucfirst($propertyName);
            if(method_exists($this, $setter)) {
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
     * Get the value of price
     */
    public function getPrice(): int
    {
        return $this->price;
    }

    /**
     * Set the value of price
     */
    public function setPrice(int $price): self
    {
        $this->price = $price;

        return $this;
    }

    /**
     * Get the value of content
     */
    public function getImage(): string
    {
        return $this->image;
    }

    /**
     * Set the value of content
     */
    public function setImage(string $image): self
    {
        $this->image = $image;

        return $this;
    }
}