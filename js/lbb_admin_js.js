(function($) {
    $(document).ready( function(){
        function saveGoogleUser(user){
            console.log('Logged in as: ' + user.getBasicProfile().getName());
        }
        function CopyToClipboard(containerid) {
            if (document.selection) { 
                var range = document.body.createTextRange();
                range.moveToElementText(document.getElementById(containerid));
                range.select().createTextRange();
                document.execCommand("copy"); 
            
            } else if (window.getSelection) {
                var range = document.createRange();
                 range.selectNode(document.getElementById(containerid));
                 window.getSelection().addRange(range);
                 document.execCommand("copy");
            }
        }        
        $('#copy_schema_local').click ( function (e){
            CopyToClipboard('schema-code');
        });
        $('#applyall').click ( function (e){
            e.preventDefault();
            $('.timebox-close').val($('#monday-close').val());
            $('.timebox-open').val($('#monday-open').val());
        });
        $('.close-day').change( function(e){
            var tmp = this.id.split('-');
            if(this.checked){
                $('#' + tmp[0] + '-details').hide();         
            }else{
                $('#' + tmp[0] + '-details').show();
            }
        });
        $('#sitemapsPING_BUTTON').click( function(e){
            e.preventDefault();
            $('#sitemapsPING_STATUS').html('5% - Starting...');
            $('#sitemapsPING_BUTTON').attr('disabled', 'disabled');
            ping_se();
        });
        function ping_se(){
            $('#sitemapsPING_STATUS').html('15% - Building Data...');
            var data = {action: 'lbb_ajax_ping_se', pg: ($('#sitemapsPING_GOOGLE').is(':checked')) ? 'Y' :'N', pb: ($('#sitemapsPING_BING').is(':checked')) ? 'Y' :'N'};
            $('#sitemapsPING_STATUS').html('25% - Building Data...');
            $('#sitemapsPING_STATUS').html('50% - Sending Data...');
            $.post(ajaxurl, data, function(response) {
                $('#sitemapsPING_STATUS').html('100% - Complete...');
                var result = $.parseJSON(response);
                if($.isPlainObject(result)){
                    if(result[0].indexOf("Success") > -1) {
                        $('#sitemapsPING_STATUS').html('Successfully Pinged Search Engines');
                    }else{
                        $('#sitemapsPING_STATUS').html('Error Pinging Searching Engines');  
                    }
                }else{
                    $('#sitemapsPING_STATUS').html(result[1]);      
                } 
            });
            $('#sitemapsPING_BUTTON').attr('disabled', '');
        }
        function hf(cc, a){
            if(a == 'show'){
               if($(cc).hasClass('hide-field')){$(cc).removeClass('hide-field');} 
            }else{
               if(!$(cc).hasClass('hide-field')){$(cc).addClass('hide-field');} 
            }
        }
    });
})( jQuery );