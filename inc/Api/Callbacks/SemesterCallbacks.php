<?php
/**
 * @package  AcadPlugin
 */
namespace Inc\Api\Callbacks;

use Inc\Base\BaseController;

class SemesterCallbacks extends BaseController {
  public function acadSemesterSection() {
    echo "<h3> Semester Creation </h3>";
  }

  public function displayAction() {
    echo '<input type="hidden" name="action" value="add_semester_action">';
  }

  public function displayProgram() {
    global $wpdb;
    $table = $wpdb->prefix.'acad_program';
    $rows = $wpdb->get_results( "SELECT * FROM $table" );

    echo '<select name="program">';
    foreach ($rows as $row ) {
      //echo $row->DepartmentID . " ";
      echo '<option value="'. $row->ProgramID . '"> '.$row->ProgramCode.'</option>';
    }
    echo '</select>';
  }

  public function displayMaxCredits() {
    $value = esc_attr( get_option('max_credits') );
    echo '<input type="number" class="regular-text" name="max_credits" value="' . $value . '" placeholder="Maximum Credits">';
  }

  public function displayMinCredits() {
    $value = esc_attr( get_option('min_credits') );
    echo '<input type="number" class="regular-text" name="min_credits" value="' . $value . '" placeholder="Minimum Credits">';
  }

  public function displayDuration() {
    $value = esc_attr( get_option('duration') );
    echo '<input type="number" class="regular-text" name="duration" value="' . $value . '" placeholder="Duration (in months)">';
  }

  public function displaySemesterType() {
    $value = esc_attr( get_option('semester_type') );
    echo '<input type="text" class="regular-text" name="semester_type" value="' . $value . '" placeholder="SemesterType">';
  }

  public function displaySemesterNumber() {
    $value = esc_attr( get_option('semester_number') );
    echo '<input type="number" class="regular-text" name="semester_number" value="' . $value . '" placeholder="Semester Number">';
  }

  public function displayIsCurrent() {
    echo '<input type="radio" class="regular-text" name="is_current" value="1"> Yes <input type="radio" class="regular-text" name="is_current" value="0"> No';
  }

  public function addSemester() {
    if( current_user_can('add_semester') ) {
      global $wpdb;
  		$table = $wpdb->prefix . 'acad_semester';

      $check = $wpdb->insert( $table,
        array(
          'ProgramID' => $_POST['program'],
          'MaxCredit' => $_POST['max_credits'],
  			  'MinCredit' => $_POST['min_credits'],
          'DurationInMonths' => $_POST['duration'],
          'SemesterType' => $_POST['semester_type'],
  			  'SemesterNumber' => $_POST['semester_number'],
  			  'IsCurrent' => $_POST['is_current'],
        )
      );

      if( $check == 1 ) {
        wp_redirect(admin_url('admin.php?page=acad_semester'));
      }
    }

    else {
      echo "You are not autorized to add a new Semester";
    }
  }

  public function viewSemesters() {
    if( current_user_can('add_semester') || current_user_can('view_semesters')) {
      global $wpdb;
      $table = $wpdb->prefix. 'acad_semester';
      $program_table = $wpdb->prefix . 'acad_program';
      $rows = $wpdb->get_results( "SELECT * FROM $table" );

      echo '<table class="widefat", width="100%">
        <thead>
          <tr>
            <th>Semester ID</th>
            <th>Program Code</th>
            <th>Maximum Credits</th>
            <th>Minimum Credits</th>
            <th>Duration(in months)</th>
            <th>Type</th>
            <th>Semester Number</th>
            <th>Is Current</th>
            </tr>
        </thead>
        <tbody>';
          foreach($rows as $row){

            $program = $wpdb->get_results( "SELECT ProgramCode FROM $program_table WHERE ProgramID = $row->ProgramID" );

            echo "<tr ><td>".$row->SemesterID."</td><td>".$program[0]->ProgramCode."</td><td> ". $row->MaxCredit."</td><td>".$row->MinCredit."</td><td>".$row->DurationInMonths ."</td><td> ".$row->SemesterType."</td><td>".$row->SemesterNumber."</td><td>".$row->IsCurrent."</td></tr>\n";

          }
        echo '</tbody>
      </table>';
    }
  }
}
