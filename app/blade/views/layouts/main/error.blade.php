@if(!empty($_SESSION['error']))
    <div class="errors">
        <div class="message error">
            {!!$_SESSION['error']??''!!}
        </div>
    </div>
    {{$_SESSION['error']=''}}
@endif
