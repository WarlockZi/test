<? ob_start();

?>

<form id="producttiny" method="post" action="/adminsc/product/AddDescription">

	<textarea  name="description" id="mytextarea" cols="10" rows="3">
		<?=$product->dtxt;?>
	</textarea>

</form>


<? return ob_get_clean(); ?>
