<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Comment;

class CommentController extends Controller
{
    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     *
     * @return array
     */
    public function destroy(int $id) : array
    {
        $comment = Comment::find($id);

        if (!$comment->delete()) {
            return ['success' => false, 'message' => __('api.delete_failed')];
        }

        return ['success' => true, 'message' => __('api.delete_success')];
    }
}
