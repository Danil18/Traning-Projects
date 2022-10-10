
$(document).ready (function() {
  var xhr = new XMLHttpRequest();
  xhr.open('GET', 'http://localhost/users', true);
  xhr.send();
  xhr.onreadystatechange = function() { // (3)
    if (xhr.readyState != 4) return;
    if (xhr.status != 200) {
      alert(xhr.status + ': ' + xhr.statusText);
    } else {
      var h4 = document.createElement('h4');
      h4.innerHTML = "Список пользователей";
      $('#content').append(h4);
      var ol = document.createElement('ol');
      var data = JSON.parse(xhr.responseText.substring(1, xhr.responseText.length));
      var userList = ''
      for (var i=0; i < data.length; i++){
        userList += '<li><a href="#" class="user" user-id='+ data[i]['id'] + '>' + data[i]['name'] + '</a></li>';
      }
      ol.innerHTML = userList;
      $('#content').append(ol);
    }
  }
});


$(document).ready (function() {
    $(document).on('click', '#user, .user', function () {
        var id = $(this).attr("user-id");
        var username = $(this).text();
        var xhr = new XMLHttpRequest();
        xhr.open('GET', 'http://localhost/users/'+id, true);
        xhr.send();
        xhr.onreadystatechange = function() { // (3)
          if (xhr.readyState != 4) return;
          if (xhr.status != 200) {
            alert(xhr.status + ': ' + xhr.statusText);
          } else {
            $('#content').text('');
            var user = document.createElement('h4');
            user.innerHTML = '<p id="user" user-id='+ id + '>' + username + '</p>'
            var h4 = document.createElement('h4');
            h4.innerHTML = 'Квартиры пользователя:';
            $('title').text(username);
            $('#content').append(user);
            $('#content').append(h4);
            var div = document.createElement('div');
            var data = JSON.parse(xhr.responseText.substring(1, xhr.responseText.length));
            var appartmentsList = '';
            for (var i=0; i < data.length; i++){
              appartmentsList += '<li><a href="#" class="appartment" appartment-id='+ data[i]['id'] + '> Адрес: ' + data[i]['address'] + '</a></li>';
            }
            div.innerHTML = '<ol>' + appartmentsList + '</ol>';
            div.id = 'list';
            $('#content').append(div);
            var btn = document.createElement('button');
            btn.type = 'button';
            btn.id = 'btm_appartment';
            btn.innerHTML = 'Добавить квартиру';
            $('#content').append(btn);
          }
        }
        return false;
    });
});

$(document).ready (function() {
  $(document).on ('click', '#btm_appartment', function() {
    $('#btm_appartment').hide();
    var text = document.createElement('input');
    text.type = 'text';
    text.id = 'new_adress';
    text.value = '';
    text.placeholder = 'Введите адрес';
    var btn = document.createElement('button');
    btn.type = 'button';
    btn.id = 'add_appartment';
    btn.innerHTML = 'Добавить квартиру';
    $('#content').append(text);
    $('#content').append(btn);
  });
});


$(document).ready (function() {
  $(document).on ('click', '#add_appartment', function() {
    address = document.getElementById("new_adress").value;
    if(address.length > 8){
      var id = $('#user').attr("user-id");
      var xhr = new XMLHttpRequest();
      xhr.open('PUT', 'http://localhost/users/'+id+'/appartment', true);
      xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
      var body = {address: address};
      xhr.send(JSON.stringify(body));
      xhr.onreadystatechange = function() { // (3)
        if (xhr.readyState != 4) return;
        if (xhr.status != 200) {
          alert(xhr.status + ': ' + xhr.statusText);
        } else {
          $('#add_appartment').remove();
          $('#new_adress').remove();
          $('#btm_appartment').show();
          var data = JSON.parse(xhr.responseText.substring(1, xhr.responseText.length));
          var appartmentsList = '';
          for (var i=0; i < data.length; i++){
            appartmentsList += '<li><a href="#" class="appartment" appartment-id='+ data[i]['id'] + '> Адрес: ' + data[i]['address'] + '</a></li>';
          }
          var ol = document.createElement('ol');
          ol.innerHTML = appartmentsList;
          $('#list').text('');
          $('#list').append(ol);
        }
      }
    } else {
      alert('Слишком короткий адрес!');
    }
  });
});


