/*
 * MODAL DELETE OF ALL TABLES
 */

$('#delete').on('show.bs.modal', function (event) {
  var button = $(event.relatedTarget);
  var id = button.data('id');
  
  var modal = $(this);
  modal.find('#id').val(id);
});
/*
 * MASK TO INPUTS DECIMALS
 */
$(document).ready(function(){
     $('.decimal').mask('ZZZ000.00', {
         reverse: true,
         translation: {
            'Z': {
                pattern: /[0-9]/, optional: true
            }
        }
     });
     $('.percent').mask('000.00', {reverse: true});
});



/*
 * REMOVE ROW OF RECIPE'S CARD
 */
$(document).on('click', '#removeRow', function () {
    $(this).closest('#inputFormRow').remove();
});

/*
 * CREATE TABLE OF INGREDIENTS INTO NEW PRODUCTION PAGE
 */
$("#recipe-production").change(function() {
    var dados = $(this).find(':selected').data("info") ;
    var html='';
    $("#volume-production").val('');
    $('#ingredients-show').empty();
    
    $.each(dados, function( index, value ) {
        html += "<tr>";
        html += "<td id='name_"+index+"'>"+value.name+"</td>";
        html += "<td id='percent_"+index+"'></td>";
        html += "<td id='quantity_"+index+"'>"+value.current_qty+" mL</td>";
        html += "</tr>";
    });
    
    $('#ingredients-show').append(html);
    
});

/*
 * UPDATE TABLE OF INGREDIENTS INTO NEW PRODUCTION PAGE
 */

$("#volume-production").change(function() {
    var dados = $("#recipe-production").find(':selected').data("info") ;
    var volume = parseFloat($(this).val());
    var html='';
    if(!dados || !volume){
        return;
    }
    var qty = 0;
    var percent=0;
    var current_qty = 0;
    $.each(dados, function( index, value ) {
        $("#percent_"+index).empty();
        
        percent = parseFloat(value.pivot.percent);
        current_qty = parseFloat(value.current_qty);
        qty = (percent/100) * volume;
        
        if(qty > current_qty){
            $("#percent_"+index).addClass("bg-danger");
        }else{
            $("#percent_"+index).removeClass("bg-danger");
        }
        
        $("#percent_"+index).append(qty.toFixed(2)+" mL");
        
    });
    
});

/*
 * 
 * 
 */

/*
 * INSERT FIELDS TABLE OF INGREDIENTS INTO EDIT PRODUCTION PAGE
 */

$.when( $("#recipe-production-edit"),$.ready ).then(function() {
    var dados = $(this).find(':selected').data("info") ;
    var html='';
    var volume = parseFloat($("#volume-production-edit").val());
    $('#ingredients-show').empty();
    
    $.each(dados, function( index, value ) {
        html += "<tr>";
        html += "<td id='name_"+index+"'>"+value.name+"</td>";
        html += "<td id='percent_"+index+"'></td>";
        html += "<td id='quantity_"+index+"'>"+value.current_qty+" mL</td>";
        html += "</tr>";
    });
    
    $('#ingredients-show').append(html);
    
    $.each(dados, function( index, value ) {
        $("#percent_"+index).empty();
        
        percent = parseFloat(value.pivot.percent);
        current_qty = parseFloat(value.current_qty);
        qty = (percent/100) * volume;
        
        if(qty > current_qty){
            $("#percent_"+index).addClass("bg-danger");
        }else{
            $("#percent_"+index).removeClass("bg-danger");
        }
        
        $("#percent_"+index).append(qty.toFixed(2)+" mL");
        
    });
    
});

/*
 * UPDATE TABLE OF INGREDIENTS INTO EDIT PRODUCTION PAGE
 */

$("#volume-production-edit").change(function() {
    var dados = $("#recipe-production-edit").find(':selected').data("info") ;
    var volume = parseFloat($(this).val());
    var html='';
    if(!dados || !volume){
        return;
    }
    var qty = 0;
    var percent=0;
    var current_qty = 0;
    $.each(dados, function( index, value ) {
        $("#percent_"+index).empty();
        
        percent = parseFloat(value.pivot.percent);
        current_qty = parseFloat(value.current_qty);
        qty = (percent/100) * volume;
        
        if(qty > current_qty){
            $("#percent_"+index).addClass("bg-danger");
        }else{
            $("#percent_"+index).removeClass("bg-danger");
        }
        
        $("#percent_"+index).append(qty.toFixed(2)+" mL");
        
    });
    
});