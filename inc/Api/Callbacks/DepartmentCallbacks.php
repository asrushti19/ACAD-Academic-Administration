<?php
/**
 * @package  AcadPlugin
 */
namespace Inc\Api\Callbacks;

use Inc\Base\BaseController;

class DepartmentCallbacks extends BaseController {
  public function acadDepartmentSection() {
    echo "<h3> Department Creation </h3>";
  }

  public function displayDepartmentAction() {
    echo '<input type="hidden" name="action" value="add_department_action">';
  }

  public function displayDepartmentAbbreviation() {
    //echo "Inside ";
    $value = esc_attr( get_option('department_abbreviation') );
    echo '<input type="text" class="regular-text" name="department_abbreviation" value="' . $value . '" placeholder="Department Abbreviation">';
  }

  public function displayDepartmentName() {
    $value = esc_attr( get_option('department_name') );
    echo '<input type="text" class="regular-text" name="department_name" value="' . $value . '" placeholder="Department Name">';
  }

  public function displayDepartmentCode() {
    $value = esc_attr( get_option('department_code') );
    echo '<input type="text" class="regular-text" name="department_code" value="' . $value . '" placeholder="Department Code">';
  }

  public function displayEstablishmentYear() {
    $value = esc_attr( get_option('establishment_year') );
    echo '<input type="date" class="regular-text" name="establishment_year" value="' . $value . '" placeholder="Establishment Year">';
  }

  public function displayFaxNo() {
    $value = esc_attr( get_option('fax_no') );
    echo '<input type="text" class="regular-text" name="fax_no" value="' . $value . '" placeholder="Fax Number">';
  }

  public function displayPhoneNo() {
    $value = esc_attr( get_option('phone_no') );
    echo '<input type="number" step="0.01"  name="phone_no" value="' . $value . '" placeholder="Phone Number">';
  }

  public function displayEmail() {
    $value = esc_attr( get_option('email') );
    echo '<input type="email" onclick="ValidateEmail(this.value) class="regular-text" name="email" value="' . $value . '" placeholder="Email">';
  }

  public function displayDepartmentUpdateListAction() {
    echo '<input type="hidden" name="action" value="update_department_getID_action">';
  }

  public function displayDepartmentUpdateID( $id ) {
    echo '<input type="hidden" name="department_id" value="'. $id . '">';
  }

  public function addDepartment() {

    if( current_user_can('add_department') ) {
      global $wpdb;
  		$table = $wpdb->prefix . 'acad_department';

      $check = $wpdb->insert( $table,
        array(
          'DepartmentAbbreviation' => $_POST['department_abbreviation'],
  			  'DepartmentName' => $_POST['department_name'],
  			  'DepartmentCode' => $_POST['department_code'],
  			  'EstablishmentYear' => $_POST['establishment_year'],
  			  'FaxNo' => $_POST['fax_no'],
  			  'PhoneNo' => $_POST['phone_no'],
  			  'Email' => $_POST['email']
        )
      );

      wp_redirect(admin_url('admin.php?page=acad_department'));
    }

    else {
      echo "You are not autorized to add a new Department";
    }
  }

  public function deleteDepartment(){
    if( current_user_can('add_department') || current_user_can('view_departments') ) {
      global $wpdb;

      $table = $wpdb->prefix.'acad_department';
      $rows = $wpdb->get_results( "SELECT * FROM $table" );

			echo '<table class="widefat", width="100%">
	  		<thead>
	    		<tr>
	      		<th>Name</th>
	      		<th>Abbreviation</th>
	      		<th>Code</th>
	      		<th>Establishment Year</th>
	      		<th>Fax No</th>
	      		<th>Phone No</th>
	      		<th>Email</th>
            </tr>
	  		</thead>
	  		<tbody>';
	      	foreach($rows as $row){
	          echo "<tr ><td>".$row->DepartmentName."</td><td>".$row->DepartmentAbbreviation."</td><td> ".$row->DepartmentCode."</td><td>".$row->EstablishmentYear."</td><td> ".$row->FaxNo."</td><td>".$row->PhoneNo."</td><td>".$row->Email."</td></td>\n";
            echo '<td><form method="post"><input type="submit" name="delete" value="Delete"><input type="hidden" name="department_id" value="'.$row->DepartmentID.'"></form></td>';

		     if ($_POST) {
          global $wpdb;
          echo "Inside";
          $table = $wpdb->prefix . 'acad_department';
          $id = $_POST['department_id'];
          $res = $wpdb->query("DELETE FROM $table WHERE DepartmentID = ".$id);
               echo "<meta http-equiv='refresh' content='0'>";
     }
    }
  }
}

  public function viewDepartments() {
    if( current_user_can('add_department') || current_user_can('view_departments') ) {
      global $wpdb;
      $table = $wpdb->prefix.'acad_department';
      $rows = $wpdb->get_results( "SELECT * FROM $table" );

			echo '<table class="widefat", width="100%">
	  		<thead>
	    		<tr>
	      		<th>Name</th>
	      		<th>Abbreviation</th>
	      		<th>Code</th>
	      		<th>Establishment Year</th>
	      		<th>Fax No</th>
	      		<th>Phone No</th>
	      		<th>Email</th>
            </tr>
	  		</thead>
	  		<tbody>';
	      	foreach($rows as $row){
	          echo "<tr ><td>".$row->DepartmentName."</td><td>".$row->DepartmentAbbreviation."</td><td> ".$row->DepartmentCode."</td><td>".$row->EstablishmentYear."</td><td> ".$row->FaxNo."</td><td>".$row->PhoneNo."</td><td>".$row->Email."</td></tr>\n";
		      }
	      echo '</tbody>
			</table>';
    }
  }

  public function updateDepartment() {
    if($_POST)
  {
  }
    else {
        global $wpdb;
        $table = $wpdb->prefix.'acad_department';
        $rows = $wpdb->get_results( "SELECT * FROM $table" );




      }
  }
}
