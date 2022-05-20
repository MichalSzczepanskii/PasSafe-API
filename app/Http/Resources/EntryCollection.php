<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class EntryCollection extends JsonResource
{

    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'login' => $this->login,
            'password' => $this->password,
            'site' => $this->site,
            'description' => $this->description,
            'user' => new UserCollection($this->user),
            'folder' => new FolderCollection($this->folder),
        ];
    }
}
