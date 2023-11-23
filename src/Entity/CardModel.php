<?php

namespace App\Entity;

class CardModel
{
    private string $cardName;
    private string $cardHost;
    private string $cardLink;

    public function __construct($cardName, $cardHost, $cardLink)
    {
        $this->cardName = $cardName;
        $this->cardHost = $cardHost;
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
