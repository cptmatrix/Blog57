<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\Post;
use App\Model\Tag;
use Carbon\Carbon;
use App\Services\PostService;

class BlogController extends Controller
{

    public function index(Request $request)
    {
        $tag=$request->get('tag');
        $postService=new PostService($tag);
        $posts=$postService->lists();
        $layout=$tag?Tag::layout($tag):'blog.layouts.index';
        return view($layout,$posts);
    }

    public function showPost($slug,Request $request){
        $post=Post::with('tags')->where('slug',$slug)->firstOrFail();
        $tag=$request->get('tag');
        if($tag){
            $tag=Tag::where('tag',$tag)->firstOrFail();
        }
        return view('blog.layouts.post',compact(['tag','post']));
//        return view($post->layout,compact(['tag','post']));
    }


}
