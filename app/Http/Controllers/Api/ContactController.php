<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Contact;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ContactController extends Controller
{
    public function index(Request $request)
    {
        $contacts = $request->user()->contacts;

        return response()->json(['contacts' => $contacts]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email',
            'phone' => 'required',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            // 'image' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }

        $contact = new Contact;
        $contact->name = $request->input('name');
        $contact->email = $request->input('email');
        $contact->phone = $request->input('phone');
        // $contact->user_id = $request->user()->id;
        $contact->user_id = Auth::user()->id;

        // Handle image upload
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('images'), $imageName);
            $contact->image = $imageName;
        }

        $contact->save();

        return response()->json(['contact' => $contact]);
    }

    public function show(Request $request, $id)
    {
        $contact = $request->user()->contacts()->findOrFail($id);

        return response()->json(['contact' => $contact]);
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email',
            'phone' => 'required',
            'image' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }

        $contact = $request->user()->contacts()->findOrFail($id);
        $contact->name = $request->input('name');
        $contact->email = $request->input('email');
        $contact->phone = $request->input('phone');

        // Handle image upload
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('images'), $imageName);
            $contact->image = $imageName;
        }

        $contact->save();

        return response()->json(['contact' => $contact]);
    }

    public function destroy(Request $request, $id)
    {
        $contact = $request->user()->contacts()->findOrFail($id);
        $contact->delete();

        return response()->json(['message' => 'Contact deleted successfully']);
    }

    public function addToFavorites(Request $request, $id)
    {
        $contact = $request->user()->contacts()->findOrFail($id);

        if (!$contact->favorite) {
            $contact->favorite = true;
            $contact->save();
        }

        return response()->json(['contact' => $contact]);
    }

    public function removeFromFavorites(Request $request, $id)
    {
        $contact = $request->user()->contacts()->findOrFail($id);

        if ($contact->favorite) {
            $contact->favorite = false;
            $contact->save();
        }

        return response()->json(['contact' => $contact]);
    }
}
