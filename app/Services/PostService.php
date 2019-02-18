<?php

namespace App\Services;
use App\Model\Tag;
use App\Model\Post;
use Carbon\Carbon;

class PostService
{

    public function __construct($tag)
    {
        $this->tag=$tag;
    }

    public function lists(){
        if($this->tag){
            return $this->showTagIndexPage($this->tag);
        }else{
            return $this->showSimplePage();
        }
    }

    public function showSimplePage(){
        $posts=Post::with('tags')->
            where('created_at','<=',Carbon::now())
            ->where('is_draft',0)
            ->orderBy('publish_at','desc')
            ->simplePaginate(config('blog.posts_per_page'));
        return [
          'posts'=>$posts,
          'title'=>config('blog.title'),
          'subtitle'=>config('blog.subtitle'),
          'page_image'=>config('blog.page_image'),
          'meta_description'=>config('blog.meta_description'),
          'reverse_direction'=>false,
          'tag'=>null,
        ];
    }

    public function showTagIndexPage($tag){
        $tag=Tag::where('tag',$tag)->firstOrFail();
        $reverse_direction=(bool)$tag->reverse_direction;
        $posts=Post::whereHas('tags',function($query)use($tag){
           $query->where('tag',$tag)->find();
        })->where('published_at','<=',Carbon::now())
            ->where('is_draft',0)
            ->orderBy('publish_at',$reverse_direction)
            ->simplePaginate(config('blog.posts_per_page'));
        $posts->appends('tag',$tag->tag);
        $page_image=$tag->page_image??config('blog.page_image');
        $meta_description=$tag->meta_description;
        return [
            'posts'=>$posts,
            'title'=>$tag->titile,
            'subtitle'=>$tag->subtitle,
            'page_image'=>$page_image,
            'tag'=>$tag,
            'reverse_direction'=>$reverse_direction,
            'meta_description'=>$meta_description,
        ];
    }
}