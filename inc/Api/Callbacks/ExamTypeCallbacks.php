<?php
/**
 * @package  AcadPlugin
 */
namespace Inc\Api\Callbacks;

use Inc\Base\BaseController;

class ExamTypeCallbacks extends BaseController {
  public function acadExamTypeSection() {
    echo "<h3> Exam Type Creation </h3>";
  }

  public function displayExamTypeAction() {
    echo '<input type="hidden" name="action" value="add_exam_type_action">';
  }

  public function displayExamName() {
    $value = esc_attr( get_option('exam_name') );
    echo '<input type="text" class="regular-text" name="exam_name" value="' . $value . '" placeholder="Exam Name">';
  }

  public function displayMaxMark() {
    $value = esc_attr( get_option('max_mark') );
    echo '<input type="number" step="0.01" class="regular-text" name="max_mark" value="' . $value . '" placeholder="Max Mark">';
  }
   public function displayExamTypeUpdateListAction() {
      echo '<input type="hidden" name="action" value="update_exam_type_getID_action">';
    }

    public function displayExamTypeUpdateID( $id ) {
      echo '<input type="hidden" name="exam_id" value="'. $id . '">';
    }

  public function addExamType() {

    if( current_user_can('add_exam_type') ) {
      global $wpdb;
  		$table = $wpdb->prefix . 'acad_exam_type';

      $check = $wpdb->insert( $table,
        array(
          'ExamName' => $_POST['exam_name'],
  			  'MaxMark' => $_POST['max_mark']
        )
      );

      wp_redirect(admin_url('admin.php?page=acad_exam_type'));
    }

    else {
      echo "You are not autorized to add a new Exam";
    }
  }
  public function deleteExamTypes() {
    if( current_user_can('add_exam_type') || current_user_can('view_exam_types') ) {
      global $wpdb;
      $table = $wpdb->prefix.'acad_exam_type';
      $rows = $wpdb->get_results( "SELECT * FROM $table" );

			echo '<table class="widefat", width="100%">
	  		<thead>
	    		<tr>
	      		<th>Exam Name</th>
	      		<th>Max Marks</th>
            </tr>
	  		</thead>
	  		<tbody>';
	      	foreach($rows as $row){
	          echo "<tr ><td>".$row->ExamName."</td><td>".$row->MaxMark."</td></td>\n";
            echo '<td><form method="post"><input type="submit" name="delete" value="Delete"><input type="hidden" name="exam_type_id" value="'.$row->ExamTypeID.'"></form></td>';

          if ($_POST) {
          global $wpdb;
              echo "Inside";
              $table = $wpdb->prefix . 'acad_exam_type';
              $id = $_POST['exam_type_id'];
              $res = $wpdb->query("DELETE FROM $table WHERE ExamTypeID = ".$id);
               echo "<meta http-equiv='refresh' content='0'>";

          }
        }
      }
    }
  public function viewExamTypes() {
    if( current_user_can('add_exam_type') || current_user_can('view_exam_types') ) {
      global $wpdb;
      $table = $wpdb->prefix.'acad_exam_type';
      $rows = $wpdb->get_results( "SELECT * FROM $table" );

			echo '<table class="widefat", width="100%">
	  		<thead>
	    		<tr>
	      		<th>Exam Name</th>
	      		<th>Max Marks</th>
            </tr>
	  		</thead>
	  		<tbody>';
	      	foreach($rows as $row){
	          echo "<tr ><td>".$row->ExamName."</td><td>".$row->MaxMark."</td></tr>\n";
		      }
	      echo '</tbody>
			</table>';
    }
  }

  public function updateExamType() {
    if( current_user_can('update_ExamType') ) {

    }
  }
}
?>
