<?php 
	$zerif_ribbonright_text = get_theme_mod('zerif_ribbonright_text');
	if(isset($zerif_ribbonright_text) && $zerif_ribbonright_text != ""):
		echo '<section class="purchase-now">';
			echo '<div class="container">';
				echo '<div class="row">';
					echo '<div class="col-md-9" data-scrollreveal="enter left after 0s over 1s">';
						echo '<h3 class="white-text">';
							echo $zerif_ribbonright_text;
						echo '</h3>';	
					echo '</div>';
					
					$zerif_ribbonright_buttonlabel = get_theme_mod('zerif_ribbonright_buttonlabel');
					$zerif_ribbonright_buttonlink = get_theme_mod('zerif_ribbonright_buttonlink');
					
					if(isset($zerif_ribbonright_buttonlabel) && $zerif_ribbonright_buttonlabel != "" && isset($zerif_ribbonright_buttonlink) && $zerif_ribbonright_buttonlink != ""):
						echo '<div class="col-md-3" data-scrollreveal="enter right after 0s over 1s">';
							echo '<a href="'.$zerif_ribbonright_buttonlink.'" class="btn btn-primary custom-button red-btn">'.$zerif_ribbonright_buttonlabel.'</a>';
						echo '</div>';
					endif;
				echo '</div>';
			echo '</div>';
		echo '</section>';	
	endif;
?>