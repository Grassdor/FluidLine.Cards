<?php
namespace App\Entity;

class NewCard
{
    protected string $cardName;
    protected string $cardHost;
    protected string $cardLink;

    public function setCardName(string $cardName): void
    {
        $this->cardName = $cardName;
    }

    public function setCardHost(string $cardHost): void
    {
        $this->cardHost = $cardHost;
    }

    public function setCardLink(string $cardLink): void
    {
        $this->cardLink = $cardLink;
    }

    public function getCardName(): string
    {
        return $this->cardName;
    }

    public function getCardHost(): string
    {
        return $this->cardHost;
    }

    public function getCardLink(): string
    {
        return $this->cardLink;
    }
}