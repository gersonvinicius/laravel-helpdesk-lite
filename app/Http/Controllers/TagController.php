<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class TagController extends Controller
{
    public function index(): View
    {
        $tags = Tag::withCount('tickets')->orderBy('name')->get();

        return view('tags.index', compact('tags'));
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'name'  => ['required', 'string', 'max:50', 'unique:tags,name'],
            'color' => ['required', 'string', 'in:indigo,blue,green,yellow,red,orange,purple,pink'],
        ]);

        Tag::create($data);

        return back()->with('success', 'Tag criada.');
    }

    public function update(Request $request, Tag $tag): RedirectResponse
    {
        $data = $request->validate([
            'name'  => ['required', 'string', 'max:50', 'unique:tags,name,' . $tag->id],
            'color' => ['required', 'string', 'in:indigo,blue,green,yellow,red,orange,purple,pink'],
        ]);

        $tag->update($data);

        return back()->with('success', 'Tag atualizada.');
    }

    public function destroy(Tag $tag): RedirectResponse
    {
        $tag->delete();

        return back()->with('success', 'Tag excluída.');
    }
}
