var security = sola_nl_sub_data['security'];
var every_ten_seconds = '';
var camp_id = sola_nl_sub_data['camp_id'];

function progress(percent, next_campid, $element) {
    var progressBarWidth = percent * $element.width() / 100;
    $element.find('div').animate({ width: progressBarWidth }, 500);
    if (percent === 100) {
        jQuery($element).parent().html("Sent");
        
        if (next_campid === "0") {
            clearInterval(every_ten_seconds);
        } else {
            camp_id = next_campid;
        }
        
        
    }
    
}
function sola_nl_send_batch(camp_id) {
    jQuery("#time_next_"+camp_id).html("<small>Sending a batch...</small>");
    ein_force_send(camp_id).done(function(response){
        ein_get_perc().done(function(response){
            var something = JSON.parse(response);
            progress(something[0], something[2], jQuery('#progressBar_'+camp_id));
            jQuery("#time_next_"+camp_id).html("<small>"+something[1]+"<br />"+something[3]+"<br /><a href='javascrit:void(0);' onclick='javascript:sola_nl_send_batch("+camp_id+"); return false;'>Send a batch now!</a></small>");
        });
    });
}


function ein_get_perc(){
    var data = {
            security:security,
            action: 'get_perc',
            camp_id: camp_id
    };
    return jQuery.post(ajaxurl, data);
}
function ein_force_send(camp_id){
    var data = {
            security:security,
            action: 'force_send',
            camp_id: camp_id
    };
    
    return jQuery.post(ajaxurl, data);
}

//on page load set progress bar and if next send is set, send else set timer to countdown
jQuery(document).ready( function() {
    ein_get_perc().done(function(response){
            var something = JSON.parse(response);
            progress(something[0], something[2], jQuery('#progressBar_'+camp_id));
            jQuery("#time_next_"+camp_id).html("<small>"+something[1]+"<br />"+something[3]+"<br /><a href='javascrit:void(0);' onclick='javascript:sola_nl_send_batch("+camp_id+"); return false;'>Send a batch now!</a></small>");
        });
    
    every_ten_seconds = setInterval(function() {
        ein_get_perc().done(function(response){
            var something = JSON.parse(response);
            progress(something[0], something[2], jQuery('#progressBar_'+camp_id));
            jQuery("#time_next_"+camp_id).html("<small>"+something[1]+"<br />"+something[3]+"<br /><a href='javascrit:void(0);' onclick='javascript:sola_nl_send_batch("+camp_id+"); return false;'>Send a batch now!</a></small>");
            
        });
    }, 10000);

    
});

