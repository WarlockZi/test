<div class="brands">
    <div class="brands__title typing-animation">Популярные бренды</div>
    <div class="brands__wrap">

        @php
            $brands = [
                "benovy"=>"benovy.png",
                "dispodent"=>"dispodent.png",
                "elegreen"=>"EleGreen.png",
                "imsstore"=>"imsstore.gif",
                "klever"=>"klever.png",
                "matrix"=>"matrix.svg",
                "medenta"=>"medenta.jpg",
                "mediok"=>"mediok.svg",
                "protecodent"=>"protecodent.svg",
                "sitekmed"=>"sitekmed.png",
                "unite"=>"unite.svg",
    ];
        @endphp

        @foreach($brands as $brand=>$img)
            <a href="/brands/{!! $brand !!}">
                <img src="/storage/app/pic/brands/{!! $img !!}"
                     onerror="this.src='/storage/app/srvc/nophoto.png';this.onerror=false;"
                     alt="{!! $brand !!}">
            </a>
        @endforeach

    </div>
</div>