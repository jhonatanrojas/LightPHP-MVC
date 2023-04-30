 //Initialize Select2 Elements
 console.log('app.js');
//  $('.select2').select2()
//  $('#reservation').daterangepicker()



 $("#tipo_chamba").on('change', function() {
     let vuelta = document.getElementById('chamba1');
     let pesquera = document.getElementById('chamba2');
     let emprender = document.getElementById('chamba3');
     let chamba4 = document.getElementById('chamba4');
     //let minera = document.getElementById('minera');
     //let digital = document.getElementById('digital');
     //let tecnica = document.getElementById('tecnica-oficios');
     //let delivery = document.getElementById('delivery');

     vuelta.classList.add("ocultarmotrar"); //remove 
     pesquera.classList.add("ocultarmotrar"); //remove
     emprender.classList.add("ocultarmotrar"); //remove
     chamba4.classList.add("ocultarmotrar"); //remove
     //minera.classList.add("ocultarMostrar"); //remove
     //digital.classList.add("ocultarMostrar"); //remove
     //tecnica.classList.add("ocultarMostrar"); //remove
     //delivery.classList.add("ocultarMostrar"); //remove

     if (this.value == '0') {//chamba2
         $('#chamba1 :input').attr('disabled', true);
         $('#chamba3 :input').attr('disabled', true);
         $('#chamba4 :input').attr('disabled', true);
         $('#chamba2 :input').attr('disabled', true);

     }else if (this.value == '1') {//chamba1
        console.log('chamba1');

         vuelta.classList.toggle("ocultarmotrar");
         $('#chamba2 :input').attr('disabled', true);
         $('#chamba3 :input').attr('disabled', true);
         $('#chamba4 :input').attr('disabled', true);
         $('#chamba1 :input').attr('disabled', false);

     }else if (this.value == '2') {//chamba2

         pesquera.classList.toggle("ocultarmotrar");
         $('#chamba1 :input').attr('disabled', true);
         $('#chamba3 :input').attr('disabled', true);
         $('#chamba4 :input').attr('disabled', true);
         $('#chamba2 :input').attr('disabled', false);

     }else if (this.value == '3') {//chamba3

         emprender.classList.toggle("ocultarmotrar");
         $('#chamba1 :input').attr('disabled', true);
         $('#chamba2 :input').attr('disabled', true);
         $('#chamba4 :input').attr('disabled', true);
         $('#chamba3 :input').attr('disabled', false);

     }else if (this.value == '4') {//minera

         $('#chamba1 :input').attr('disabled', true);
         $('#chamba2 :input').attr('disabled', true);
         $('#chamba3 :input').attr('disabled', true);
         $('#chamba4 :input').attr('disabled', true);
         
     }else if (this.value == '5') {//digital

         $('#chamba1 :input').attr('disabled', true);
         $('#chamba2 :input').attr('disabled', true);
         $('#chamba3 :input').attr('disabled', true);
         $('#chamba4 :input').attr('disabled', true);
     
     }else if (this.value == '6') {//chamba4

         chamba4.classList.toggle("ocultarmotrar");
         $('#chamba1 :input').attr('disabled', true);
         $('#chamba2 :input').attr('disabled', true);
         $('#chamba3 :input').attr('disabled', true);
         $('#chamba4 :input').attr('disabled', false);
     
     }else if (this.value == '7') {//tecnica-oficios

         $('#chamba1 :input').attr('disabled', true);
         $('#chamba2 :input').attr('disabled', true);
         $('#chamba3 :input').attr('disabled', true);
         $('#chamba4 :input').attr('disabled', true);

     }else if (this.value == '8') {//delivery

         $('#chamba1 :input').attr('disabled', true);
         $('#chamba2 :input').attr('disabled', true);
         $('#chamba3 :input').attr('disabled', true);
         $('#chamba4 :input').attr('disabled', true);
     }


 });
