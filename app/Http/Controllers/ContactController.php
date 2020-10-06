<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Contact;
use App\Activity_Log;

class ContactController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $contacts = Contact::all();
        return view('contacts.index', compact('contacts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('contacts.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'first_name'=>'required',
            'last_name'=>'required',
            'email'=>'required',
            'notes'=>'nullable',
            'image'=>'image|nullable|max:1999'
        ]);

        //Handle FIle Upload
        if($request->hasfile('image')) {
            $filenameWithExt = $request->file('image')->getClientOriginalName();
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            $extension = $request->file('image')->getClientOriginalExtension();
            $filenameStore= $filename.'_'.time().'.'.$extension;
            $path = $request->file('image')->storeAs('public/images', $filenameStore);
        }
        else {
            $filenameStore = '';
        }

        $contact = new Contact([
            'first_name' => $request->get('first_name'),
            'last_name' => $request->get('last_name'),
            'email' => $request->get('email'),
            'number' => $request->get('number'),
            'address' => $request->get('address'),
            'notes' => $request->get('notes')
        ]);
        $contact->image= $filenameStore; 
        
        $activity_logs = new Activity_Log([
            'status' => "Created Contact Info"
        ]);
        $contact->save();
        $activity_logs->id_modified = $contact->id;
        $activity_logs->save();
        return redirect('/contacts')->with('success', 'Contact saved!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $contact = Contact::find($id);
        return view('contacts.edit', compact('contact'));  
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'first_name'=>'required',
            'last_name'=>'required',
            'email'=>'required',
            'notes'=>'nullable',
            'image'=>'image|nullable|max:1999'
        ]);

        if($request->hasfile('image')) {
            $filenameWithExt = $request->file('image')->getClientOriginalName();
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            $extension = $request->file('image')->getClientOriginalExtension();
            $filenameStore= $filename.'_'.time().'.'.$extension;
            $path = $request->file('image')->storeAs('public/images', $filenameStore);
        }

        $contact = Contact::find($id);
        $contact->first_name =  $request->get('first_name');
        $contact->last_name = $request->get('last_name');
        $contact->email = $request->get('email');
        $contact->number = $request->get('number');
        $contact->address = $request->get('address');
        $contact->notes = $request->get('notes');
        if($request->hasfile('image')) 
        {
            $contact->image= $filenameStore;
        }
        // $contact->save();
        
        $activity_logs = new Activity_Log([
            'status' => "Updated Contact Info"
        ]);
        $contact->save();
        $activity_logs->id_modified = $contact->id;
        $activity_logs->save();
        return redirect('/contacts')->with('success', 'Contact updated!');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $contact = Contact::find($id);
        
        if($contact->image != '')
        {
            //Delete Image
            Storage::delete('public/images/'.$contact->image);
        }
        $activity_logs = new Activity_Log([
            'status' => "Deleted Contact Info"
        ]);
        $activity_logs->id_modified = $contact->id;
        $activity_logs->save();
        $contact->delete();
        return redirect('/contacts')->with('success', 'Contact deleted!');

    }
}
