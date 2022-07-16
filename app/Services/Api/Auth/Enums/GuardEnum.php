<?php

namespace App\Services\Api\Auth\Enums;

enum GuardEnum : string {
    case API = 'api';
    case WEB = 'web';
    case GUEST = 'guest';
}