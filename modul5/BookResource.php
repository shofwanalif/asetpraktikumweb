<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

// Resource ini sudah LENGKAP - tidak perlu diubah.
// Gunakan sebagai referensi format penulisan API Resource.

class BookResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'author' => $this->author,
            'is_available' => $this->is_available,
            'file_path' => $this->file_path,
            'file_url' => $this->file_path
                ? asset('storage/' . $this->file_path)
                : null,
            'member' => $this->whenLoaded('member', function () {
                return [
                    'id' => $this->member->id,
                    'name' => $this->member->name,
                ];
            }),
        ];
    }
}
