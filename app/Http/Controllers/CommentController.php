<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $all_comments = Comment::orderBy('id','desc')->get();
        foreach ($all_comments as $comment){
            if ($comment->parent_id == null){
                $root_comment[] = $comment;
            }
        }
        $comment = self::commentsTree($root_comment,$all_comments);
        return response()->json($comment);

    }
    private static function commentsTree($root_comments,$all_comments){
        foreach ($root_comments as $comment){
            $comment->replies = $all_comments->where('parent_id', $comment->id);
            foreach ($comment->replies as $reply){
                $reply->replies = $all_comments->where('parent_id',$reply->id);
            }
        }
        return $root_comments;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validated = $request->validate([

            'name' => 'required|string|min:3',
            'comment' => 'required|string|max:1500',
        ]);

        $comment = Comment::create($request->all());
        return response()->json([
            'message'=>'Comment Created Successfully!!',
            'comment'=>$comment
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function show(Comment $comment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function edit(Comment $comment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Comment $comment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function destroy(Comment $comment)
    {
        //
    }
}
