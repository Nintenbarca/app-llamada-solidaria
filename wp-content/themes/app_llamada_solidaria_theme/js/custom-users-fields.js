jQuery(document).ready(function($){
  var custom_fields;

  custom_fields = '<tr class="form-field form-required">';
  custom_fields += '<th scope="row">';
  custom_fields += '<label for="user_town">Población</label>';
  custom_fields += '</th>';
  custom_fields += '<td>';
  custom_fields += '<input type="text" id="user_town" name="user_town">';
  custom_fields += '</td>';
  custom_fields += '</tr>';

  custom_fields += '<tr class="form-field">';
  custom_fields += '<th scope="row">';
  custom_fields += '<label for="user_province">Provincia</label>';
  custom_fields += '</th>';
  custom_fields += '<td>';
  custom_fields += '<input type="text" id="user_province" name="user_province">';
  custom_fields += '</td>';
  custom_fields += '</tr>';

  custom_fields += '<tr class="form-field">';
  custom_fields += '<th scope="row">';
  custom_fields += '<label for="user_phone">Teléfono</label>';
  custom_fields += '</th>';
  custom_fields += '<td>';
  custom_fields += '<input type="number" id="user_phone" name="user_phone">';
  custom_fields += '</td>';
  custom_fields += '</tr>';

  $('#createuser .form-table tbody').append(custom_fields);
});