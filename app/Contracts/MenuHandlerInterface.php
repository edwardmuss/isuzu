<?php

namespace App\Contracts;

interface MenuHandlerInterface
{
    /**
     * Handle the menu logic.
     *
     * @param array $textArray Input from the USSD session.
     * @param array &$sessionData Reference to session data.
     * @param string $phoneNumber The user's phone number.
     * @return string USSD response.
     */
    public function handle(array $textArray, array &$sessionData, string $phoneNumber): string;
}
