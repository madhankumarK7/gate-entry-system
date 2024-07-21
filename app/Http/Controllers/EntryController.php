<?php

namespace App\Http\Controllers;

use App\Models\Gate;
use Inertia\Inertia;
use App\Models\Entry;
use App\Models\Visitor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class EntryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $entryQuery = Entry::with(['gate','visitor']);
        
        if ($request->filled('start_date') && $request->filled('end_date')) {
            $startDate = $request->input('start_date') . ' 00:00:00';
            $endDate = $request->input('end_date') . ' 23:59:59';
            $entryQuery->where(function($query) use($startDate,$endDate){
                $query->whereBetween('entry_time', [$startDate, $endDate])
                ->orWhereBetween('exit_time', [$startDate, $endDate]);
            });
        }

        if ($request->filled('gate')) {
            $gate = $request->input('gate');
            $entryQuery->where('gate_id', $gate);
        }

        if ($request->filled('visitor')) {
            $visitor = $request->input('visitor');
            $entryQuery->where('visitor_id', $visitor);
        }        
        $entryList = $entryQuery->orderBy('created_at','desc')->paginate(5)->withQueryString();

        $gateList = Gate::get();
        $visitorList = Visitor::get();
        
        $entryList->getCollection()->transform(function ($entry) {
            return [
                'id' => $entry->id,
                'name' => $entry->visitor->name,
                'gate_name' => $entry->gate->name,
                'formatted_entry_time' => $entry->formatted_entry_time,
                'formatted_exit_time' => $entry->formatted_exit_time,
            ];
        });        

        return Inertia::render('Entry/Index', [ 
            'entryList' => $entryList, 
            'gateList' => $gateList, 
            'visitorList' => $visitorList,
            'filters' => $request->only(['start_date', 'end_date', 'gate', 'visitor']),
        ]); 
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $gateList = Gate::get();
        $visitorList = Visitor::selectRaw('id, name, mobile, CONCAT(name, " ", mobile) as full_name')->orderBy('name')->get();
        

        return Inertia::render('Entry/Create', ['gateList' => $gateList, 'visitorList' => $visitorList ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'visitor_id' => 'required',
            'gate_id' => 'required',
            'entry_time'   => 'required|date',
            'exit_time' => 'nullable|date',
        ],[
            'visitor_id.required' => 'Please select any visitor',
            'gate_id.required' => 'Please select any gate',
        ]);
        if($validator->fails())
            return redirect()->back()->withErrors($validator->errors());

        $entry = new Entry();
        $entry->visitor_id = $request->visitor_id;
        $entry->gate_id = $request->gate_id;
        $entry->entry_time = $request->entry_time;
        $entry->exit_time = $request->exit_time;
        $entry->save();

        return back()->with('success','Entry was saved successfully');

    }

    /**
     * Display the specified resource.
     */
    public function show(Entry $entry)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Entry $entry)
    {
        $gateList = Gate::get();
        $visitorList = Visitor::selectRaw('id, name, mobile, CONCAT(name, " ", mobile) as full_name')->orderBy('name')->get();

        $entry->entry_time_formatted = $entry->entry_time ? $entry->entry_time->format('Y-m-d\TH:i') : null;
        $entry->exit_time_formatted = $entry->exit_time ? $entry->exit_time->format('Y-m-d\TH:i') : null;
        //dd($entry);
        return Inertia::render('Entry/Edit',['entry' => $entry, 'gateList' => $gateList, 'visitorList' => $visitorList ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Entry $entry)
    {
        $validator = Validator::make($request->all(),[
            'visitor_id' => 'required',
            'gate_id' => 'required',
            'entry_time'   => 'required|date',
            'exit_time' => 'nullable|date',
        ],[
            'visitor_id.required' => 'Please select any visitor',
            'gate_id.required' => 'Please select any gate',
        ]);
        if($validator->fails())
            return redirect()->back()->withErrors($validator->errors());

        $entry->visitor_id = $request->visitor_id;
        $entry->gate_id = $request->gate_id;
        $entry->entry_time = $request->entry_time;
        $entry->exit_time = $request->exit_time;
        $entry->save();

        return back()->with('success','Entry was updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Entry $entry)
    {
        $entry->delete();
        return back()->with('success','Entry was deleted successfully');

    }
}
