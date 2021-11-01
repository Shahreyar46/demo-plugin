( function( $ ) {
 
	var row_length = $('.form-table tr').length;

    var row_count = row_length + 1;

    const Employee = {
		init() {
			this.bindEvents();
		},

		bindEvents() {
			$( '.employee-wrap .form-1' ).on( 'click', 'a.add-new-employee', this.addCondtions );

            $( '.employee-wrap .form-1' ).on( 'click', 'button.remove-employee', this.removeCondtion );
			
		},

        

		addCondtions( e ) {
			e.preventDefault();
			const row = $( '.employee-wrap .form-1 .form-table' ).find( 'tr' ).first().clone(); 

			row.find('input' ).attr("value", ""); 
            row.find('input' ).attr("placeholder", "Name of Person ".concat(row_count++));   
              	
			$( '.employee-wrap .form-1 .form-table' ).find( 'tbody' ).append( row );

 
		},

        removeCondtion( e ) {
			e.preventDefault();
			const self = $( this );

			if ( 1 >= self.closest( 'tbody' ).find( 'tr' ).length ) {
				return;
			}

			self.closest( 'tr' ).remove();
			
		},

	};

	Employee.init();


} )( jQuery );

