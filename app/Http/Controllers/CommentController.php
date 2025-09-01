<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Reply;
use Illuminate\Http\Request;
use Auth;
use DB;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Session;
class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }
    public function checkauth(){
            $flag = 1;
            Session::put('flag', $flag);
            return redirect()->route('login');
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
        // dd($request->all());
        $data= new Comment();
        $data['user_id'] =Auth::id();
        $data['blog_id'] =$request->blog_id;
        $data['blog_comment'] =$request->comment;
        $data['username'] =Auth::user()->name;
        $data->save();
        return response()->json([
            "data" => $data,
            "message" => "Your Comment is placed Sucessfully!",
            "status" => 200,
         ]);
        // return redirect()->back()->with('message', 'Comment Posted Successfully!');
       
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
    public function edit(Comment $comment,Request $request)
    {
        $commnet_id = $request->id;
        $updated_comment = Comment::where('id',$commnet_id)->first();
        return response()->json([
            'updated_comment' => $updated_comment,
             
         ]);
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
        $id =$request->id;
        $blog_comment =$request->comment;
        DB::table("comments")->where('id', $id)->update(['blog_comment' => $blog_comment]);
        return redirect()->back()->with('message', 'Comment Updated Successfully!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function destroy(Comment $comment, Request $request)
    {
        $comment_id = $request->id;
        $comment = Comment::find($comment_id);
        if($comment->delete()){
            return redirect()->back()->with('message', 'Comment Deleted Successfully!');
        }
        else{
            return redirect()->back()->with('message', 'Something Went Wrong!'); 
        }
    }
}
