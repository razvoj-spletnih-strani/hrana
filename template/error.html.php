<?php ob_start()?>

<div class="container error">
	<div class="row">
		<div class="col-sm-12">
		<h1>Ups, strani ni mogoče najti!</h1>
		<i class="fas fa-exclamation-triangle"></i>
		<p>Prišlo je do napake. <a href="javascript:history.back()">Nazaj.</a></p>
		</div>
  	</div>
</div>



<?php
$vsebina=ob_get_clean();

require "template/layout.html.php";

?>