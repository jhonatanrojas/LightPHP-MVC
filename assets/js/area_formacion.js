var currentValue = 0;
function click_estado_formacion(myRadio) {

    currentValue = myRadio.value;
    if(currentValue==3){
        $(".c-estudios").removeClass("d-none");

    }else{
        $(".c-estudios").addClass("d-none");
    }


}
