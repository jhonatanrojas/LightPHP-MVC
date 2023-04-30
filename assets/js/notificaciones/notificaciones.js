

	$("#titulo, #contenido").on(
		"keyup",
		function () {
			"use strict";
			var nombres = $(this).val();
	
			var expresion = /^[a-z\d\-_\s]+$/i;
	
			if (expresion.test(nombres)) {
				$(this)
					.removeClass("is-invalid error-input")
					.addClass("is-valid valid-input");
			} else {
				$(this)
					.addClass("is-invalid error-input")
					.removeClass("is-valid valid-input");
				
			}
		}
	);

	$(document).ready(function() {
		$('#summernote').summernote(
			{
				height: 150,   //set editable area's height
				codemirror: { // codemirror options
				  theme: 'monokai'
				}
			  }
			
		);





	  $("#seleccion_bases").change(function () {
		if($(this).val()=='2'){
			$("#nro_bases").attr('readonly', false);
			$("#id_version").attr('readonly', true);
			$("#pais").attr('readonly', true);
			
		}else{
			$("#nro_bases").attr('readonly', true);
			$("#id_version").attr('readonly', false);
			$("#pais").attr('readonly', false);
		

		}
	
		
	
	});
	$(".form-guardar").submit(function (e) {
		e.preventDefault();

	
		var titulo 			= $("#titulo").parsley();	
		var contenido 		= $("#summernote").parsley();
		var nro_base 		= $("#nro_bases").parsley();
		var seleccion_bases = $("#seleccion_bases").val();

		if(!titulo.isValid()){
			$("#titulo").addClass("is-invalid error-input").removeClass("is-valid valid-input");
			$("#titulo").focus()
			return false;
		}

		if(!contenido.isValid()){
			$("#contenido").addClass("is-invalid error-input").removeClass("is-valid valid-input");
			$("#contenido").focus();
			alert("El contenido es requerido")
			return false;
		
		}

		if(seleccion_bases==2 && !nro_base.isValid()){
			$("#nro_bases").addClass("is-invalid error-input").removeClass("is-valid valid-input");
			$("#nro_bases").focus();
			alert("El numero ebase es requerido")
			return false;
		}
		guardar_notificacion();

	
	});


});


	function guardar_notificacion() {
		
		var titulo 			= $("#titulo").val();	
		var contenido 		= $("#summernote").val();
		var nro_base 		= $("#nro_bases").val();
		var seleccion_bases = $("#seleccion_bases").val();
		var id_pais 		= $("#pais").val();
		var id_version = $("#id_version").val();

		var datos ={ titulo:titulo,pais:id_pais,contenido:contenido,nro_base:nro_base,
			seleccion_bases:seleccion_bases,
			id_version:id_version,
			accion:'guardar_notificacion' };
			console.log(datos);
			$.ajax({
				dataType: "json",
					data:datos,
				url: BASE_URL + "?url=ajax/Consultas",
				type: "post",
				beforeSend: function () {
					$(".btn-guardar").text("Enviando... por favor espere");
					$(".btn-guardar").attr("disabled", true);
					
				},
				success: function (res) {
	

					if(res.result){
						Swal.fire({
							icon: "success",
							title: "Notificaciones enviadas",
							text: "Presione OK para continuar",
						}).then((result) => {
							/* Read more about isConfirmed, isDenied below */
							if (result.isConfirmed) {
								$(location).attr(
									"href",
									BASE_URL +'?url=Notificaciones/'
								);
							}
						});


					}else{
						Swal.fire({
							icon: "error",
							title: "Oops...",
							text: res.msg,
						});
					}
					$(".btn-guardar").text("Guardar cambios");
					$(".btn-guardar").attr("disabled", false);
						
		
				
				},
				error: function (xhr, err) {
					console.log(err)
					Swal.fire({
						icon: "error",
						title: "Oops...",
						text: 'Ocurrio un error del lado del servidor'
					});
					$(".btn-guardar").text("Guardar cambios");
					$(".btn-guardar").attr("disabled", false);
				},
			});
		
	}