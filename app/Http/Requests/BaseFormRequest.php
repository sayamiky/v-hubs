<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use InvalidArgumentException;

class BaseFormRequest extends FormRequest
{
    /**
     * Nama class DTO yang wajib didefinisikan di child request
     */
    protected string $dtoClass;

    /**
     * Convert request menjadi DTO
     */
    public function toDto(): object
    {
        if (!isset($this->dtoClass)) {
            throw new InvalidArgumentException("Property dtoClass belum di-set di " . static::class);
        }

        return new $this->dtoClass(...$this->validated());
    }
}
