<div class="row form-group">
    <label for="title" class="col-md-3 col-form-label">
        标题
    </label>
    <div class="col-md-8">
        <input class="form-control" name="title" id="title" value="{{$title}}">
    </div>
</div>
<div class="row form-group">
    <label for="subtitle" class="col-md-3 col-form-label">
        副标题
    </label>
    <div class="col-md-8">
        <input class="form-control" name="subtitle" id="subtitle" value="{{$subtitle}}">
    </div>
</div>
<div class="row form-group">
    <label for="meta_description" class="col-md-3 col-form-label">
        描述信息
    </label>
    <div class="col-md-8">
        <input class="form-control" name="meta_description" id="meta_description" value="{{$meta_description}}">
    </div>
</div>
<div class="row form-group">
    <label for="page_image" class="col-md-3 col-form-label">
        图片
    </label>
    <div class="col-md-8">
        <input class="form-control" name="page_image" id="page_image" value="{{$page_image}}">
    </div>
</div>
<div class="row form-group">
    <label for="layout" class="col-md-3 col-form-label">
        布局
    </label>
    <div class="col-md-4">
        <input class="form-control" name="layout" id="layout" value="{{$layout}}">
    </div>
</div>
<div class="row form-group">
    <label for="reverse_direction" class="col-md-3 col-form-label">
        排序
    </label>
    <div class="col-md-7">
        <label class="form-inline">
            <input type="radio" name="reverse_direction" id="reverse_direction" @if(!$reverse_direction) checked="checked" value="0"@endif/>
            升序
        </label>
        <label class="form-inline">
            <input type="radio" name="reverse_direction" id="reverse_direction" @if($reverse_direction) checked="checked" value="1"@endif/>
           降序
        </label>
    </div>
</div>