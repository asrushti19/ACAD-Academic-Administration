(function($) {
  jQuery(document).ready(function($) {
    $('#department_select').on( 'change', function () {

      valueSelect = $(this).val();

      let dropdown = $('#program_select');
      dropdown.empty();

      if( valueSelect ) {
        jQuery.post(
          ajax_object.ajax_url,
          {
            'action': 'get_program_for_department',
            'value': valueSelect
          },
          function(data) {

            var response = jQuery.parseJSON( data );
            dropdown.html('enable');
            $.each(response, function (i, item) {
              dropdown.append($('<option></option>').attr('value', item.ProgramID).text(item.ProgramCode));
            });
          }
        );
      }
    });
  });

  jQuery(document).ready(function($) {
    $('#program_select').on( 'change', function () {

      valueSelect = $(this).val();

      let dropdown = $('#semester_select');
      dropdown.empty();
      if( valueSelect ) {
        jQuery.post(
          ajax_object.ajax_url,
          {
            'action': 'get_semester_for_program',
            'value': valueSelect
          },
          function(data) {

            var response = jQuery.parseJSON( data );
            dropdown.html('enable');
            $.each(response, function (i, item) {
              dropdown.append($('<option></option>').attr('value', item.SemesterID).text(item.SemesterNumber));
            });
          }
        );
      }
    });
  });
  jQuery(document).ready(function($) {
    $('#department_select').on( 'change', function () {

      valueSelect = $(this).val();

      console.log(ajax_object.ajax_url);
      let dropdown = $('#faculty_select');
      dropdown.empty();

      if( valueSelect ) {
        jQuery.post(
          ajax_object.ajax_url,
          {
            'action': 'get_faculty_for_department',
            'value': valueSelect
          },
          function(data) {

            var response = jQuery.parseJSON( data );
            dropdown.html('enable');
            $.each(response, function (i, item) {
              dropdown.append($('<option></option>').attr('value', item.FacultyID).text(item.FacultyName));
            });
          }
        );
      }
    });
  });
}(jQuery));
