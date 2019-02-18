@extends('admin.layout')
@section('css')
    <link href="{{ asset('css/selectize.default.css')}}" rel="stylesheet"/>
    <link href="{{ asset('css/pickadate.min.css')}}" rel="stylesheet"/>
@stop
@section('content')
<div class="container">
    <div class="row page-title-row">
        <div class="col-md-12">
            <h3>
                <small>>>修改文章</small>
            </h3>
        </div>
    </div>
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">
                            文章修改表单
                        </h3>
                    </div>
                    <div class="card-body">
                        @include('admin.partials.errors')
                        @include('admin.partials.success')
                        <form action="{{route('post.update',$id)}}" method="post">
                            <input type="hidden" name="_token" value="{{csrf_token()}}"/>
                            <input type="hidden" name="_method" value="PUT"/>
                            @include('admin.post._form')
                            <div class="row">
                                <div class="col-md-8">
                                    <div class="form-group row">
                                        <div class="col-md-8 offset-md-4">
                                            <button class="btn btn-success"  type="submit" name="action" value="continue">
                                                <i class="fa fa-floppy-o"></i>
                                                保存-继续
                                            </button>
                                            <button class="btn  btn-success" type="submit" name="action" value="finished">
                                                <i class="fa fa-floppy-o"></i>
                                                保存-完成
                                            </button>
                                            <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#modal-delete">
                                                <i class="fa fa-times-circle"></i>
                                                删除
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="modal-delete" tabIndex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <div class="modal-title">请确认</div>
                        <button type="button" class="close" data-dismiss="modal">
                            x
                        </button>
                    </div>
                    <div class="modal-body">
                        <p class="lead">
                            <i class="fa fa-question-circle fa-lg"></i>
                            请确认是否删除?
                        </p>
                    </div>
                    <div class="modal-footer">
                        <form action="{{route('post.destroy',$id)}}" method="POST">
                            <input type="hidden" name="_token" value="{{csrf_token()}}"/>
                            <input type="hidden" name="_method" value="DELETE"/>
                            <button class="btn btn-secondary" type="button" data-dismiss="modal">
                                    取消操作
                            </button>
                            <button type="submit" class="btn btn-danger">
                                <i class="fa fa-times-circle"></i>
                                确定
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @section('scripts')
        <script>
            $(function(){
                $('#publish_date').pickadate(
                    {
                        format:"yyyy-mm-dd "
                    }
                )
                $('#publish_time').pickadate(
                    {
                        format:"h:i A "
                    }
                )
                $('#tags').selectize(
                    {
                        create:true
                    }
                );
            });
        </script>
        @stop

    @stop
