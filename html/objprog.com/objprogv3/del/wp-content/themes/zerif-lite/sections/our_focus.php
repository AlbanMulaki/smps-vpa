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

				the_widget( 'zerif_ourfocus','title=Java &text=Java eshte gjuhe programmuese e nivelit te lart e zhvilluar nga Sun Microsystem. Java perdoret ne miliarda device te ndryshme. Ne ket tutorial do te kuptoni se si te programoni ne java.&link=#&image_uri='.get_stylesheet_directory_uri()."/images/java.png" );

				the_widget( 'zerif_ourfocus','title=PHP &text=PHP eshte gjuhe programmuese (Server Scripting Language), eshte mjaft e fuqishme per te krijuar webfaqe dinamike dhe interaktive. PHP eshte open source perkrahet ne shum server. PHP eshte mjaft e leht duke e krahasuar me gjuhet tjera programmuese OOP. Disa nga porjektet te cilat jan te zhvilluara ne PHP. Website OBJprog,MyBB,ArchLinux, e shum te tjera.&link=#&image_uri='.get_stylesheet_directory_uri()."/images/php.png" );


				the_widget( 'zerif_ourfocus','title=Python &text=Eshte e dizajnuar qe te kuptohet me  leht. Python mbeshtet OOP,Imperative,Gjuhe funksionale ose procedurale. Perdoret per shkruajtjen e Testimin automatik te applikacioneve,ne vende ku eshte shum e komplikuar te shkruhet ne shell script ... &link=#&image_uri='.get_stylesheet_directory_uri()."/images/python.png" );

			endif;

			?>



	</div>




	<div class="row">

<h2 class="dark-text">Zhvillimi webfaqeve</h2>

			<?php

			if ( is_active_sidebar( 'sidebar-ourfocus' ) ) :

				dynamic_sidebar( 'sidebar-ourfocus' );

			else:

				the_widget( 'zerif_ourfocus','title=HTML & CSS&text=
Qdo webfaqe ne eshte e strukturuar ne dhe dizajnuar ne HTML dhe CSS.
Mesohu se si te krijosh website duke strukturar dhe dizajnuar me HTML dhe CSS
&link=#&image_uri='.get_stylesheet_directory_uri()."/images/htmlcss.png" );



				the_widget( 'zerif_ourfocus','title=Javascript jQuery &text=
Qdo webfaqe ne eshte e strukturuar ne dhe dizajnuar ne HTML dhe CSS.
Mesohu se si te krijosh website duke strukturar dhe dizajnuar me HTML dhe CSS
&link=#&image_uri='.get_stylesheet_directory_uri()."/images/jquery.jpg" );


			endif;

			?>



	</div>


</div> <!-- / END CONTAINER -->



</section>  <!-- / END FOCUS SECTION -->