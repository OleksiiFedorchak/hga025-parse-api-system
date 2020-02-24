<?php

namespace App\Http\Controllers;

use App\Match;
use Illuminate\Http\Request;
use Donquixote\Cellbrush\Table\Table;

class DataController extends Controller
{
    public function getData(Request $request)
    {
        return view('data')->with([
            'data' => Match::where(function ($q) use ($request) {
                if (!is_null($request->match_id)) $q->where('match_id', $request->match_id);
            })->paginate(20)->items(),

            'properties' => (new Match)->getFillable(),
            'page' => $request->page ?? 1,
            'nextPage' => ($request->page ?? 1) + 1,
            'prevPage' => ($request->page ?? 1) - 1,
            'maxPage' => Match::count() / 20,
        ]);
    }
}
