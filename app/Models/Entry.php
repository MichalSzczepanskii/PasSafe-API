<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Entry extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'login',
        'password',
        'site',
        'description',
        'user_id',
        'folder_id'
    ];

    public function folder() {
        return $this->belongsTo(Folder::class);
    }

    public function user() {
        return $this->belongsTo(User::class);
    }
}
