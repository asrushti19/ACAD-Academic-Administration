<?php
/**
 * @package  AcadPlugin
 */
namespace Inc\Api\Callbacks;

use Inc\Base\BaseController;

class FacultyCourseMappingCallbacks extends BaseController {
  public function acadFacultyCourseMappingSection() {
    echo "<h3> FacultyCourseMapping Creation </h3>";
  }

  public function displayFacultyCourseMappingAction() {
    echo '<input type="hidden" name="action" value="add_faculty_course_mapping_action">';
  }


  public function displaySemesterID() {
    global $wpdb;
    $table = $wpdb->prefix.'acad_semester';
    $rows = $wpdb->get_results( "SELECT * FROM $table" );

    echo '<select name="semester_id">';
    foreach ($rows as $row ) {
      echo '<option value="'. $row->SemesterID . '"> '.$row->SemesterID .'</option>';
    }
    echo '</select>';
  }

  public function displayCourseID() {
    global $wpdb;
    $table = $wpdb->prefix.'acad_course';
    $rows = $wpdb->get_results( "SELECT * FROM $table" );

    echo '<select name="course_id">';
    foreach ($rows as $row ) {
      echo '<option value="'. $row->CourseID . '"> '.$row->CourseName .'</option>';
    }
    echo '</select>';
  }

  public function displayFacultyID() {
    global $wpdb;
    $table = $wpdb->prefix.'acad_faculty';
    $rows = $wpdb->get_results( "SELECT * FROM $table" );

    echo '<select name="faculty_id">';
    foreach ($rows as $row ) {
      echo '<option value="'. $row->FacultyID . '"> '.$row->FacultyName .'</option>';
    }
    echo '</select>';
  }

  public function displayFacultyCourseMappingUpdateListAction() {
    echo '<input type="hidden" name="action" value="update_faculty_course_mapping_getID_action">';
  }

  public function displayFacultyCourseMappingUpdateID( $id ) {
    echo '<input type="hidden" name="faculty_course_mapping_id" value="'. $id . '">';
  }

  public function addFacultyCourseMapping() {

    if( current_user_can('add_faculty_course_mapping') ) {
      global $wpdb;
  		$table = $wpdb->prefix . 'acad_faculty_course_mapping';

      $check = $wpdb->insert( $table,
        array(
          'SemesterID' => $_POST['semester_id'],
          'CourseID' => $_POST['course_id'],
  			  'FacultyID' => $_POST['faculty_id']
        )
      );

      if( !is_a( $check, WP_ERROR ) ) {
        wp_redirect(admin_url('admin.php?page=acad_faculty_course_mapping'));
      }
      else {
        echo $check;
      }

    }
    else {
      echo "You are not autorized to add a new Faculty Course Mapping";
    }
  }

  public function deleteFacultyCourseMappings() {
    if( current_user_can('add_faculty_course_mapping') || current_user_can('view_faculty_course_mappings') ) {
      global $wpdb;

      $table = $wpdb->prefix.'acad_course';
      $table = $wpdb->prefix.'acad_semester';
      $table = $wpdb->prefix.'acad_faculty';
      $table = $wpdb->prefix.'acad_faculty_course_mapping';
      $rows = $wpdb->get_results( "SELECT * FROM $table" );

      echo '<table class="widefat", width="100%">
        <thead>
          <tr>
            <th>Semester ID</th>
            <th>Course ID</th>
            <th>Faculty ID</th>
            </tr>
        </thead>
        <tbody>';
          foreach($rows as $row){
            echo "</td><td>".$row->SemesterID."</td><td> ".$row->CourseID."</td><td>".$row->FacultyID."</td></td>\n";
            echo '<td><form method="post"><input type="submit" name="delete" value="Delete"><input type="hidden" name="faculty_course_mapping_id" value="'.$row->FacultyCourseMappingID.'"></form></td>';

      if ($_POST) {
      global $wpdb;
          echo "Inside";
          $table = $wpdb->prefix . 'acad_faculty_course_mapping';
          $id = $_POST['faculty_course_mapping_id'];
          $res = $wpdb->query("DELETE FROM $table WHERE FacultyCourseMappingID = ".$id);
           echo "<meta http-equiv='refresh' content='0'>";

          }
        }
      }
    }
  public function viewFacultyCourseMappings() {
    if( current_user_can('add_faculty_course_mapping') || current_user_can('view_faculty_course_mappings') ) {
      global $wpdb;

      $table = $wpdb->prefix.'acad_course';
      $table = $wpdb->prefix.'acad_semester';
      $table = $wpdb->prefix.'acad_faculty';
      $table = $wpdb->prefix.'acad_faculty_course_mapping';
      $rows = $wpdb->get_results( "SELECT * FROM $table" );

			echo '<table class="widefat", width="100%">
	  		<thead>
	    		<tr>
	      		<th>Semester ID</th>
	      		<th>Course ID</th>
            <th>Faculty ID</th>
            </tr>
	  		</thead>
	  		<tbody>';
	      	foreach($rows as $row){
	          echo "</td><td>".$row->SemesterID."</td><td> ".$row->CourseID."</td><td>".$row->FacultyID."</td></tr>\n";
		      }
	      echo '</tbody>
			</table>';
    }
  }

  public function updateFacultyCourseMapping() {
    if( current_user_can('update_FacultyCourseMapping') ) {

    }
  }
}
?>
