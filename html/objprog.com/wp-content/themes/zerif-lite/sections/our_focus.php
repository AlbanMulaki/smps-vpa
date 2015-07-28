<section class="focus" id="focus">



<div class="container">





	<!-- SECTION HEADER -->



	<div class="section-header">







		<!-- SECTION TITLE -->



		<h2 class="dark-text"><?php _e('Tutoriale','zerif-lite'); ?></h2>





		<?php

		$zerif_ourfocus_subtitle = get_theme_mod('zerif_ourfocus_subtitle','Add a subtitle in Customizer, "Our focus section"');



		if(isset($zerif_ourfocus_subtitle) && $zerif_ourfocus_subtitle != ""):



			echo '<h6>'.$zerif_ourfocus_subtitle.'</h6>';



		endif;

		?>



	</div>





	<div class="row">

<h2 class="dark-text">Gjuhe programmuese</h2>

			<?php

			if ( is_active_sidebar( 'sidebar-ourfocus' ) ) :

				dynamic_sidebar( 'sidebar-ourfocus' );

			else:

				the_widget( 'zerif_ourfocus','title=Java &text=Java eshte gjuhe programmuese e nivelit te lart e zhvilluar nga Sun Microsystem. Java perdoret ne miliarda device te ndryshme. Ne ket tutorial do te kuptoni se si te programoni ne java.&link=java&image_uri='.get_stylesheet_directory_uri()."/images/java.png" );


				the_widget( 'zerif_ourfocus','title=HTML & CSS&text=
Qdo webfaqe ne eshte e strukturuar ne dhe dizajnuar ne HTML dhe CSS.
Mesohu se si te krijosh website duke strukturar dhe dizajnuar me HTML dhe CSS
&link=/html-css&image_uri='.get_stylesheet_directory_uri()."/images/htmlcss.png" );

			endif;

			?>



	</div>




</div> <!-- / END CONTAINER -->



</section>  <!-- / END FOCUS SECTION -->