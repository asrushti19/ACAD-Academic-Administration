<?php
/**
 * @package  AcadPlugin
 */
namespace Inc\Api\Callbacks;

use Inc\Base\BaseController;

class ExamCallbacks extends BaseController {
  public function acadExamSection() {
    echo "<h3> Exam Type Creation </h3>";
  }

  public function displayExamAction() {
    echo '<input type="hidden" name="action" value="add_exam_action">';
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

  public function displayExamTypeID() {
    global $wpdb;
    $table = $wpdb->prefix.'acad_exam_type';
    $rows = $wpdb->get_results( "SELECT * FROM $table" );

    echo '<select name="exam_type_id">';
    foreach ($rows as $row ) {

      echo '<option value="'. $row->ExamTypeID . '"> '.$row->ExamName .'</option>';
    }
    echo '</select>';
  }
  public function displayEvaluationType() {
    $value = esc_attr( get_option('evaluation_type') );
    echo '<input type="text" class="regular-text" name="evaluation_type" value="' . $value . '" placeholder="EvaluationType">';
  }
  public function displayDateOfExam() {
    $value = esc_attr( get_option('date_of_exam') );
    echo '<input type="date" class="regular-text" name="date_of_exam" value="' . $value . '" placeholder="DateOfExam">';
  }
  public function displayDuration() {
    $value = esc_attr( get_option('duration') );
    echo '<input type="text" class="regular-text" name="duration" value="' . $value . '" placeholder="Duration">';
  }
  public function displayTimeOfExam() {
    $value = esc_attr( get_option('time_of_exam') );
    echo '<input type="text" class="regular-text" name="time_of_exam" value="' . $value . '" placeholder="Time Of Exam">';
  }
  public function displayPlace() {
    $value = esc_attr( get_option('place') );
    echo '<input type="text" class="regular-text" name="place" value="' . $value . '" placeholder="Place">';
  }


   public function displayExamUpdateListAction() {
      echo '<input type="hidden" name="action" value="update_exam_getID_action">';
    }

    public function displayExamUpdateID( $id ) {
      echo '<input type="hidden" name="exam_id" value="'. $id . '">';
    }

  public function addExam() {

    if( current_user_can('add_exam') ) {
      global $wpdb;
  		$table = $wpdb->prefix . 'acad_exam';

      $check = $wpdb->insert( $table,
        array(
          'FacultyID' => $_POST['faculty_id'],
          'CourseID' => $_POST['course_id'],
          'ExamTypeID' => $_POST['exam_type_id'],
  			  'EvaluationType' => $_POST['evaluation_type'],
          'DateOfExam' => $_POST['date_of_exam'],
          'Duration' => $_POST['duration'],
          'TimeOfExam' => $_POST['time_of_exam'],
          'Place' => $_POST['place']

        )
      );

      wp_redirect(admin_url('admin.php?page=acad_exam'));
    }

    else {
      echo "You are not autorized to add a new Exam";
    }
  }

  public function viewExams() {
    if( current_user_can('add_exam') || current_user_can('view_exams') ) {
      global $wpdb;

      $table = $wpdb->prefix. 'acad_faculty';
      $table = $wpdb->prefix. 'acad_course';
      $table = $wpdb->prefix. 'acad_exam_type';
      $table = $wpdb->prefix.'acad_exam';
      $rows = $wpdb->get_results( "SELECT * FROM $table" );

			echo '<table class="widefat", width="100%">
	  		<thead>
	    		<tr>
	      		<th>Faculty ID</th>
            <th>Course ID</th>
            <th>ExamType ID</th>
            <th>Evaluation Type</th>
            <th>Date Of Exam</th>
            <th>Duration</th>
            <th>Time Of Exam</th>
	      		<th>Place</th>
            </tr>
	  		</thead>
	  		<tbody>';
	      	foreach($rows as $row){
	          echo "</td><td>".$row->FacultyID."</td><td>".$row->CourseID."</td><td>".$row->ExamTypeID."</td><td>".$row->EvaluationType."</td><td>".$row->DateOfExam."</td><td>".$row->Duration."</td><td>".$row->TimeOfExam."</td><td>".$row->Place."</td></tr>\n";
		      }
	      echo '</tbody>
			</table>';
    }
  }

  public function updateExam() {
    if( current_user_can('update_Exam') ) {

    }
  }
}
?>
