@if($errors->any())
    <div class="danger danger-alert">
        <strong>whoops!</strong>
         there are some errors with your input.<br><br>
        <ul>
            @foreach($errors->all() as $error)
                <li>{{$error}}</li>
                @endforeach
        </ul>
    </div>
@endif