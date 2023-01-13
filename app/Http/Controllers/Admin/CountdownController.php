<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Countdown;
use Inertia\Inertia;

class CountdownController extends Controller
{
    public function index(Request $request)
    {
        $countdowns = Countdown::when($request->has('search'), function ($query) use ($request) {
            $query->where('name', 'LIKE', '%' . $request->search . '%');
        })->paginate(10)->withQueryString();
        return Inertia::render("Admin/Countdown/Index", ['countdowns' => $countdowns]);
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        // dd($request->start);
        $countdowns = Countdown::first();
        if ($countdowns == null) {
            Countdown::create([
                "name" => "Countdown Pre Order",
                "started_at" => $request->start,
                "finish_at" => $request->end
            ]);
        } else {
            Countdown::where("name", "Countdown Pre Order")->update([
                "started_at" => $request->start,
                "finish_at" => $request->end
            ]);
        }

        // return redirect()
    }

    public function edit($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        Countdown::where("id", $id)->update([
            "name" => $request->name,
            "started_at" => $request->started_at,
            "finish_at" => $request->finish_at
        ]);
        // return redirect()
    }

    public function destroy()
    {
        Countdown::latest()->delete();
    }
}
