<?php

namespace App\Http\Controllers;

use App\Http\Resources\FolderCollection;
use App\Models\Folder;
use Illuminate\Http\Request;

class FolderController extends Controller
{

    public function index() {
        return FolderCollection::collection(Folder::all());
    }
}
