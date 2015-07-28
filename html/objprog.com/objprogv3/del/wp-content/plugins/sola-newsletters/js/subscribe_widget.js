jQuery(function(){
    jQuery('.sola_nl_sub_form').submit(function(event) {
        event.preventDefault();
        var div = "#".concat(jQuery(this).parent().attr("id"));
        var form = jQuery(this).serialize();
        jQuery.ajax({
            url:ajaxurl,
            type:"POST",
            data: form,
            beforeSend: function(){
                jQuery(div).empty().append('<p><img width="25px"  src="wp-content/plugins/sola-newsletters/images/loading.gif" /> Subscribing...</p>');
            },
            error: function(jqXHR, exception) {
                if (jqXHR.status === 0) {
                    alert('Not connect.\n Verify Network.');
                } else if (jqXHR.status == 404) {
                    alert('Requested page not found. [404]');
                } else if (jqXHR.status == 500) {
                    alert('Internal Server Error [500].');
                } else if (exception === 'parsererror') {
                    alert('Requested JSON parse failed.');
                } else if (exception === 'timeout') {
                    alert('Time out error.');
                } else if (exception === 'abort') {
                    alert('Ajax request aborted.');
                } else {
                    alert('Uncaught Error.\n' + jqXHR.responseText);
                }
            },
            success: function(response){
                jQuery(div).empty().append(response);
            }
        
        });

    });
});

