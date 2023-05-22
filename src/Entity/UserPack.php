<?php

namespace App\Entity;

use App\Entity\Pack;

use DateTimeImmutable;

class UserPack {

    private int $userId;
    private Pack $pack;
    private DateTimeImmutable $purchasedOn;

    public function __construct(array $pack = [])
    {
        $this->userId = $pack['userId'];
        $this->pack = new Pack($pack);
        $this->setPurchasedOn($pack['purchasedOn']);
    }

    /**
     * Get the value of userId
     */
    public function getUserId(): int
    {
        return $this->userId;
    }

    /**
     * Set the value of userId
     */
    public function setUserId(int $userId): self
    {
        $this->userId = $userId;

        return $this;
    }

    /**
     * Get the value of packId
     */
    public function getPack(): Pack
    {
        return $this->pack;
    }

    /**
     * Set the value of packId
     */
    public function setPack(Pack $pack): self
    {
        $this->pack = $pack;

        return $this;
    }

    /**
     * Get the value of purchasedOn
     */
    public function getPurchasedOn(): DateTimeImmutable
    {
        return $this->purchasedOn;
    }

    /**
     * Set the value of purchasedOn
     */
    public function setPurchasedOn(string|DateTimeImmutable $purchasedOn): self
    {
        if (is_string($purchasedOn)) {
            $purchasedOn = new DateTimeImmutable($purchasedOn);
        }
        $this->purchasedOn = $purchasedOn;

        return $this;
    }

    public function getFormattedPurchasedOn(): string {

        return $this->purchasedOn->format('d/m/Y H:i:s');
    }

    public function getFormattedPurchasedOnDay(): string {

        return $this->purchasedOn->format('d/m/Y');
    }

    public function getFormattedPurchasedOnHour(): string {

        return $this->purchasedOn->format('H:i:s');
    }
}