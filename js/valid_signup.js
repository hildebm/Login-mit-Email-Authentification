// JavaScript Validierung für Neuanmeldung eines Nutzers

$('document').ready(function()
{ 		 		
		 // valider Regulärer Ausdruck für Vorname
		  var firstNameregex = /^[a-zA-Z ]+$/;
		 $.validator.addMethod("validname", function( value, element ) {
		     return this.optional( element ) || firstNameregex.test( value );
		 }); 
		 
		  // valider Regulärer Ausdruck für Nachname
		  var lastNameregex = /^[a-zA-Z ]+$/;
		 $.validator.addMethod("validname", function( value, element ) {
		     return this.optional( element ) || lastNameregex.test( value );
		 }); 
		 
		 // Regulärer Ausdruck für Email-Adresse
		 var mailregex = /^([a-zA-Z0-9_\.\-\+])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
		 
		 $.validator.addMethod("validemail", function( value, element ) {
		     return this.optional( element ) || mailregex.test( value );
		 });
		 
		 $("#register-form").validate({
					
		  rules:
		  {
				//input names des Formulars
				txtfirstname: {
					required: true,
					validname: true,
					minlength: 3
				},
				txtlastname: {
					required: true,
					validname: true,
					minlength: 3
				},
				txtuname: {
					required: true,
					validname: true,
					minlength: 3
				},
				txtemail: {
					required: true,
					validemail: true
				},
				txtpass: {
					required: true,
					minlength: 5,
					maxlength: 15
				},
				txtcpass: {
					required: true,
					equalTo: '#passwort'
				},
		   },
		   messages:
		   {
				txtfirstname: {
					required: "Gib deinen Vornamen ein.",
					validname: "Dein Vorname darf nur Buchstaben und Leerzeichen enthalten.",
					minlength: "Dein Vorname ist zu kurz."
					  },
				txtlastname: {
					required: "Gib deinen Nachnamen ein.",
					validname: "Dein Nachname darf nur Buchstaben und Leerzeichen enthalten.",
					minlength: "Dein Nachname ist zu kurz."
					  },
				txtuname: {
					required: "Gib deinen Nutzernamen ein.",
					validname: "Dein Nutzername darf nur Buchstaben und Leerzeichen enthalten",
					minlength: "Dein Nutzername ist zu kurz."
				},
			    txtemail: {
					  required: "Gib deine Email-Adresse ein.",
					  validemail: "Ungültige Email-Adresse."
					   },
				txtpass:{
					required: "Gib dein Passwort ein.",
					minlength: "Dein Passwort muss mindestens fünf Zeichen lang sein."
					},
				txtcpass:{
					required: "Wiederhol dein Passwort.",
					equalTo: "Passwörter stimmen nicht überein!"
					}
		   },
		   
		   errorPlacement : function(error, element) {
			  $(element).closest('.form-group').find('.help-block').html(error.html());
		   },
		   highlight : function(element) {
			  $(element).closest('.form-group').removeClass('has-success').addClass('has-error');
		   },
		   unhighlight: function(element, errorClass, validClass) {
			  $(element).closest('.form-group').removeClass('has-error').addClass('has-success');
			  $(element).closest('.form-group').find('.help-block').html('');
		   }
		   
		}); 
		   
});