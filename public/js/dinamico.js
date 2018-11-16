$(document).ready(function() { 

	var $plazo_values = $('#plazo');
	
	var $amortizacion_values = $('#amortizacion');
	
	var plazosPG = {
		            "5 Años":5,
		            "6 Años":6,
		            "7 Años":7,
		            "8 Años":8,
		            "9 Años":9,
		            "10 Años":10,
	};
	
	 var plazosCF = {
	                "3 Años":3,
	                "4 Años":4,
	                "5 Años":5,
	                "6 Años":6,
	                "7 Años":7
	 };
	 
	 var amortizacionPG = {
			 "Mensual":30,
			 "Bimestral":60,
	         "Trimestral":90,
	 };
	 
	 var amortizacionCF = {
	         "Mensual":30,
	         "Trimestral":90,
	 };
	 
	 
	 $('#tipo_prestamo').on('change', function() {
		  
		 if (this.value == "gracia"){
			 
			 $("#periodo_gracia").val("3");

			 $plazo_values.empty();
			 
			 $.each(plazosPG, function(key, value) {
				 
				 $plazo_values.append($("<option></option>").attr("value", value).text(key));
			 });
			 
			 
			 $amortizacion_values.empty();
			 
			 $.each(amortizacionPG, function(key, value) {
				 
				 $amortizacion_values.append($("<option></option>").attr("value", value).text(key));
			 });
			 
		 }else{
			 
			 $("#periodo_gracia").val("0");
			 
			 $plazo_values.empty();
			 
			 $.each(plazosCF, function(key, value) {
				 
				 $plazo_values.append($("<option></option>").attr("value", value).text(key));
			 });
			 
			 $amortizacion_values.empty();
			 
			 $.each(amortizacionCF, function(key, value) {
				 
				 $amortizacion_values.append($("<option></option>").attr("value", value).text(key));
			 });
		 }
		 
	 });
	 
	 
	 $("#valor").on('keyup', function(){
		 
		 var string = numeral($("#valor").val()).format('0,0');
		 
		 $("#valor").val(string);
		 
	 });
	 
	 
	 $("#formulario").submit(function(e){
		 
		 var string = numeral($("#valor").val());
		 
		 $("#valor").val(string.value());
		 
     });
	 
  });
 
