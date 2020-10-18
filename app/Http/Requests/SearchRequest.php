<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SearchRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'page' => 'int',
            'limit' => 'int|max:100',
            'search' => 'string',
        ];
    }

    public function page(): int
    {
        return $this->get('page', 1);
    }

    public function limit(): int
    {
        return $this->get('limit', 20);
    }

    public function searchQuery(): ?string
    {
        return $this->get('search') ?: null;
    }
}
