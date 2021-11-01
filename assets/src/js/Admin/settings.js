( function( $ ) {

    var EmployeeSettings = {
        init: function() {
            $('#submit-settings-btn').on( 'click', this.sendMessage );
        },


        sendMessage: function(e) {
            e.preventDefault();

			var formdata = $("input[name='employee_name[]']")
            .map(function(){return $(this).val();}).get();

        
			var formdata = JSON.stringify(formdata);
          
			
                data = {
                    action: 'save_employee_settings',
                    admin_formdata: formdata,
                    nonce: EmployeeSetting.nonce
                };

            $.post( EmployeeSetting.ajaxurl, data, function(resp) {

                if ( resp.success ) {
                    var success_length = $('.success-sms h1').length;

                    const row = $( '.employee-wrap .success-sms' ).find( 'h1' );

                    if ( 0 >= success_length ) {
                        var html = '<h1> Settings Save Successfully </h1>';
                        $('.employee-wrap .success-sms').append( html );
                    }                      
                   
                } else {
                    alert( resp.data );
                }
                
            } );
        }
    };

    $(document).ready( function() {
        EmployeeSettings.init();
    });

} )( jQuery );

