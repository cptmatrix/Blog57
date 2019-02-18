<div class="container">
    <div class="col-md-8">
        <div class="form-group row">
            <label for="title" class="col-md-2 col-form-label">
                标题
            </label>
            <div class="col-md-10">
                <input type="text" class="form-control" name="title" id="title" autofocus value="{{$title}}"/>
            </div>
        </div>
        <div class="form-group row">
            <label for="subtitle" class="col-md-2 col-form-label">
                副标题
            </label>
            <div class="col-md-10">
                <input type="text" class="form-control" name="subtitle" id="subtitle"  value="{{$subtitle}}"/>
            </div>
        </div>
        <div class="form-group row">
            <label for="page_image" class="col-md-2 col-form-label">
                缩略图
            </label>
            <div class="col-md-10">
                <input type="text" class="form-control" name="page_image" id="page_image" onchange="handle_image_change()" value="{{$page_image}}"/>
                <script>
                    function handle_image_change(){
                        $('#page_image_preview').attr('src',
                        function(){
                            var value=$('#page_image').val();
                            if(!value){
                                value={!!json_encode(config('blog.page_image')) !!};
                            }
                            if(value==null){
                                value='';
                            }
                            if(value.substr(0,4)!='http'&& value.substr(0,1)!='/'){
                                value={!! json_encode(config('blog.webpath')) !!}+'/'+value;
                            }
                            return value;
                        });
                    }

                </script>
                <div class="visible-sm space-0"></div>
                <div class="col-md-4 text-right">
                    <img id="page_image_preview" src="{{page_image($page_image)}}" class="img img-responsive" style="max-height:40px"/>
                </div>
            </div>
        </div>
        <div class="form-group row">
            <label for="content" class="col-md-2 col-form-label">
                内容
            </label>
            <div class="col-md-10">
                <textarea class="form-control" name="content" id="content">
                    {{$content}}
                </textarea>
            </div>
        </div>
    </div>
    <div class="col-md-8 ">
        <div class="form-group row">
            <label for="publish_date" class="col-md-2 col-form-label">
                发布日期
            </label>
            <div class="col-md-10">
               <input class="form-control" type="text" id="publish_date" name="publish_date" value="{{$publish_date}}"/>
            </div>
        </div>
        <div class="form-group row">
            <label for="publish_time" class="col-md-2 col-form-label">
                发布时间
            </label>
            <div class="col-md-10">
                <input class="form-control" type="text" id="publish_time" name="publish_time" value="{{$publish_time}}"/>
            </div>
        </div>
        <div class="form-group row">
            <div class="col-md-10 col-md-offset-2">
                <div class="checkbox">
                    <label >
                        <input type="checkbox" {{is_checked($is_draft)}} name="is_draft"/>草稿？
                    </label>
                </div>
            </div>
        </div>
        <div class="form-group row">
            <label for="tags" class="col-md-2 col-form-label">
                标签
            </label>
            <div class="col-md-10">
                <select name="tags[]" class="form-control" id="tags" multiple>
                    @foreach($allTags as $tag)
                            <option @if(in_array($tag,$tags)) selected  @endif  value="{{$tag}}">
                                {{$tag}}
                            </option>
                        @endforeach
                </select>
            </div>
        </div>
        <div class="form-group row">
            <label for="layout" class="col-md-2 col-form-control">
                布局
            </label>
            <div class="col-md-10">
                <input type="text" id="layout" name="layout" value="{{$layout}}" class="form-control">
            </div>
        </div>
        <div class="form-group row">
            <label for="meta_description" class="col-md-2 col-form-control">
                摘要
            </label>
            <div class="col-md-10">
                <textarea id="meta_description" name="meta_description"  class="form-control" rows="6">
                    {{$meta_description}}
                </textarea>
            </div>
        </div>
    </div>
</div>
