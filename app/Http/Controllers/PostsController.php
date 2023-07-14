<?php

namespace App\Http\Controllers;

use App\Http\Requests\PostFormRequest;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PostsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('blog.index', [
            'posts' => Post::orderBy('updated_at', 'desc')->get()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('blog.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PostFormRequest $request)
    {
        $request->validated();

        Post::create([
            'title' => $request->title,
            'excerpt' => $request->excerpt,
            'body' => $request->body,
            'image_path' => $this->storeImage($request),
            'is_published' => $request->is_published === 'on',
            'min_to_read' => $request->min_to_read
        ]);

        session()->flash('success', 'Post Created Successfully!');

        return redirect(route('blog.index'));
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return view('blog.show', [
            'post' => Post::findOrFail($id) // throw exception if not find matching results
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        return view('blog.edit', [
            'post' => Post::where('id', $id)->first()
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PostFormRequest $request, string $id)
    {
        $request->validated();

        Post::where('id', $id)->update(
            $request->is_published === 'on'
                ? array_replace($request->except('_token', '_method'), ['is_published' => true])
                : array_replace($request->except('_token', '_method'), ['is_published' => false])
        );

        session()->flash('update-post', 'Post has been updated.');

        return redirect(route('blog.index'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Post::destroy($id);

        session()->flash('delete-post', 'Post has been deleted.');

        return redirect(route('blog.index')); //->with('message', 'Post has been deleted.');
    }

    private function storeImage(Request $request)
    {
        if ($request->image) {
            $newImageName = uniqid() . '-' . $request->title . '.' . $request->image->extension();
            $newImageName = preg_replace('/[[:space:]]+/', '-', $newImageName);

            return $request->image->move(public_path('images'), $newImageName);
        }
    }
}
