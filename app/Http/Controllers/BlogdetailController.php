<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use App\Models\User;
use Illuminate\Http\Request;
use App\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\URL;
class BlogdetailController extends Controller
{
    public function index(Request $request){
        Session::put('redirect', URL::full());
        $slug = $request->slug;
        $search = $request['search'] ?? "";
        $blog = Blog::with('comments.replies')->where('slug', $slug)->first();
        return view('blogdetail', compact(['blog','search']));
    }

    public function manageblog(){
        $manageblog = Blog::paginate(5);
        return view('manageblog', compact(['manageblog']));
    }
}
