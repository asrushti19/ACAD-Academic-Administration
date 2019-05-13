<?php
/**
 * @package  AcadPlugin
 */
namespace Inc\Api\Callbacks;

use Inc\Base\BaseController;

class LogTableCallbacks extends BaseController {
  public function acadLogTableSection() {
    echo "<h3> LogTable Creation </h3>";
  }

  public function displayLogTableAction() {
    echo '<input type="hidden" name="action" value="add_log_table_action">';
  }

  public function displayModifiedBy() {
    $value = esc_attr( get_option('modified_by') );
    echo '<input type="text" class="regular-text" name="modified_by" value="' . $value . '" placeholder="Modified By">';
  }
  public function displayModifiedOn() {
    $value = esc_attr( get_option('modified_on') );
    echo '<input type="text" class="regular-text" name="modified_on" value="' . $value . '" placeholder="Modified on">';
  }
  public function displayCreatedBy() {
    $value = esc_attr( get_option('created_by') );
    echo '<input type="text" class="regular-text" name="created_by" value="' . $value . '" placeholder="Created By">';
  }
  public function displayCreatedOn() {
    $value = esc_attr( get_option('created_on') );
    echo '<input type="text" class="regular-text" name="created_on" value="' . $value . '" placeholder="Created On">';
  }


  public function displayLogTableUpdateListAction() {
    echo '<input type="hidden" name="action" value="update_log_table_getID_action">';
  }

  public function displayLogTableUpdateID( $id ) {
    echo '<input type="hidden" name="log_table_id" value="'. $id . '">';
  }

  public function addLogTable() {

    if( current_user_can('add_log_table') ) {
      global $wpdb;
  		$table = $wpdb->prefix . 'acad_log_table';

      $check = $wpdb->insert( $table,
        array(
          'FeedbackCategoryName' => $_POST['log_table_name']
        )
      );

      wp_redirect(admin_url('admin.php?page=acad_log_table'));
    }

    else {
      echo "You are not autorized to add a new LogTable";
    }
  }

  public function viewLogTables() {
    if( current_user_can('add_log_table') || current_user_can('view_log_tables') ) {
      global $wpdb;
      $table = $wpdb->prefix.'acad_log_table';
      $rows = $wpdb->get_results( "SELECT * FROM $table" );

			echo '<table class="widefat", width="100%">
	  		<thead>
	    		<tr>
	      		<th>ModifiedBy</th>
            <th>ModifiedOn</th>
            <th>CreatedBy</th>
            <th>CreatedOn</th>
            </tr>
	  		</thead>
	  		<tbody>';
	      	foreach($rows as $row){
            echo "<tr ><td>".$row->ModifiedBy."</td><td>".$row->ModifiedOn."</td><td> ".$row->CreatedBy."</td><td>".$row->CreatedOn."</td><td>\n";
         }
	      echo '</tbody>
			</table>';
    }
  }

  public function updateLogTable() {
    if( current_user_can('update_LogTable') ) {

    }

    }
  }

?>
