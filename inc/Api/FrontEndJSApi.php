<?php
/**
 * @package  AcadPlugin
 */
namespace Inc\Api;

class FrontEndJSApi {

  public function getEnrolledStudentsForCourse() {
    global $wpdb;
    $course_id = intval($_POST['course_id']);
    $semester_ids = $_POST['semester_ids'];

    $ids = array();
    foreach ($semester_ids as $id) {
      array_push($ids, intval($id));
    }
    $format = implode(',', $ids);

    $enrollment_table = $wpdb->prefix . 'acad_enrollment';
    $student_table = $wpdb->prefix . 'acad_student';

    $students = $wpdb->get_results( "SELECT StudentEnrollmentNumber FROM $enrollment_table WHERE CourseID = ".$course_id." AND SemesterID IN ($format)" );

    $student_enrollment_numbers = array();
    foreach ($students as $student => $value) {
      array_push( $student_enrollment_numbers, intval($value->StudentEnrollmentNumber) );
    }
    $format = implode(',', $student_enrollment_numbers);

    //get the student enrollment numbers in an array and find the student names
    $student_details = $wpdb->get_results( "SELECT StudentEnrollmentNumber, FirstName, MiddleName, LastName FROM $student_table WHERE StudentEnrollmentNumber IN ($format)" );

    if($student_details) {
      echo json_encode($student_details);
      wp_die();
    }
    else {
      ob_clean();
      echo json_encode($course_id);
      wp_die();
    }
  }

}

?>
