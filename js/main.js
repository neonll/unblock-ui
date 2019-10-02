  $(function() {
    var Data = {};

    function createAccordion() {
      var text = '';

      text += '<div class="accordion" id="accordionGroups">';

      $.each(Data, function(index,val) {
        text += createCard(index, val);
      });

      text += '</div>';

      return text;
    }

    function createCard(num, group) {
      var text = '';
      // text += '<input type="hidden" name="group-'+num+'[title]" value="'+group.title+'"><div class="card"><div class="card-header" id="heading_'+num+'"><h2 class="mb-0"><button class="btn btn-link '+(num ? 'collapsed' : '')+'" type="button" data-toggle="collapse" data-target="#collapse'+num+'" aria-expanded="true" aria-controls="collapse'+num+'">'+group.title+'</button></h2></div><div id="collapse'+num+'" class="collapse '+(num ? '' : 'show')+'" aria-labelledby="heading'+num+'" data-parent="#accordionGroups"><div class="card-body repeater" id="repeater-'+num+'"><div data-repeater-list="group-'+num+'[entries]">';
      text += '<input type="hidden" name="group-'+num+'[title]" value="'+group.title+'"><div class="card"><div class="card-header" id="heading_'+num+'"><h2 class="mb-0"><button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#collapse'+num+'" aria-expanded="true" aria-controls="collapse'+num+'">'+group.title+'</button></h2></div><div id="collapse'+num+'" class="collapse" aria-labelledby="heading'+num+'" data-parent="#accordionGroups"><div class="card-body repeater" id="repeater-'+num+'"><div data-repeater-list="group-'+num+'[entries]">';

      text += '<div class="form-group row" data-repeater-item><div class="col-7"><input type="text" class="form-control" name="url" value=""></div><div class="col-2"><input type="checkbox" class="form-control" name="active" value="true"></div><div class="col-3"><input data-repeater-delete type="button" class="btn btn-outline-danger" value="Удалить"></div></div>';

      text += '</div><input data-repeater-create type="button" class="btn btn-outline-warning" value="Добавить"/></div></div></div>';

      return text;
    }

    function initRepeaters() {
      $('.repeater').each(function() {
        var repeater_id = $(this).attr('id');
        var num = repeater_id.split('-')[1];

        var $repeater = $(this).repeater({
          initEmpty: false,
          defaultValues: {
              'active': true
          },
            
        });

        $repeater.setList(Data[num].entries);
      });

    }

    $('#btn_save').click(function() {
      var form = $('#form_main');
      $.blockUI({ message: null });
      $.post($(form).attr('action'), $(form).serialize())
        .done(function (result) {
            $.unblockUI;
            if (result == 1) {
              swal("Готово!", "Записи сохранены, сервер перезагружен!", "success")
                .then((value) => {
                  location.reload();
                });
            }
            else {
              swal("Ошибка!", "Что-то пошло не так, попробуйте еще раз!", "error")
                .then((value) => {
                  location.reload();
                });
            }
        });
    });

    $('#link_show_raw_modal').click(function() {
      $.get('./src/handler.php?action=getraw', function(data) {
        $('#textarea_raw').val(data);
      });
    });

    $('#btn_raw_save').click(function() {
      $.blockUI({ message: null });
      $.post('./src/handler.php?action=saveraw', {'text': $('#textarea_raw').val()})
        .done(function (result) {
            $.unblockUI;
            if (result == 1) {
              swal("Готово!", "Записи сохранены, сервер перезагружен!", "success")
                .then((value) => {
                  location.reload();
                });
            }
            else {
              swal("Ошибка!", "Что-то пошло не так, попробуйте еще раз!", "error")
                .then((value) => {
                  location.reload();
                });
            }
        });
    });

    function scrollToEntry(group, entry) {
      $('#collapse'+group).collapse('show').on('shown.bs.collapse', function() {
        $('html, body').animate({
          scrollTop: $('input[name="group-'+group+'[entries]['+entry+'][url]"]').offset().top - 60
        }, 750);
      });
    }

    function findUrl() {
      var url = $('#input_search').val();
      var found = null;

      $.each(Data, function(num,group) {
        if (found === null) {
          $.each(group.entries, function (index,entry) {
            if (entry.url == url) {
              found = num;

              scrollToEntry(found, index);

              return;
            }
          });
        }
        else
          return;
      });

      if (found === null) {

        var selectGroup = document.createElement("select");
        selectGroup.id = 'select_target_group';
        $(selectGroup).addClass('form-control');

        $.each(Data, function(index, val) {
          var option = document.createElement("option");
          option.value = index;
          option.text = val.title;
          selectGroup.appendChild(option);
        });
         
        swal({
          icon: 'warning',
          title: 'Не найдено!',
          text: 'Выберите категорию для добавления:',
          content: selectGroup,
          buttons: {
            cancel: 'Отмена',
            confirm: 'Добавить',
          },
        })
        .then((value) => {
          var found = $('#select_target_group').val();
          Data[found].entries.push({'url': url, 'active': true});
          $('#repeater-'+found).repeater().setList(Data[found].entries);

          scrollToEntry(found, Data[found].entries.length-1);
        });

      }
    }

    $('#btn_search').click(function() {
      findUrl();
    });

    $('#input_search').keyup(function(e){
      if (e.keyCode == 13)
        findUrl();
    });

    $.getJSON('./src/handler.php?action=get', function(data) {
      Data = data;
      console.log(data);
      $('#form_main').append(createAccordion());
      initRepeaters();
    });


    
    

  });