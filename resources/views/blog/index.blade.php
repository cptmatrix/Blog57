<html>
<head>
    <title>Laravel Blog </title>
    <link href="{{asset('css/app.css')}}" rel="stylesheet">
</head>
<body>
<div class="container">
    <h1>Laravel Blog</h1>
    <h5>Page{{ $posts->currentPage() }} of {{ $posts->lastPage() }}</h5>
    <hr>
        <ul>
            @foreach ($posts as $post)
            <li>
                <a href="{{route('blog.detail',['slug'=>$post->slug])}}">{{$post->title}}</a>
                <em>{{$post->publish_at}}</em>
                <p>
                    {{str_limit($post->content)}}
                </p>
            </li>
                @endforeach
        </ul>
    <hr>
    {!! $posts->render() !!}
</div>
</body>
</html>