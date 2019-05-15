<?php
/**
 * @package  AcadPlugin
 */
namespace Inc\Api\Callbacks;

use Inc\Base\BaseController;

class CourseCurriculumMappingCallbacks extends BaseController {
  public function acadCourseCurriculumSection() {
    echo "<h3> Course Curriculum Mapping Creation </h3>";
  }

  public function displayCcmAction() {
    echo '<input type="hidden" name="action" value="add_course_curriculum_mapping_action">';
  }

  public function displayCcmCourse() {
    global $wpdb;
    $table = $wpdb->prefix.'acad_course';
    $rows = $wpdb->get_results( "SELECT * FROM $table" );

    echo '<select name="course">';
    foreach ($rows as $row ) {
      //echo $row->DepartmentID . " ";
      echo '<option value="'. $row->CourseID . '"> '.$row->CourseName .'</option>';
    }
    echo '</select>';
  }

  public function displayCcmCurriculum() {
    global $wpdb;
    $table = $wpdb->prefix.'acad_curriculum';
    $rows = $wpdb->get_results( "SELECT * FROM $table" );

    echo '<select name="curriculum">';
    foreach ($rows as $row ) {
      //echo $row->DepartmentID . " ";
      echo '<option value="'. $row->CurriculumID . '"> '.$row->CurriculumCode.'</option>';
    }
    echo '</select>';
  }

  public function displayCcmSemesterNumber() {
    $value = esc_attr( get_option('semester_number') );
    echo '<input type="number" step="0.01" class="regular-text" name="semester_number" value="' . $value . '" placeholder="SemesterNumber">';
  }

  public function addCcm() {
    if( current_user_can('add_course_curriculum_mapping') ) {
      global $wpdb;
  		$table = $wpdb->prefix . 'acad_course_curriculum_mapping';

      $check = $wpdb->insert( $table,
        array(
          'CourseID' => $_POST['course'],
  			  'CurriculumID' => $_POST['curriculum'],
          'SemesterNumber' => $_POST['semester_number']
        )
      );

      wp_redirect(admin_url('admin.php?page=acad_course_curriculum_mapping'));
    }

    else {
      echo "You are not autorized to add a new Course Curriculum Mapping";
    }
  }

  public function deleteCcms() {
    if( current_user_can('add_course_curriculum_mapping') || current_user_can('view_course_curriculum_mappings') ) {
      global $wpdb;
      $table = $wpdb->prefix.'acad_course_curriculum_mapping';
      $rows = $wpdb->get_results( "SELECT * FROM $table" );

      $course_table = $wpdb->prefix.'acad_course';
      $curriculum_table = $wpdb->prefix.'acad_curriculum';

      echo '<table class="widefat", width="100%">
        <thead>
          <tr>
            <th>Course Name</th>
            <th>Course Code</th>
            <th>Curriculum Code</th>
            <th>Total Credits</th>
            <th>Semester Number</th>
            </tr>
        </thead>
        <tbody>';
          foreach($rows as $row){

            $course = $wpdb->get_results( "SELECT * FROM $course_table WHERE CourseID = $row->CourseID" );

            $curriculum = $wpdb->get_results( "SELECT * FROM $curriculum_table WHERE CurriculumID = $row->CurriculumID" );

            echo "<tr ><td>".$course[0]->CourseName."</td><td>".$course[0]->CourseCode."</td><td> ".$curriculum[0]->CurriculumCode."</td><td>".$curriculum[0]->TotalCredits ."</td><td> ".$row->SemesterNumber."</td></td>\n";
            echo '<td><form method="post"><input type="submit" name="delete" value="Delete"><input type="hidden" name="course_curriculum_mapping_id" value="'.$row->CourseCurriculumMappingID.'"></form></td>';


        if ($_POST) {
        global $wpdb;
            echo "Inside";
            $table = $wpdb->prefix . 'acad_course_curriculum_mapping';
            $id = $_POST['course_curriculum_mapping_id'];
            $res = $wpdb->query("DELETE FROM $table WHERE CourseCurriculumMappingID = ".$id);
            //$wpdb->delete( $table, array( 'CourseID' => $id ) );
             echo "<meta http-equiv='refresh' content='0'>";
          }
        }
      }
  }

  public function viewCcms() {
    if( current_user_can('add_course_curriculum_mapping') || current_user_can('view_course_curriculum_mappings') ) {
      global $wpdb;
      $table = $wpdb->prefix.'acad_course_curriculum_mapping';
      $rows = $wpdb->get_results( "SELECT * FROM $table" );

      $course_table = $wpdb->prefix.'acad_course';
      $curriculum_table = $wpdb->prefix.'acad_curriculum';

      echo '<table class="widefat", width="100%">
        <thead>
          <tr>
            <th>Course Name</th>
            <th>Course Code</th>
            <th>Curriculum Code</th>
            <th>Total Credits</th>
            <th>Semester Number</th>
            </tr>
        </thead>
        <tbody>';
          foreach($rows as $row){

            $course = $wpdb->get_results( "SELECT * FROM $course_table WHERE CourseID = $row->CourseID" );

            $curriculum = $wpdb->get_results( "SELECT * FROM $curriculum_table WHERE CurriculumID = $row->CurriculumID" );

            echo "<tr ><td>".$course[0]->CourseName."</td><td>".$course[0]->CourseCode."</td><td> ".$curriculum[0]->CurriculumCode."</td><td>".$curriculum[0]->TotalCredits ."</td><td> ".$row->SemesterNumber."</td></tr>\n";

          }
        echo '</tbody>
      </table>';
    }
  }
}
?>
