@extends('blog.layouts.master',[
'title'=>$post->title,
'meta_description'=>$post->meta_description?? config('blog.meta_description'),
])

@section('page-header')
    <header class="masthead" style="background-image: url('{{page_image($post->page_image)}}')">
        <div class="overlay"></div>
        <div class="container">
            <div class="row">
                <div class="col-md-10 col-lg-8 mx-auto">
                    <div class="post-heading">
                        <h1>{{$post->title}}</h1>
                        <h2 class="subheading">{{$post->subtitle}}</h2>
                        <span class="meta">
                            Post on {{$post->publish_at->format('Y-m-d')}}
                            @if($post->tags->count())
                                in
                                {!! join(',',$post->tagLinks()) !!}
                                @endif
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </header>
    @stop

@section('content')
        <div class="container">
            <div class="row">
                <div class="col-md-10 col-lg-8 mx-auto">
                  {{--文章详情--}}
                    <article>
                        {!! $post->content_html !!}
                    </article>
                    <hr>
                    {{--last next paginator--}}
                    <div class="clearfix">
                        @if($tag && $tag->reverse_direction)
                            @if($post->olderPost($tag))
                                <a href="{!! $post->olderPost($tag)->url($tag) !!}" class="btn btn-primary float-left">
                                    ←
                                    Previous {{ $tag->tag }} Post
                                </a>
                                @endif
                            @if($post->newerPost($tag))
                                <a href="{!! $post->newerPost($tag)->url($tag) !!}" class="btn btn-primary float-right">
                                    Next {{ $tag->tag }} Post
                                    →
                                </a>
                                @endif
                        @elseif($tag)
                            @if ($post->newerPost($tag))
                                <a class="btn btn-primary float-left" href="{!! $post->newerPost($tag)->url($tag) !!}">
                                    ←
                                    Newer {{ $tag ? $tag->tag : '' }} Post
                                </a>
                            @endif
                            @if ($post->olderPost($tag))
                                <a class="btn btn-primary float-right" href="{!! $post->olderPost($tag)->url($tag) !!}">
                                    Older {{ $tag ? $tag->tag : '' }} Post
                                    →
                                </a>
                            @endif
                        @endif
                    </div>
                </div>
            </div>
        </div>
    @stop
