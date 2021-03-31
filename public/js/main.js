$('#delete').on('show.bs.modal', function (event) {
  var button = $(event.relatedTarget);
  var id = button.data('id');
  
  var modal = $(this);
  modal.find('#id').val(id);
});

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