<div class='main-image'>


    <figure class="zoom"
            onmousemove="zoom(event)"
            style="background-image: url('{!!image($product['own_properties']['main_image'])!!}');background-repeat: no-repeat;">

        <img
                src="{!!image($product['own_properties']['main_image'])!!}"
                title='{!!$product['name']!!}'
                alt='{!!$product['name']!!}'
        />
    </figure>
</div>

<script>
   function zoom(e){
      var zoomer = e.currentTarget;
      e.offsetX ? offsetX = e.offsetX : offsetX = e.touches[0].pageX;
      e.offsetY ? offsetY = e.offsetY : offsetX = e.touches[0].pageX;
      x = offsetX/zoomer.offsetWidth*100;
      y = offsetY/zoomer.offsetHeight*100;
      zoomer.style.backgroundPosition = x + '% ' + y + '%';
   }
</script>


