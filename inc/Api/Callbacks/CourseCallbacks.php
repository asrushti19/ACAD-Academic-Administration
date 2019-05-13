<?php
/**
 * @package  AcadPlugin
 */
namespace Inc\Api\Callbacks;

use Inc\Base\BaseController;

class CourseCallbacks extends BaseController {
  public function acadCourseSection() {
    echo "<h3> Course Creation </h3>";
  }

  public function displayCourseAction() {
    echo '<input type="hidden" name="action" value="add_course_action">';
  }

  public function displayCourseDepartment() {
    global $wpdb;
    $table = $wpdb->prefix.'acad_department';
    $rows = $wpdb->get_results( "SELECT * FROM $table" );

    echo '<select name="department_id">';
    foreach ($rows as $row ) {
      //echo $row->DepartmentID . " ";
      echo '<option value="'. $row->DepartmentID . '"> '.$row->DepartmentName .'</option>';
    }
    echo '</select>';
  }

  public function displayCourseName() {
    $value = esc_attr( get_option('course_name') );
    echo '<input type="text" class="regular-text" name="course_name" value="' . $value . '" placeholder="Course Name">';
  }

  public function displayCourseType() {
    global $wpdb;
    $table = $wpdb->prefix.'acad_course_types';
    $rows = $wpdb->get_results( "SELECT * FROM $table" );

    echo '<select name="course_type">';
    foreach ($rows as $row ) {
      //echo $row->DepartmentID . " ";
      echo '<option value="'. $row->CourseTypeID . '"> '.$row->CourseTypeName .'</option>';
    }
    echo '</select>';
  }

  public function displayCourseAbbreviation() {
    $value = esc_attr( get_option('course_abbreviation') );
    echo '<input type="text" class="regular-text" name="course_abbreviation" value="' . $value . '" placeholder="Course Abbreviation">';
  }

  public function displayCourseCode() {
    $value = esc_attr( get_option('course_code') );
    echo '<input type="text" class="regular-text" name="course_code" value="' . $value . '" placeholder="Course Code">';
  }

  public function displaySyllabusCode() {
    $value = esc_attr( get_option('syllabus_code') );
    echo '<input type="text" class="regular-text" name="syllabus_code" value="' . $value . '" placeholder="Course Code">';
  }

  public function displayCourseTheory() {
    $value = esc_attr( get_option('syllabus_code') );
    echo '<input type="radio" class="regular-text" name="is_theory" value="1"> Yes <input type="radio" class="regular-text" name="is_theory" value="0"> No';
  }

  public function displayCourseCredits() {
    $value = esc_attr( get_option('course_credits') );
    echo '<input type="text" class="regular-text" name="course_credits" value="' . $value . '" placeholder="Course Credits">';
  }

  public function displayTotalTeachingHours() {
    $value = esc_attr( get_option('total_teaching_hours') );
    echo '<input type="text" class="regular-text" name="total_teaching_hours" value="' . $value . '" placeholder="Total Teaching Hours">';
  }

  public function addCourse() {
    if( current_user_can('add_course') ) {
      global $wpdb;
  		$table = $wpdb->prefix . 'acad_course';

      $check = $wpdb->insert( $table,
        array(
          'DepartmentID' => $_POST['department_id'],
          'CourseTypeID' => $_POST['course_type'],
  			  'CourseName' => $_POST['course_name'],
          'CourseCode' => $_POST['course_code'],
          'CourseAbbreviation' => $_POST['course_abbreviation'],
  			  'SyllabusCode' => $_POST['syllabus_code'],
  			  'IsTheory' => $_POST['is_theory'],
  			  'CourseCredits' => $_POST['course_credits'],
  			  'TotalTeachingHours' => $_POST['total_teaching_hours']
        )
      );

      if( !is_a( $check, WP_ERROR ) ) {
        wp_redirect(admin_url('admin.php?page=acad_course'));
      }
      else {
        echo $check;
      }

    }

    else {
      echo "You are not autorized to add a new Course";
    }
  }

  public function viewCourses() {
    if( current_user_can('add_course') || current_user_can('view_courses') ) {
      global $wpdb;

      $department_table = $wpdb->prefix.'acad_department';
      $course_types_table = $wpdb->prefix.'acad_course_types';
      $course_table = $wpdb->prefix.'acad_course';

      $rows = $wpdb->get_results( "SELECT * FROM $course_table" );

      echo '<table class="widefat", width="100%">
        <thead>
          <tr>
            <th>Name</th>
            <th>Department</th>
            <th>Type</th>
            <th>Abbreviation</th>
            <th>Code</th>
            <th>Syllabus Code</th>
            <th>Theory</th>
            <th>Credits</th>
            <th>Total Teaching Hours</th>
            </tr>
        </thead>
        <tbody>';
          foreach($rows as $row){

            $department = $wpdb->get_results( "SELECT DepartmentName FROM $department_table WHERE DepartmentID = $row->DepartmentID" );

            $type = $wpdb->get_results( "SELECT CourseTypeName FROM $course_types_table WHERE CourseTypeID = $row->CourseTypeID" );

            echo "<tr ><td>".$row->CourseName."</td><td>".$department[0]->DepartmentName."</td><td> ".$type[0]->CourseTypeName."</td><td>".$row->CourseAbbreviation."</td><td>".$row->CourseCode ."</td><td> ".$row->SyllabusCode."</td><td>".$row->IsTheory."</td><td>".$row->CourseCredits."</td><td>".$row->TotalTeachingHours."</td></tr>\n";

          }
        echo '</tbody>
      </table>';
    }
  }
}
