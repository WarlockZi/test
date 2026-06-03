@if(isset($catItem['item']['own_properties']['path']))
    <div class="share-info">
        <span>адрес :: </span>
        <a href="/{!!$catItem['model']!!}/{!!data_get($catItem,'item.own_properties.path', '')!!}">
            {!!data_get($catItem, 'item.name', '')!!}
        </a>
    </div>
@elseif(isset($catItem['item']['slug']))
    <div class="share-info">
        <span>адрес :: </span>
        <a href="/{!!$catItem['model']!!}/{!!data_get($catItem, 'item.slug', '')!!}">
            {!!data_get($catItem, 'item.name', '')!!}
        </a>
    </div>
@endif
 