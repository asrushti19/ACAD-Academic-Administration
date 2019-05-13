<?php
/**
 * @package  AcadPlugin
 */
namespace Inc\Api\Callbacks;

use Inc\Base\BaseController;

class FacultyRegistrationMappingCallbacks extends BaseController {
  public function acadFacultyRegistrationMappingSection() {
    echo "<h3> Create </h3>";
  }

  public function displayAction() {
    echo '<input type="hidden" name="action" value="add_faculty_registration_mapping_action">';
  }

  public function displayDepartment() {
    global $wpdb;
    $table = $wpdb->prefix.'acad_department';
    $rows = $wpdb->get_results( "SELECT * FROM $table" );

    echo '<select name="department" id="department_select">';
    foreach ($rows as $row ) {
      //echo $row->DepartmentID . " ";
      echo '<option value="'. $row->DepartmentID . '"> '.$row->DepartmentName .'</option>';
    }
    echo '</select>';
  }

  public function displayProgram() {
    echo '<select name="program" id="program_select">';
    echo '</select>';
  }

  public function displaySemester() {
    echo '<select name="semester" id="semester_select">';
    echo '</select>';
  }

  public function displayFaculty() {
    echo '<select name="faculty" id="faculty_select">';
    echo '</select>';
  }

  public function addFacultyRegistrationMapping() {
    if( current_user_can('add_faculty_registration_mapping') ) {
      echo "Inside";
      global $wpdb;
  		$table = $wpdb->prefix . 'acad_faculty_registration_mapping';


      $check = $wpdb->insert( $table,
        array(
          'DepartmentID' => $_POST['department'],
          'ProgramID' => $_POST['program'],
  			  'SemesterID' => $_POST['semester'],
          'FacultyID' => $_POST['faculty'],
        )
      );

      if( !is_a( $check, 'WP_ERROR' ) ) {
        wp_redirect(admin_url('admin.php?page=acad_faculty_registration_mapping'));
      }
      else {
        echo $check;

      }
    }

    else {
      echo "You are not autorized to add a new Faculty Registration Mapping";
    }
  }

  public function viewFacultyRegistrationMapping() {
    if( current_user_can('add_faculty_registration_mapping') || current_user_can('view_faculty_registration_mapping') ) {
      global $wpdb;

      $department_table = $wpdb->prefix . 'acad_department';
      $program_table = $wpdb->prefix . 'acad_program';
      $semester_table = $wpdb->prefix . 'acad_semester';
      $faculty_table = $wpdb->prefix . 'acad_faculty';

      $table = $wpdb->prefix . 'acad_faculty_registration_mapping';

      $rows = $wpdb->get_results( "SELECT * FROM $table" );

      echo '<table class="widefat", width="100%">
        <thead>
          <tr>
            <th>Department</th>
            <th>Program Code</th>
            <th>Semester Number</th>
            <th>Faculty Name</th>
            </tr>
        </thead>
        <tbody>';
          foreach($rows as $row){

            $department = $wpdb->get_results( "SELECT DepartmentName FROM $department_table WHERE DepartmentID = $row->DepartmentID" );

            $program = $wpdb->get_results( "SELECT ProgramCode FROM $program_table WHERE ProgramID = $row->ProgramID" );

            $semester = $wpdb->get_results( "SELECT SemesterNumber FROM $semester_table WHERE SemesterID = $row->SemesterID" );

            $faculty = $wpdb->get_results( "SELECT FacultyName FROM $faculty_table WHERE FacultyID = $row->FacultyID" );

            echo "<tr ><td>". $department[0]->DepartmentName ."</td><td>". $program[0]->ProgramCode ."</td><td> ". $semester[0]->SemesterNumber ."</td><td>". $faculty[0]->FacultyName ."</td></tr>\n";

          }
        echo '</tbody>
      </table>';
    }
  }
}

?>