$(document).ready (function() {
  $(document).on ('click', '.appartment', function() {
    var userId = $('#user').attr("user-id");
    var username = $('#user').text();
    var user = document.createElement('h4');
    user.innerHTML = '<a href="#" id="user" user-id='+ userId + '>' + username + '</a>';
    var id = $(this).attr("appartment-id");
    var appartName = $(this).text();
    var appart = document.createElement('h4');
    appart.innerHTML = '<p id="appartment" appartment-id='+ id + '>' + appartName + '</p>';
    var xhr = new XMLHttpRequest();
    xhr.open('GET', 'http://localhost/appartments/'+id, true);
    xhr.send();
    xhr.onreadystatechange = function() { // (3)
      if (xhr.readyState != 4) return;
      if (xhr.status != 200) {
        alert(xhr.status + ': ' + xhr.statusText);
      } else {
        $('title').text(appartName);
        var data = JSON.parse(xhr.responseText.substring(1, xhr.responseText.length));
        var countersList = '';
        for (var i=0; i < data.length; i++){
          countersList += '<li><p class="counters" counter-title="'+data[i]['title']+'" counter-value='+data[i]['value']+' counter-id='+ data[i]['id'] + '> Счётчик: ' + data[i]['title'] + '.</br>Значение: '+ data[i]['value'] + '</p></li>';
        }
        var div = document.createElement('div');
        div.innerHTML = '<ol>' + countersList + '</ol>';
        div.id = 'list';
        $('#content').text('');
        $('#content').append(appart);
        $('#content').append(user);
        $('#content').append(div);
        var btnEdit = document.createElement('button');
        btnEdit.type = 'button';
        btnEdit.id = 'btm_counters';
        btnEdit.innerHTML = 'Обновить показания счётчиков';
        $('#content').append(btnEdit);
        var btnAdd = document.createElement('button');
        btnAdd.type = 'button';
        btnAdd.id = 'add_btm_counters';
        btnAdd.innerHTML = 'Добавить новый счётчик';
        $('#content').append(btnAdd);
      }
    }
  });
});

$(document).ready (function() {
  $(document).on ('click', '#btm_counters', function() {
    $('#btm_counters').hide();
    var id = new Array();
    $('.counters').each(function(){
      id.push($(this).attr('counter-id'));
    });
    var value = new Array();
    $('.counters').each(function(){
      value.push($(this).attr('counter-value'));
    });
    var title = new Array();
    $('.counters').each(function(){
      title.push($(this).attr('counter-title'));
    });
    var div = document.createElement('div');
    div.id = 'counters-indicators';
    inputList = '';
    if(id.length == value.length && value.length == title.length){
      for (var i=0; i < id.length; i++){
        inputList += title[i] +
        '  <input type="text" class="new_indicators" input-id='+ id[i] +
        ' placeholder="Введите показания" value=' + value[i] + '></br>';
        div.innerHTML = inputList;
        $('#content').append(div);
        var btn = document.createElement('button');
        btn.type = 'button';
        btn.id = 'edit_counters';
        btn.innerHTML = 'Обновить показания счётчиков';
        $('#counters-indicators').append(btn);
      }
    }
  });
});


