<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use App\Models\Comment;
use App\Models\Reply;
use Illuminate\Http\Request;
use App\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use \Cviebrock\EloquentSluggable\Services\SlugService;
class BlogController extends Controller
{
    /**
     * Display a listing of the resource.
     * 
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $search = $request['search'] ?? "";
        $category = $request['category'] ?? "";
        if($search != ""){
            $blog = Blog::where('title', 'LIKE', "%{$search}%")
            ->paginate(3);
        }
        else if($category != ""){
            $blog = Blog::where('category',$category)->paginate(3);
        }
        else{
            $blog = Blog::orderBy('created_at', 'desc')->paginate(3);
        }
        return view('dashboard', compact(['blog','search']));
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
        $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string' , 'max:5000'],
            'category' => ['required', 'string' , 'max:255'],
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
        $data= new Blog();
        $data['title'] = $request->title;
        $data['description'] =$request->description;
        $data['category'] = $request->category;
        $data['slug'] = SlugService::createSlug(Blog::class, 'slug', $request->title,['unique' => true]);
        $data['allow_comment'] = $request->allow_comment ?? 0;
        
        if($request->file('image')){
            
            $file= $request->file('image');
            $filename= date('YmdHi').$file->getClientOriginalName();
            // dd($filename);
            $file-> move(public_path('images'), $filename);
            // dd(public_path(), $filename, $file);
            $data['image']= $filename;
        }
        $data->save();
        
                

        return redirect()->back()->with('message', 'Post Added Successfully!');



        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Blog  $blog
     * @return \Illuminate\Http\Response
     */
    public function show(Blog $blog)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Blog  $blog
     * @return \Illuminate\Http\Response
     */
    public function edit(Blog $blog, Request $request)
    {

        $blog_id = $request->id;
        $blog = Blog::find($blog_id);
        return response()->json([
            'up_blog' => $blog,
             
         ]);
        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Blog  $blog
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Blog $blog)
    {
        $data= new Blog();
        $prev_img = Blog::find($request->id);
        $id =$request->id;
        $title =$request->title;
        $description =$request->description;
        $category =$request->category;
        $allow_comment =$request->allow_comment;
        if($request->file('image')){
            $file= $request->file('image');
            $filename= date('YmdHi').$file->getClientOriginalName();
            $file-> move(public_path('images'), $filename);
            $data['image']= $filename;

            $blogImage = public_path("images/{$prev_img->image}"); 
            if (File::exists($blogImage)) { 
                unlink($blogImage);
            }

            $data= DB::table("blogs")->where('id', $id)->update(['title' => $title, 'description'=>$description, 'category'=>$category, 'image'=>$data['image'], 'allow_comment'=>$allow_comment]);
        }
        else{
            $data= DB::table("blogs")->where('id', $id)->update(['title' => $title, 'description'=>$description, 'category'=>$category, 'allow_comment'=>$allow_comment]);
        }
        return redirect()->back()->with('message', 'Post Updated Successfully!');
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Blog  $blog
     * @return \Illuminate\Http\Response
     */
    public function destroy(Blog $blog, Request $request)
    {
        $blog_id = $request->id;
        $blog = Blog::find($blog_id);
        if($blog->delete()){
            return redirect()->back()->with('message', 'Post Deleted Successfully!');
        }
        else{
        return redirect()->back()->with('message', 'Something Went Wrong!');
        }
    }
}
