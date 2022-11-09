<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
/* include */
use App\Models\Post;
use App\Models\Comment;

class PostController extends Controller
{
    /* -- Add post ---------------------------------------------------------------------*/
    public function addPost(Request $request)
    {
        $request->validate([
            'title' => 'required|max:64',
            'content' => 'required'
        ]);
        return Post::create($request->all());
    }
    /* ------------------------------------------------------------------------------- */

    /* -- Add comment ---------------------------------------------------------------- */
    public function addComment(Request $request, $id)
    {
        $post = Post::find($id);
        /* if post is not found */
        if ($post == null) {
            return response()->json([
                'Post not found!'
            ], 404);
        }
        $request->validate([
            'comment' => 'required'
        ]);

        $comment = new Comment();
        $comment->comment = $request->comment;
        $post->comments()->save($comment);
        return response()->json([
            'Comment added to post!'
        ], 200);
    }
    /* ------------------------------------------------------------------------------- */

    /* -- Get comment by post ID ----------------------------------------------------- */
    public function getCommentsByPost($id)
    {
        $post = Post::find($id);

        if ($post == null) {
            return response()->json([
                'Post not found!'
            ], 404);
        }

        $comments = Post::find($id)->comments;
        return $comments;
    }
    /* ------------------------------------------------------------------------------- */

    /* -- Get post with ID ----------------------------------------------------------- */
    public function getPostsById($id)
    {
        $post = Post::find($id);

        if ($post != null) {
            return $post;
        } else {
            return response()->json([
                'Post not be found!'
            ], 404);
        }
    }
    /* ------------------------------------------------------------------------------- */

        /* -- Get all comments -------------------------------------------------------------- */
        public function getComments()
        {
            $post = Post::all();
            if ($post != null) {
    
                return $post;
            } else {
                return response()->json([
                    'Post table is empty!'
                ], 404);
            }
        }

    /* -- Get all posts -------------------------------------------------------------- */
    public function getPosts()
    {
        $post = Post::all();
        if ($post != null) {

            return $post;
        } else {
            return response()->json([
                'Post table is empty!'
            ], 404);
        }
    }
    /* ------------------------------------------------------------------------------- */

    /* -- Delete comment by id ------------------------------------------------------- */
    public function deleteComment($id)
    {
        //delete entry
        $comment = Comment::find($id);
        //validation messeges
        if ($comment != null) {
            $comment->delete();
            return response()->json([
                'Comment deleted!'
            ]);
        } else {
            return response()->json([
                'Comment not found!'
            ], 404);
        }
    }
    /* ------------------------------------------------------------------------------- */

    /* -- Delete post by id ---------------------------------------------------------- */
    public function deletePost($id)
    {
        //deletPost
        $post = Post::find($id);
        //validation messeges
        if ($post != null) {
            $post->delete();
            return response()->json([
                'Post deleted!'
            ]);
        } else {
            return response()->json([
                'Post not found!'
            ], 404);
        }
    }
    /* ------------------------------------------------------------------------------- */

    /* -- Update post by id ---------------------------------------------------------- */
    public function updatePost(Request $request, $id)
    {
        //validation for update, response feedback if you fail to enter correct data
        $request->validate([

            'title' => '|max:64',
            'content' => 'required'

        ]);

        //update post
        $post = Post::find($id);
        //validation messeges
        if ($post != null) {
            $post->update($request->all());
            return $post;
        } else {
            return response()->json([
                'Post not found!'
            ], 404);
        }
    }
    /* ------------------------------------------------------------------------------- */

    /* --- Update comment by id ------------------------------------------------------ */
    public function updateComment(Request $request, $id)
    {
        //validation for update, response feedback if you fail to enter correct data
        $request->validate([

            'comment' => 'required'
        ]);

        //update product post
        $comment = Comment::find($id);
        //validation messeges
        if ($comment != null) {
            $comment->update($request->all());
            return $comment;
        } else {
            return response()->json([
                'Post not found!'
            ], 404);
        }
    }

    /* ------------------------------------------------------------------------------- */
}
