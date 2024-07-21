<?php

namespace App\Http\Controllers;

use App\Models\Visitor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Inertia\Inertia;

class VisitorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {

        $visitorList = Visitor::filter($request->only('search'))->orderBy('name','asc')->paginate(5)->withQueryString();
        return Inertia::render('Dashboard', [ 
            'visitorList' => $visitorList, 
            'filters' => $request->all('search'),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        return Inertia::render('Visitors/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'name' => 'required',
            'mobile' => 'required|digits:10|numeric|unique:visitors,mobile',
            'age'   => 'numeric|nullable',
            'gender' => 'required',
        ]);
        if($validator->fails())
            return redirect()->back()->withErrors($validator->errors());

        $visitor = new Visitor();
        $visitor->name = $request->name;
        $visitor->mobile = $request->mobile;
        $visitor->age = $request->age;
        $visitor->gender = $request->gender;
        $visitor->address = $request->address;
        $visitor->save();

        return back()->with('success','Visitor was saved successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Visitor $visitor)
    {
        return Inertia::render('Visitors/Edit',['visitor' => $visitor]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Visitor $visitor)
    {
        $validator = Validator::make($request->all(),[
            'name' => 'required',
            'mobile' => 'required|digits:10|numeric|unique:visitors,mobile,' . $visitor->id,
            'age'   => 'numeric|nullable',
            'gender' => 'required',
        ]);
        if($validator->fails())
            return redirect()->back()->withErrors($validator->errors());

        $visitor->name = $request->name;
        $visitor->mobile = $request->mobile;
        $visitor->age = $request->age;
        $visitor->gender = $request->gender;
        $visitor->address = $request->address;
        $visitor->save();

        return back()->with('success','Visitor was saved successfully');
        
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Visitor $visitor)
    {
        $visitor->delete();
        return back()->with('success','Visitor was deleted successfully');
    }
}
