<?php

namespace App\Http\Controllers;

use App\Models\Folder;
use Illuminate\Http\Request;

class FolderController extends Controller
{

    public function index() {
        return response()->json(Folder::all());
    }
}
