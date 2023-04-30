	// WIZARD 2
	$("#wizard2").steps({
		headerTag: "h3",
		bodyTag: "section",
		autoFocus: true,
		labels: {
			cancel: "Cancelar",
			current: "current step:",
			pagination: "Pagination",
			finish: "Guardar",
			next: "Siguiente",
			previous: "Anterior",
			loading: "Cargando ...",
		},
		titleTemplate:
			'<span class="number">#index#</span> <span class="title">#title#</span>',
		onStepChanging: function (event, currentIndex, newIndex) {
			if (currentIndex < newIndex) {
				// Step 1 form validation
				if (currentIndex === 0) {

					var nombre_campana = $("#nombre_campana").parsley();
	
					var asunto = $("#asunto").parsley();
			
					if (nombre_campana.isValid() && asunto.isValid()) {
						return true;
					} else {

						if(!nombre_campana.isValid())
						$("#nombre_campana").removeClass("is-valid").addClass("is-invalid  error-input");
					
						if(!asunto.isValid())
						$("#asunto").removeClass("is-valid").addClass("is-invalid  error-input");
					
					
						return false;
					}
				}
				// Step 2 form validation
				if (currentIndex === 1) {
					var cod_responsabilidad = $("#cod_responsabilidad").parsley();


					if (
						cod_responsabilidad
					
					) {
						return true;
					} else {
						if (!cod_responsabilidad)
							$("#cod_responsabilidad")
								.removeClass("is-valid")
								.addClass("is-invalid  error-input");

				
			
					}
				
				}
				// Always allow step back to the previous step even if the current step is not valid.
			} else {
				return true;
			}
		},

		onFinished: function (event, currentIndex) {
			var nombre_campana = $("#nombre_campana").val();
				var asunto = $("#asunto").val();
				var id_pais = $("#pais").val();
				var id_version = $("#id_version").val();
				var plantilla = $("#summernote").val();
				var asunto = $("#asunto").val();
				var data ={
					id_campana:id_campana,
					ACCION:ACCION,
					id_version,
					nombre_campana,
					asunto,
					id_pais,
					plantilla
					
				}
	
	
			guardar_campana(data)
		
		},
	});


	function guardar_campana(data){
		$.ajax({
			dataType: "json",
			data: data,

			url: BASE_URL + "?url=ajax/GuardarCampana",
			type: "post",
			beforeSend: function () {
	
				let timerInterval
				Swal.fire({
				  title: 'Guardando',
				  html: 'Por favor espere ...',
				  timer: 30000,
				  timerProgressBar: true,
				  didOpen: () => {
					Swal.showLoading()
					const b = Swal.getHtmlContainer().querySelector('b')
					timerInterval = setInterval(() => {
					  b.textContent = Swal.getTimerLeft()
					}, 100)
				  },
				  willClose: () => {
					clearInterval(timerInterval)
				  }
				}).then((result) => {
				  /* Read more about handling dismissals below */
				  if (result.dismiss === Swal.DismissReason.timer) {
					console.log('I was closed by the timer')
				  }
				})
				//$("a[href=#finish]").attr("disabled", "disabled").addClass('disabled');
				//$("a[href=#finish]").text('Guardando, por favor espere....')
				//$("#cod_municipio").selectpicker('refresh');
			},
			success: function (respuesta) {
				console.log(respuesta);
				if (respuesta.result == true) {
				Swal.fire({
						icon: "success",
						title: "Registro Exitoso",
						text: "Presione OK para continuar",
					}).then((result) => {
						/* Read more about isConfirmed, isDenied below */
				if (result.isConfirmed) {
							$(location).attr(
								"href",
								BASE_URL +'?url=Inicio'
							);
						}
					});
				} else {
					Swal.fire({
						icon: "error",
						title: "Oops...",
						text: respuesta.msg,
					});
				}
			},
			error: function (xhr, err) {
				console.log(err);
				alert("ocurrio un error intente de nuevo");
			},
		});
	}

	$("#nombre_campana, #asunto").on(
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
					.removeClass("is-invalid error-input")
					.addClass("is-valid valid-input");
				
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
	  });
