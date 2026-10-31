<div class='main-image'>


    <figure class="zoom"
            style="background-image: url('{!!image(env('PIC_PRODUCT').$product->ownProperties->main_image)!!}');background-repeat: no-repeat;">

        <img
                src="{!!image(env('PIC_PRODUCT').$product->ownProperties->main_image)!!}"
                title='{!!$product['name']!!}'
                alt='{!!$product['name']!!}'
        />
    </figure>
</div>


