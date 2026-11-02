<?php

declare(strict_types=1);

namespace App\Privacy;

final class SubscriptionPrivacy
{
    // Zmiana treści zgody lub klauzuli wymaga nowej wersji.
    public const VERSION = '2026-11-02';
    public const PATH = '/prywatnosc-powiadomien';
    public const CONTROLLER_NAME = 'Klub Karate Kyokushin i Sportów Walki';
    public const CONTROLLER_ADDRESS = 'ul. Nanicka 22, 84-200 Wejherowo';
    public const CONTACT_EMAIL = 'kyokushin.wejherowo@gmail.com';
    public const CONSENT_TEXT = 'Wyrażam zgodę na przetwarzanie mojego adresu e-mail przez '
        . self::CONTROLLER_NAME
        . ' w celu przesyłania powiadomień o zmianach grafiku treningów.';
}
