<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use App\Models\Category;
use App\Models\Comment;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;

class BlogController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Builder[]|Collection|Response
     */
    public function index()
    {
        return Blog::with(['comments', 'comments.user', 'categories'])
                   ->where('user_id', auth()->user()->id)
                   ->latest()
                   ->get();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     *
     * @return array
     */
    public function store(Request $request) : array
    {
        $file = $request->file('image');
        Storage::disk('public')->putFileAs('/', $file, $file->hashName());

        $blog = new Blog;
        $blog->fill($request->only('title', 'content'));
        $blog->user()->associate(auth()->user());
        $blog->image = '/storage/' . $file->hashName();

        if (!$blog->save()) {
            return ['success' => false, 'message' => __('api.save_failed')];
        }

        $category = Category::find($request->get('categories'));
        $blog->categories()->sync($category);

        return ['success' => true, 'message' => __('api.save_success')];
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     *
     * @return Blog|Builder|Model
     */
    public function show(int $id)
    {
        return Blog::with([
            'comments',
            'comments.user',
            'categories'
        ])->where([
            'id'      => $id,
            'user_id' => auth()->user()->id
        ])->firstOrFail();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param int     $id
     *
     * @return array
     */
    public function update(Request $request, int $id) : array
    {
        $file = $request->file('image');

        $blog = Blog::find($id);
        $blog->fill($request->only('title', 'content'));

        $category = Category::find($request->get('categories'));
        $blog->categories()->sync($category);

        if ($file) {
            Storage::disk('public')->putFileAs('/', $file, $file->hashName());
            $blog->image = '/storage/' . $file->hashName();
        }

        if (!$blog->save()) {
            return ['success' => false, 'message' => __('api.save_failed')];
        }

        return ['success' => true, 'message' => __('api.save_success')];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $blog = Blog::find($id);
        $blog->delete();
    }

    /**
     * Get all blog
     *
     * @return Blog[]|Collection
     */
    public function all()
    {
        return Blog::all();
    }

    /**
     * Add comment to blog
     *
     * @param Request $request
     * @param int     $id
     *
     * @return array
     */
    public function comment(Request $request, int $id)
    {
        $blog = Blog::find($id);

        $comment = new Comment;
        $comment->content = $request->get('comment');
        $comment->blog()->associate($blog);
        $comment->user()->associate(auth()->user());

        if (!$comment->save()) {
            return ['success' => false, 'message' => __('api.save_failed')];
        }

        return ['success' => true, 'message' => __('api.save_success')];
    }
}
