<?php

/**

 * The template for displaying the footer.

 *

 * Contains the closing of the #content div and all content after

 *

 * @package zerif

 */

?>



<footer id="footer">

<div class="container">



	<?php

		/* COMPANY ADDRESS */

		$zerif_address = get_theme_mod('zerif_address','24B, Fainari Street, Bucharest, Romania');

		if(isset($zerif_address) && $zerif_address != ""):

			echo '<div class="col-md-5 company-details">';

				echo '<div class="icon-top red-text">';

					echo '<i class="fa fa-map-marker"></i>';

				echo '</div>';

				echo $zerif_address;

			echo '</div>';

		endif;



		/* COMPANY EMAIL */

		$zerif_email = get_theme_mod('zerif_email','support@codeinwp.com');

		if(isset($zerif_email) && $zerif_email != ""):

			echo '<div class="col-md-2 company-details">';

				echo '<div class="icon-top green-text">';

					echo '<i class="fa fa-envelope"></i>';

				echo '</div>';

				echo $zerif_email;

			echo '</div>';

		endif;



		/* COMPANY PHONE NUMBER */

		$zerif_phone = get_theme_mod('zerif_phone','Phone number');

		if(isset($zerif_phone) && $zerif_phone != ""):

			echo '<div class="col-md-2 company-details">';

				echo '<div class="icon-top blue-text">';

					echo '<i class="fa fa-phone-square"></i>';

				echo '</div>';

				echo $zerif_phone;

			echo '</div>';

		endif;

	?>



	<!-- SOCIAL ICON AND COPYRIGHT -->

	<div class="col-lg-3 col-sm-3 copyright">

		<?php

			$zerif_socials_facebook = get_theme_mod('zerif_socials_facebook','#');

			$zerif_socials_twitter = get_theme_mod('zerif_socials_twitter','#');

			$zerif_socials_linkedin = get_theme_mod('zerif_socials_linkedin','#');

			$zerif_socials_behance = get_theme_mod('zerif_socials_behance','#');

			$zerif_socials_dribbble = get_theme_mod('zerif_socials_dribbble','#');



			if((isset($zerif_socials_facebook) && $zerif_socials_facebook != "") ||

				(isset($zerif_socials_twitter) && $zerif_socials_twitter != "") ||

				(isset($zerif_socials_linkedin) && $zerif_socials_linkedin != "") ||

				(isset($zerif_socials_behance) && $zerif_socials_behance != "") ||

				(isset($zerif_socials_dribbble) && $zerif_socials_dribbble != "")

				):

				echo '<ul class="social">';



				/* facebook */

				if(isset($zerif_socials_facebook) && $zerif_socials_facebook != ""):

					echo '<li><a href="'.$zerif_socials_facebook.'"><i class="fa fa-facebook"></i></a></li>';

				endif;

				/* twitter */

				if(isset($zerif_socials_twitter) && $zerif_socials_twitter != ""):

					echo '<li><a href="'.$zerif_socials_twitter.'"><i class="fa fa-twitter"></i></a></li>';

				endif;

				/* linkedin */

				if(isset($zerif_socials_linkedin) && $zerif_socials_linkedin != ""):

					echo '<li><a href="'.$zerif_socials_linkedin.'"><i class="fa fa-linkedin"></i></a></li>';

				endif;

				/* behance */

				if(isset($zerif_socials_behance) && $zerif_socials_behance != ""):

					echo '<li><a href="'.$zerif_socials_behance.'"><i class="fa fa-behance"></i></a></li>';

				endif;

				/* dribbble */

				if(isset($zerif_socials_dribbble) && $zerif_socials_dribbble != ""):

					echo '<li><a href="'.$zerif_socials_dribbble.'"><i class="fa fa-dribbble"></i></a></li>';

				endif;

				echo '</ul>';

			endif;



			$zerif_copyright = get_theme_mod('zerif_copyright');

			if(isset($zerif_copyright) && $zerif_copyright != ""):

				echo $zerif_copyright;

			endif;


			?>
			<br>
    © Te Gjitha Drejtat e Rezervuara
</div>

	</div>

</div> <!-- / END CONTAINER -->

</footer> <!-- / END FOOOTER  -->



<?php wp_footer(); ?>



</body>

</html>