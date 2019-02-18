@extends('admin.layout')
@section('content')
    <div class="container">
        <div class="row page-title-row">
            <div class="col-md-6">
                <h3 class="pull-left">上传</h3>
                <div class="pull-left ">
                    <ul class="breadcrumb">
                        @foreach ($breadcrumbs as $path=>$disp)
                            <li><a href="/admin/upload?path={{$path}}}">{{$disp}}</a></li>
                        @endforeach
                            <li class="active">{{$folderName}}</li>
                    </ul>
                </div>
            </div>
            <div class="col-md-6 text-right">
                <button type="button" class="btn btn-success btn-md" data-toggle="modal" data-target="#modal-folder-create">
                    <i class="fa fa-circle-plus"></i>
                    新增目录
                </button>
                <button type="button" class="btn btn-primary btn-md" data-toggle="modal" data-target="#modal-file-create">
                    <i class="fa fa-upload"></i>
                    上传文件
                </button>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-12">
                @include('admin.partials.errors')
                @include('admin.partials.success')
                <table class="table table-striped " id="uploads-table">
                    <thead>
                        <th>名称</th>
                        <th>类型</th>
                        <th>日期</th>
                        <th>尺寸</th>
                        <th data-sortable="false">操作</th>
                    </thead>
                    <tbody>
                        {{--file's all folders--}}
                        @foreach($subfolders as $path=>$name)
                            <tr>
                                <td>
                                    <a href="/admin/upload?folder={{$path}}">
                                        <i class="fa fa-folder fa-lg fa-fw"></i>
                                        {{$name}}</a>
                                </td>
                                <td>目录</td>
                                <td>-</td>
                                <td>-</td>
                                <td>
                                    <button class="btn btn-danger btn-xs" type="button" onclick="delete_folder('{{$name}}')">
                                        <i class="fa fa-times-circle fa-lg"></i>
                                        删除
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                        {{--file's all files--}}
                        @foreach($files as $file)
                            <tr>
                                <td>
                                    <a href="{{$file['webPath']}}">
                                        @if(is_image($file['mimeType']))
                                            <i class="fa fa-image fa-lg fa-fw"></i>
                                        @else
                                            <i class="fa fa-file fa-lg fa-fw"></i>
                                        @endif
                                        {{$file['name']}}
                                    </a>
                                </td>
                                <td>
                                    {{$file['mimeType']?:'Unknown type'}}
                                </td>
                                <td>
                                    {{$file['modified']->format('j-M-y ,g:ia')}}
                                </td>
                                <td>
                                    {{human_filesize($file['size'])}}
                                </td>
                                <td>
                                    <button class="btn btn-xs btn-danger" type="button" onclick="delete_file('{{$file['name']}}')">
                                        <i class="fa fa-times-circle fa-lg"></i>
                                        删除
                                    </button>
                                    @if(is_image($file['mimeType']))
                                        <button class="btn btn-xs btn-success" type="button" onclick="preview_image('{{$file['webPath']}}')">
                                            <i class="fa fa-eye fa-lg "></i>
                                            预览
                                        </button>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    @include('admin.upload._modals')
@stop
@section('scripts')
    <script>
        function delete_folder(name){
            $('#delete-folder-name1').html(name);
            $('#delete-folder-name2').val(name);
            $('#delete-folder').modal('show');
        }
        function delete_file(name){
            $('#delete-file-name1').html(name);
            $('#delete_file_name2').val(name);
            $('#delete-file').modal('show');
        }
        function preview_image(path){
            $('#preview-image').attr('src',path);
            $('#preview-image-view').modal('show');
        }

//        datatable initialize
        $(function(){
            $('#uploads-table').dataTable();
        })
    </script>
    @stop