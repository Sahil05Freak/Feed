<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Feed;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

class FeedController extends Controller
{
    //
    public function index()
    {
        $images = Feed::all();
        return view('feeds.blogs', compact('images'));
    }

    public function create()
    {
        return view('feeds.create');
    }

    public function store(Request $request)
    {
        // Validation
        $validator = Validator::make($request->all(), [
            'title' => ['required', 'string'],
            'description' => ['nullable', 'string'],
            'image' => ['required', 'image', 'mimes:jpeg,png,jpg,gif', 'max:5000'],
        ]);

        if ($validator->fails()) {
            return redirect()->route('feeds.create')
                ->withErrors($validator)
                ->withInput();
        }

        $imagePath = $request->file('image')->store('images', 'public');

        Feed::create([
            'title' => $request->input('title'),
            'description' => $request->input('description'),
            'image_path' => 'storage/' . $imagePath,
        ]);

        return redirect()->route('dashboard')->with('success', 'Image uploaded successfully.');
    }

    public function edit(Feed $image)
    {
        return view('feeds.edit', compact('image'));
    }

    public function update(Request $request, Feed $image)
    {
        // Validation
        $validator = Validator::make($request->all(), [
            'title' => ['required', 'string'],
            'description' => ['nullable', 'string'],
            'image' => ['image', 'mimes:jpeg,png,jpg,gif', 'max:5000'],
        ]);

        if ($validator->fails()) {
            return redirect()->route('feeds.edit')
                ->withErrors($validator)
                ->withInput();
        }

        $update = [
            'title' => $request->input('title'),
            'description' => $request->input('description'),
        ];
        if($request->file('image')) {
            $imagePath = $request->file('image')->store('images', 'public');
            $update['image_path'] = 'storage/' . $imagePath;
        }

        $image->update([
            'title' => $request->input('title'),
            'description' => $request->input('description'),
            'image_path' => 'storage/' . $imagePath,
        ]);

        return redirect()->route('dashboard')->with('success', 'Image updated successfully.');
    }

    public function destroy(Feed $image)
    {
        // Delete the image file from storage if needed
        Storage::disk('public')->delete($image->image_path);

        // Delete the image record from the database
        $image->delete();

        return redirect()->route('dashboard')->with('success', 'Image deleted successfully.');
    }
}
