<?php

declare(strict_types=1);

namespace App\Http\Requests\Api\Base;

use Illuminate\Foundation\Http\FormRequest;

abstract class BaseFormRequest extends FormRequest {
    
    /**
     * @var boolean $stopOnFirstFailure
     */
    protected $stopOnFirstFailure = true;
    
}