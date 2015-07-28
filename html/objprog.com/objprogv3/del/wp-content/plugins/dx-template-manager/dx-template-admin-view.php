<div id="icon-plugins" class="icon32"></div>

<div class='wrap'>
	<h2>DX Template</h2>

	<p><strong>I realize that the plugin is using eval() and theoretically this could lead to malware script insertion
    even if this could only happen from that plugin through an administrative account (and only authorized people should have one). 
	</strong></p>
	
	<form id="dxtemplate-form" action="options.php" method="POST">
		
			<?php settings_fields('dxdt_setting') ?>
			<?php do_settings_sections( 'dx-template-options' ) ?>
			
			<input type="submit" value="I agree" />
	</form> <!-- end of #dxtemplate-form -->
</div>