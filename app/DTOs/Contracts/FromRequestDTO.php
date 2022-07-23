<?php

namespace App\DTOs\Contracts;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;

interface FromRequestDTO {
    public static function makeFromRequest(Request|FormRequest $formRequest): static;
}