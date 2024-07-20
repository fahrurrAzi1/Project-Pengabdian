<?php

namespace App\Http\Controllers;

use App\Models\Content;
use Illuminate\Http\Request;

class GuruController extends Controller
{
    public function index()
    {
        $contents = Content::all();

        return view('guru.dashboard', compact('contents'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'content' => 'required|string',
        ]);
        
        $content = Content::findOrFail($id);
        $content->body = $request->input('content');
        $content->save();

        return redirect()->back()->with('success', 'Content updated successfully.');
    }

    public function destroy($id)
    {
        $content = Content::findOrFail($id);
        $content->delete();

        return redirect()->back()->with('success', 'Content deleted successfully.');
    }
}