$(document).ready (function() {
  $(document).on ('click', '#edit_counters', function() {
      var id = new Array();
      $('.new_indicators').each(function(){
        id.push($(this).attr('input-id'));
      });
      var value_new = new Array();
      $('.new_indicators').each(function(){
        value_new.push(this.value);
      });
      var value = new Array();
      $('.counters').each(function(){
        value.push($(this).attr('counter-value'));
      });
      var body = new Array();
      for(var i = 0; i < value_new.length; i++){
        if(value_new[i] > value[i]){
          body.push({id: id[i], value: value_new[i]});
        }
      }
      if(body.length > 0){
        var idAppart = $('#appartment').attr("appartment-id");
        var xhr = new XMLHttpRequest();
        xhr.open('POST', 'http://localhost/appartments/'+idAppart, true);
        xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
        xhr.send(JSON.stringify(body));
        xhr.onreadystatechange = function() { // (3)
          if (xhr.readyState != 4) return;
          if (xhr.status != 200) {
            alert(xhr.status + ': ' + xhr.statusText);
          } else {
            var data = JSON.parse(xhr.responseText.substring(1, xhr.responseText.length));
            var countersList = '';
            for (var i=0; i < data.length; i++){
              countersList += '<li><p class="counters" counter-title="'+data[i]['title']+'" counter-value='+data[i]['value']+' counter-id='+ data[i]['id'] + '> Счётчик: ' + data[i]['title'] + '.</br>Значение: '+ data[i]['value'] + '</p></li>';
            }
            var ol = document.createElement('ol');
            ol.innerHTML = countersList;
            $('#counters-indicators').remove();
            $('#btm_counters').show();
            $('#list').text('');
            $('#list').append(ol);
          }
        }
      } else {
        alert('Некорректные данные');
      }
  });
});

$(document).ready (function() {
  $(document).on ('click', '#add_btm_counters', function() {
    var xhr = new XMLHttpRequest();
    xhr.open('GET', 'http://localhost/counters/type', true);
    xhr.send();
    xhr.onreadystatechange = function() { // (3)
      if (xhr.readyState != 4) return;
      if (xhr.status != 200) {
        alert(xhr.status + ': ' + xhr.statusText);
      } else {
        var data = JSON.parse(xhr.responseText.substring(1, xhr.responseText.length));
        $('#add_btm_counters').hide();
        var div = document.createElement('div');
        div.id = 'add_counters_continer';
        var select = document.createElement('select');
        select.id = 'type_new_counters';
        options = '<option value="default"> --- </option>';
        for (var i=0; i < data.length; i++){
          options += '<option value=' + data[i]['id'] + '>' + data[i]['title'] + '</option>';
        }
        select.innerHTML = options;
        var btn = document.createElement('button');
        btn.type = 'button';
        btn.id = 'add_counters';
        btn.innerHTML = 'Добавить счётчик';
        $('#content').append(div);
        $('#add_counters_continer').append(select);
        $('#add_counters_continer').append(btn);
      }
    }
  });
});

$(document).ready (function() {
  $(document).on ('click', '#add_counters', function() {
    value = $('#type_new_counters').val();
    if(value != "default"){
      var xhr = new XMLHttpRequest();
      xhr.open('PUT', 'http://localhost/counters', true);
      xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
      var id = $('#appartment').attr("appartment-id");
      var body = {typeId: value, appartmentId: id};
      xhr.send(JSON.stringify(body));
      xhr.onreadystatechange = function() { // (3)
        if (xhr.readyState != 4) return;
        if (xhr.status != 200) {
          alert(xhr.status + ': ' + xhr.statusText);
        } else {
          $('#add_counters_continer').remove();
          $('#add_btm_counters').show();
          var data = JSON.parse(xhr.responseText.substring(1, xhr.responseText.length));
          var countersList = '';
          for (var i=0; i < data.length; i++){
            countersList += '<li><p class="counters" counter-title="'+data[i]['title']+'" counter-value='+data[i]['value']+' counter-id='+ data[i]['id'] + '> Счётчик: ' + data[i]['title'] + '.</br>Значение: '+ data[i]['value'] + '</p></li>';
          }
          var ol = document.createElement('ol');
          ol.innerHTML = countersList;
          $('#list').text('');
          $('#list').append(ol);

        }
      }
    } else {
      alert('Выберите тип счётчика!');
    }
  });
});
