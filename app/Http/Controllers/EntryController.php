<?php

namespace App\Http\Controllers;

use App\Http\Requests\Entry\EditEntryRequest;
use App\Http\Requests\Entry\StoreEntryRequest;
use App\Http\Resources\EntryCollection;
use App\Models\Entry;
use Illuminate\Support\Facades\Auth;

class EntryController extends Controller
{
    public function index()
    {
        return EntryCollection::collection(Entry::where('user_id', Auth::id())->get());
    }

    public function store(StoreEntryRequest $request) {
        return new EntryCollection(Entry::create($request->validated()));
    }

    public function remove(Entry $entry) {
        $entry->delete();
        return response()->json(null);
    }

    public function edit(EditEntryRequest $request, Entry $entry) {
        $entry->update($request->validated());
        return response()->json(null);
    }
}
