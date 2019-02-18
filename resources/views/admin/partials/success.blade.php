@if (Session::has('success'))
    <div class="alert alert-success">
        <button type="button" data-dismiss="alert" class="close">x</button>
        <strong>
            <i class="fa fa-circle fa-lg fa-fw"></i>Success!
        </strong>
        {{Session::get('success')}}
    </div>
    @endif
