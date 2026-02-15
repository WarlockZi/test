@if(isset($catItem['item']['own_properties']['path']))
    <div class="share-info">
        <span>адрес :: </span>
        <a href="/{{$catItem['model']}}/{{$catItem['item']['own_properties']['path']}}">
            {{$catItem['item']['name']??''}}
        </a>
    </div>
@endif
@if(isset($catItem['item']['slug']))
    <div class="share-info">
        <span>адрес :: </span>
        <a href="/{{$catItem['model']}}/{{$catItem['item']['slug']}}">
            {{$catItem['item']['name']??''}}
        </a>
    </div>
@endif
