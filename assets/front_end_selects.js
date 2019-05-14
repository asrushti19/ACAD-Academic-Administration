(function($) {
  jQuery(document).ready(function($) {
    $('#select_course_enrolled_students').on( 'change', function () {

      var course_id = $(this).val();
      var semester_ids = $('.course_enrolled_students_select_class').map(function(){
        return $(this).val()
      }).get();

      if( course_id && semester_ids ) {

        let display_table = $('#enrolled_students_for_course_table tr');
        display_table.empty();
        jQuery.post(
          ajax_object.ajax_url,
          {
            'action': 'get_enrolled_students_for_course',
            'course_id': course_id,
            'semester_ids' : semester_ids
          },
          function(data) {
            
            var response = jQuery.parseJSON( data );

            if(response == course_id) {
              alert('No students enrolled yet!');
              display_table.empty();
              return;
            }

            else {
              $('#enrolled_students_for_course_table tr').not(':first').not(':last').remove();
              var html = '<tr><th>Student Enrollment Number</th><th>Student Name</th></tr>';
              $.each(response, function (i, item) {
                html += '<tr><td>' + item.StudentEnrollmentNumber + '</td><td>' + item.FirstName + ' ' + item.MiddleName + ' ' + item.LastName + '</td></tr>';
              });
              $('#enrolled_students_for_course_table tr').first().after(html);
              $('#enrolled_students_for_course_table tr').css("visibility","visible");
            }
          }
        );
      }
    });
  });
}(jQuery));
