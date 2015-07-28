<?php


			echo '<section class="testimonial" id="testimonials">';


				echo '<div class="container">';


					echo '<div class="section-header">';


						echo '<h2 class="white-text">'.__('Testimonials','zerif-lite').'</h2>';


						$zerif_testimonials_subtitle = get_theme_mod('zerif_testimonials_subtitle');


						if(isset($zerif_testimonials_subtitle) && $zerif_testimonials_subtitle != ""):


							echo '<h6 class="white-text">'.$zerif_testimonials_subtitle.'</h6>';


						endif;


					echo '</div>';


					echo '<div class="row" data-scrollreveal="enter right after 0s over 1s">';


						echo '<div class="col-md-12">';


							echo '<div id="client-feedbacks" class="owl-carousel owl-theme">';

									if(is_active_sidebar( 'sidebar-testimonials' )):


										dynamic_sidebar( 'sidebar-testimonials' );
									else:

										the_widget( 'zerif_testimonial_widget','title=Advanced Linux OS&text=Sistem Operativ i bazuar ne linux i cili do te offroj shum mundesi te mira per zhvilluesit e softvereve &image_uri='.get_stylesheet_directory_uri().'/images/product-bg.png' );
										the_widget( 'zerif_testimonial_widget','title=John Dow&text=Add a testimonial widget in the "Widgets: Testimonials section" in Customizer&image_uri='.get_stylesheet_directory_uri().'/images/product-bg.png' );
										the_widget( 'zerif_testimonial_widget','title=John Dow&text=Add a testimonial widget in the "Widgets: Testimonials section" in Customizer&image_uri='.get_stylesheet_directory_uri().'/images/product-bg.png' );

									endif;



							echo '</div>';


						echo '</div>';


					echo '</div>';


				echo '</div>';


			echo '</section>';


?>