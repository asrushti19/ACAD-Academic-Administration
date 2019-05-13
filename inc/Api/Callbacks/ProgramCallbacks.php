<?php
/**
 * @package  AcadPlugin
 */
namespace Inc\Api\Callbacks;

use Inc\Base\BaseController;

class ProgramCallbacks extends BaseController {
  public function acadProgramSection() {
    echo "<h3> Program Creation </h3>";
  }

  public function displayAction() {
    echo '<input type="hidden" name="action" value="add_program_action">';
  }

  public function displayDepartment() {
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

  public function displayCurriculum() {
    global $wpdb;
    $table = $wpdb->prefix.'acad_curriculum';
    $rows = $wpdb->get_results( "SELECT * FROM $table" );

    echo '<select name="curriculum_id">';
    foreach ($rows as $row ) {
      //echo $row->DepartmentID . " ";
      echo '<option value="'. $row->CurriculumID . '"> '.$row->CurriculumCode.'</option>';
    }
    echo '</select>';
  }

  public function displayBranchName() {
    $value = esc_attr( get_option('branch_name') );
    echo '<input type="text" class="regular-text" name="branch_name" value="' . $value . '" placeholder="Branch Name">';
  }

  public function displayDegreeName() {
    $value = esc_attr( get_option('degree_name') );
    echo '<input type="text" class="regular-text" name="degree_name" value="' . $value . '" placeholder="Degree Name">';
  }

  public function displayAdmissionYear() {
    $value = esc_attr( get_option('admission_year') );
    echo '<input type="text" class="regular-text" name="admission_year" value="' . $value . '" placeholder="Admission Year">';
  }

  public function displayProgramCode() {
    $value = esc_attr( get_option('program_code') );
    echo '<input type="text" class="regular-text" name="program_code" value="' . $value . '" placeholder="program_code">';
  }

  public function displayProgramAbbreviation() {
    $value = esc_attr( get_option('program_abbreviation') );
    echo '<input type="text" class="regular-text" name="program_abbreviation" value="' . $value . '" placeholder="Program Abbreviation">';
  }

  public function displayLaunchYear() {
    $value = esc_attr( get_option('launch_year') );
    echo '<input type="text" class="regular-text" name="launch_year" value="' . $value . '" placeholder="Launch Year">';
  }

  public function addProgram() {
    if( current_user_can('add_program') ) {
      global $wpdb;
  		$table = $wpdb->prefix . 'acad_program';

      $check = $wpdb->insert( $table,
        array(
          'DepartmentID' => $_POST['department_id'],
  			  'CurriculumID' => $_POST['curriculum_id'],
          'BranchName' => $_POST['branch_name'],
          'DegreeName' => $_POST['degree_name'],
  			  'ProgramAdmissionYear' => $_POST['admission_year'],
  			  'ProgramCode' => $_POST['program_code'],
  			  'ProgramAbbreviation' => $_POST['program_abbreviation'],
  			  'LaunchYear' => $_POST['launch_year']
        )
      );

      wp_redirect(admin_url('admin.php?page=acad_program'));
    }
  }

  public function viewPrograms() {
    if( current_user_can('add_program') || current_user_can('program') ) {
      global $wpdb;
      $table = $wpdb->prefix.'acad_program';
      $rows = $wpdb->get_results( "SELECT * FROM $table" );

      $department_table = $wpdb->prefix.'acad_department';
      $curriculum_table = $wpdb->prefix.'acad_curriculum';

      echo '<table class="widefat", width="100%">
        <thead>
          <tr>
            <th>Department Name</th>
            <th>Curriculum Code</th>
            <th>Branch</th>
            <th>Degree</th>
            <th>Admission Year</th>
            <th>Code</th>
            <th>Abbreviation</th>
            <th>Launch Year</th>
            </tr>
        </thead>
        <tbody>';
          foreach($rows as $row){

            $department = $wpdb->get_results( "SELECT * FROM $department_table WHERE DepartmentID = $row->DepartmentID" );

            $curriculum = $wpdb->get_results( "SELECT * FROM $curriculum_table WHERE CurriculumID = $row->CurriculumID" );

            echo "<tr ><td>".$department[0]->DepartmentName."</td><td>".$curriculum[0]->CurriculumCode."</td><td> ".$row->BranchName."</td><td>".$row->DegreeName ."</td><td> ".$row->ProgramAdmissionYear."</td><td>". $row->ProgramCode."</td><td>". $row->ProgramAbbreviation."</td><td>". $row->LaunchYear."</td></tr>\n";

          }
        echo '</tbody>
      </table>';
    }
  }
}
