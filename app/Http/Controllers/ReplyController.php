<?php

namespace App\Http\Controllers;

use App\Models\Reply;
use Illuminate\Http\Request;
use Auth;
use Illuminate\Support\Facades\DB;
class ReplyController extends Controller
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
        
        $data= new Reply();
        $data['user_id'] = Auth::id();
        $data['blog_id'] = $request->blog_id;
        $data['comment_id'] = $request->comment_id;
        $data['comment_reply'] = $request->comment_reply;
        $data['reply_user'] = Auth::user()->name;
        $data->save();
        return redirect()->back()->with('message', 'Reply Added Successfully!');
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Reply  $reply
     * @return \Illuminate\Http\Response
     */
    public function show(Reply $reply)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Reply  $reply
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, Reply $reply)
    {
        $reply_id = $request->id;
        $updated_reply = Reply::where('id',$reply_id)->first();
        return response()->json([
            'updated_reply' => $updated_reply,
         ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Reply  $reply
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Reply $reply)
    {
        $id =$request->id;
        $reply_comment =$request->comment_reply;
        DB::table("replies")->where('id', $id)->update(['comment_reply' => $reply_comment]);
        return redirect()->back()->with('message', 'Reply Updated Successfully!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Reply  $reply
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Reply $reply)
    {
        $reply_id = $request->id;
        $reply = Reply::find($reply_id);
        if($reply->delete()){
            return redirect()->back()->with('message', 'Reply Deleted Successfully!');
        }
        else{
            return redirect()->back()->with('message', 'Something Went Wrong!');
        }
        
    }
}
