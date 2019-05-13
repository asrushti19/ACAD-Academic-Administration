<?php
/**
 * @package  AcadPlugin
 */
namespace Inc\Api\Callbacks;

use Inc\Base\BaseController;

class StudentAdmissionCallbacks extends BaseController {
  public function acadStudentAdmissionSection() {
    echo "<h3> StudentAdmission Creation </h3>";
  }

  public function displayStudentAdmissionAction() {
    echo '<input type="hidden" name="action" value="add_student_admission_action">';
  }

  public function displayStudentEnrollmentNumber() {
    global $wpdb;
    $table = $wpdb->prefix.'acad_student';
    $rows = $wpdb->get_results( "SELECT * FROM $table" );

    echo '<select name="student_enrollment_number">';
    foreach ($rows as $row ) {
      //echo $row->DepartmentID . " ";
      echo '<option value="'. $row->StudentEnrollmentNumber . '"> '.$row->StudentEnrollmentNumber .'</option>';
    }
    echo '</select>';
  }


  public function displayAdmissionDate() {
    $value = esc_attr( get_option('admission_date') );
    echo '<input type="text" class="regular-text" name="admission_date" value="' . $value . '" placeholder="Admission Date">';
  }

  public function displayAdmissionYear() {
    $value = esc_attr( get_option('admission_year') );
    echo '<input type="text" class="regular-text" name="admission_year" value="' . $value . '" placeholder="Admission Year">';
  }

  public function displayAdmissionType() {
    $value = esc_attr( get_option('admission_type') );
    echo '<input type="text" class="regular-text" name="admission_type" value="' . $value . '" placeholder="Admission Type">';
  }

  public function displayMeritMarks1() {
    $value = esc_attr( get_option('merit_marks1') );
    echo '<input type="text" class="regular-text" name="merit_marks1" value="' . $value . '" placeholder="Merit Marks 1">';
  }

  public function displayMeritMarks2() {
    $value = esc_attr( get_option('merit_marks2') );
    echo '<input type="text" class="regular-text" name="merit_marks2" value="' . $value . '" placeholder="Merit Marks 2">';
  }

  public function displayMeritRank() {
    $value = esc_attr( get_option('merit_rank') );
    echo '<input type="text" class="regular-text" name="merit_rank" value="' . $value . '" placeholder="Merit Rank">';
  }

  public function displayAdmissionCategory() {
    $value = esc_attr( get_option('admission_category') );
    echo '<input type="text" class="regular-text" name="admission_category" value="' . $value . '" placeholder="Admission Category">';
  }



  public function displayStudentAdmissionUpdateListAction() {
    echo '<input type="hidden" name="action" value="update_student_admission_getID_action">';
  }

  public function displayStudentAdmissionUpdateID( $id ) {
    echo '<input type="hidden" name="student_admission_id" value="'. $id . '">';
  }

  public function addStudentAdmission() {


      global $wpdb;
  		$table = $wpdb->prefix . 'acad_student_admission';

      $check = $wpdb->insert( $table,
        array(
          'StudentEnrollmentNumber' => $_POST['student_enrollment_number'],
  			  'AdmissionDate' => $_POST['admission_date'],
  			  'AdmissionYear' => $_POST['admission_year'],
  			  'AdmissionType' => $_POST['admission_type'],
  			  'MeritMarks1' => $_POST['merit_marks1'],
  			  'MeritMarks2' => $_POST['merit_marks2'],
  			  'MeritRank' => $_POST['merit_rank'],
          'AdmissionCategory' => $_POST['admission_category']
        )
      );

      wp_redirect(admin_url('admin.php?page=acad_student_admission'));

  }

  public function viewStudentAdmissions() {
    if( current_user_can('add_student_admission') || current_user_can('view_student_admissions') ) {
      global $wpdb;

      $table = $wpdb->prefix.'acad_student';
      $table = $wpdb->prefix.'acad_student_admission';
      $rows = $wpdb->get_results( "SELECT * FROM $table" );

			echo '<table class="widefat", width="100%">
	  		<thead>
	    		<tr>
	      		<th>Student Enrollment Number</th>
	      		<th>Admission Date</th>
	      		<th>Admission Year</th>
	      		<th>Admission Type</th>
	      		<th>Merit marks 1</th>
	      		<th>Merit marks 2</th>
	      		<th>Merit Rank</th>
            <th>Admission Category</th>
            </tr>
	  		</thead>
	  		<tbody>';
	      	foreach($rows as $row){
	           echo "<tr ><td>".$row->StudentEnrollmentNumber."</td><td>".$row->AdmissionDate."</td><td> ".$row->AdmissionYear."</td><td>".$row->AdmissionType."</td><td> ".$row->MeritMarks1."</td><td>".$row->MeritMarks2."</td><td>".$row->MeritRank."</td><td>".$row->AdmissionCategory."</td></tr>\n";
		      }
	      echo '</tbody>
			</table>';
    }
  }

  public function updateStudentAdmission() {
    if( current_user_can('update_StudentAdmission') ) {

    }
  }
}
?>
