@extends('admin.layout')
@section('style')
    <link href="{{ asset('css/selectize.default.css')}}" rel="stylesheet"/>
    <link href="{{ asset('css/pickadate.min.css')}}" rel="stylesheet"/>
    @stop
@section('content')
    <div class="container">
        <div class="row page-title-row">
            <div class="col-md-12">
                <h3>文章
                    <small>>>创建新文章</small>
                </h3>
            </div>
        </div>
            <div class="row">
                <div class="col-sm-12">
                    <div class="card">
                        <div class="card-header">
                            <h3>文章创建表单</h3>
                        </div>
                        <div class="card-body">
                            @include('admin.partials.errors')
                            <form action="/admin/post/store" method="POST" role="form">
                                <input type="hidden" name="_token" value="{{csrf_token()}}"/>
                                @include('admin.post._form')
                                <div class="row">
                                    <div class="col-md-8">
                                        <div class="form-group row">
                                            <div class="col-md-10 offset-md-2">
                                                <button class="btn btn-primary" type="submit">
                                                    <i class="fa fa-save"></i>
                                                    保存新文章
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
        </div>


@stop

@section('scripts')
    <script src="{{ asset('js/pickadate.min.js') }}"></script>
    <script src="{{ asset('js/selectize.min.js') }}"></script>
    <script>
        $(function() {
            $("#publish_date").pickadate({
                format: "mmm-d-yyyy"
            });
            $("#publish_time").pickatime({
                format: "h:i A"
            });
            $("#tags").selectize({
                create: true
            });
        });
    </script>
@stop
