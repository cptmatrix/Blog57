@extends('admin.layout')
    @section('content')
        <div class="container">
            <div class="row page-title-row ">
                <div class="col-md-6">
                    <h3>
                        >><small>列表</small>
                    </h3>
                </div>
                <div class="col-md-6 text-right">
                    <a class="btn btn-success btn-md " href="/admin/post/create">
                        <i class="fa fa-plus-circle "></i>
                        创建新文章
                    </a>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-12">
                    @include('admin.partials.errors')
                    @include('admin.partials.success')
                    <table id="post_tables" class="table table-striped table-bordered">
                        <thead>
                            <th>发布时间</th>
                            <th>标题 </th>
                            <th> 副标题</th>
                            <th>操作</th>
                        </thead>
                        <tbody>

                        @foreach($posts as $post)
                            {{--{{dd($post)}}--}}
                            <tr>
                                <td data-order="{{$post->publish_at->timestamp}}">{{$post->publish_at->format('Y-m-d G:i:s')}}</td>
                                <td>{{$post->title}}</td>
                                <td>{{$post->subtitle}}</td>
                                <td style="display:inline-block">
                                    <a href="/admin/post/{{$post->id}}/edit" class="btn btn-xs btn-info" style="display:inline-block">
                                        <i class="fa fa-edit"></i>
                                        编辑
                                    </a>
                                    <a href="/blog/{{$post->slug}}" class="btn btn-xs btn-warning " style="display:inline-block">
                                        <i class="fa fa-eye"></i>
                                        查看
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

@stop

@section('scripts')
    <script>
        $('#post_tables').dataTable({
            order:[[0,'desc']]
        });
    </script>
    @stop