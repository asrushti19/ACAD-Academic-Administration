<?php
/**
 * @package  AcadPlugin
 */
namespace Inc\Api\Callbacks;

use Inc\Base\BaseController;

class FacultyCallbacks extends BaseController {
  public function acadFacultySection() {
    echo "<h3> Faculty Addition </h3>";
  }

  public function displayFacultyAction() {
    echo '<input type="hidden" name="action" value="add_faculty_action">';
  }

  public function displayDepartmentID() {
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

  public function displayFacultyName() {
    $value = esc_attr( get_option('faculty_name') );
    echo '<input type="text" class="regular-text" name="faculty_name" value="' . $value . '" placeholder="Faculty Name">';
  }

  public function displayYearOfJoining() {
    $value = esc_attr( get_option('year_of_joining') );
    echo '<input type="text" class="regular-text" name="year_of_joining" value="' . $value . '" placeholder="Year Of Joining">';
  }

  public function displayDateOfBirth() {
    $value = esc_attr( get_option('date_of_birth') );
    echo '<input type="text" class="regular-text" name="date_of_birth" value="' . $value . '" placeholder="Date Of Birth">';
  }

  public function displayPermanentAddressLine1() {
    $value = esc_attr( get_option('permanent_address_line1') );
    echo '<input type="text" class="regular-text" name="permanent_address_line1" value="' . $value . '" placeholder="Permanent Address Line1">';
  }

  public function displayPermanentAddressCountry() {
    $value = esc_attr( get_option('permanent_address_country') );
    echo '<input type="text" class="regular-text" name="permanent_address_country" value="' . $value . '" placeholder="Permanent Address Country">';
  }

  public function displayPermanentAddressState() {
    $value = esc_attr( get_option('permanent_address_state') );
    echo '<input type="text" class="regular-text" name="permanent_address_state" value="' . $value . '" placeholder="Permanent Address State">';
  }

  public function displayPermanentAddressDistrict() {
    $value = esc_attr( get_option('permanent_address_district') );
    echo '<input type="text" class="regular-text" name="permanent_address_district" value="' . $value . '" placeholder="PermanentAddress Sistrict">';
  }

  public function displayPermanentAddressVillage() {
    $value = esc_attr( get_option('permanent_address_village') );
    echo '<input type="text" class="regular-text" name="permanent_address_village" value="' . $value . '" placeholder="PermanentAddress Village">';
  }

  public function displayPermanentAddressTaluka() {
    $value = esc_attr( get_option('permanent_address_taluka') );
    echo '<input type="text" class="regular-text" name="permanent_address_taluka" value="' . $value . '" placeholder="PermanentAddress Taluka">';
  }

  public function displayPermanentAddressPincode() {
    $value = esc_attr( get_option('permanent_address_pincode') );
    echo '<input type="text" class="regular-text" name="permanent_address_pincode" value="' . $value . '" placeholder="PermanentAddress pincode">';
  }

  public function displayTemporaryAddressLine1() {
    $value = esc_attr( get_option('temporary_address_line1') );
    echo '<input type="text" class="regular-text" name="temporary_address_line1" value="' . $value . '" placeholder="TemporaryAddress Line1">';
  }

  public function displayTemporaryAddressCountry() {
    $value = esc_attr( get_option('temporary_address_country') );
    echo '<input type="text" class="regular-text" name="temporary_address_country" value="' . $value . '" placeholder="TemporaryAddress Country">';
  }

  public function displayTemporaryAddressState() {
    $value = esc_attr( get_option('temporary_address_state') );
    echo '<input type="text" class="regular-text" name="temporary_address_state" value="' . $value . '" placeholder="TemporaryAddress State">';
  }

  public function displayTemporaryAddressDistrict() {
    $value = esc_attr( get_option('temporary_address_district') );
    echo '<input type="text" class="regular-text" name="temporary_address_district" value="' . $value . '" placeholder="TemporaryAddress District">';
  }

  public function displayTemporaryAddressVillage() {
    $value = esc_attr( get_option('temporary_address_village') );
    echo '<input type="text" class="regular-text" name="temporary_address_village" value="' . $value . '" placeholder="TemporaryAddress Village">';
  }

  public function displayTemporaryAddressTaluka() {
    $value = esc_attr( get_option('temporary_address_taluka') );
    echo '<input type="text" class="regular-text" name="temporary_address_taluka" value="' . $value . '" placeholder="TemporaryAddress Taluka">';
  }

  public function displayTemporaryAddressPincode() {
    $value = esc_attr( get_option('temporary_address_pincode') );
    echo '<input type="text" class="regular-text" name="temporary_address_pincode" value="' . $value . '" placeholder="TemporaryAddress Pincode">';
  }

  public function displayCollegEmail() {
    $value = esc_attr( get_option('college_email') );
    echo '<input type="text" class="regular-text" name="college_email" value="' . $value . '" placeholder="College email">';
  }

  public function displayPersonalEmail() {
    $value = esc_attr( get_option('personal_email') );
    echo '<input type="text" class="regular-text" name="personal_email" value="' . $value . '" placeholder="Personal Email">';
  }

  public function displayContactNo() {
    $value = esc_attr( get_option('contact_no') );
    echo '<input type="text" class="regular-text" name="contact_no" value="' . $value . '" placeholder="Contact no">';
  }

  public function displayEmergencyContactNo() {
    $value = esc_attr( get_option('emergency_contact_no') );
    echo '<input type="text" class="regular-text" name="emergency_contact_no" value="' . $value . '" placeholder="Emergency Contact No">';
  }

  public function displayRelievingDate() {
    $value = esc_attr( get_option('relieving_date') );
    echo '<input type="text" class="regular-text" name="relieving_date" value="' . $value . '" placeholder="Relieving Date">';
  }

  public function displayUniqueNo() {
    $value = esc_attr( get_option('unique_no') );
    echo '<input type="text" class="regular-text" name="unique_no" value="' . $value . '" placeholder="Unique No">';
  }

  public function displayGender() {
    $value = esc_attr( get_option('gender') );
    echo '<input type="text" class="regular-text" name="gender" value="' . $value . '" placeholder="Gender">';
  }

  public function displayBloodGroup() {
    $value = esc_attr( get_option('blood_group') );
    echo '<input type="text" class="regular-text" name="blood_group" value="' . $value . '" placeholder="Blood Group">';
  }

  public function displayCaste() {
    $value = esc_attr( get_option('caste') );
    echo '<input type="text" class="regular-text" name="caste" value="' . $value . '" placeholder="Caste">';
  }

  public function displayReligion() {
    $value = esc_attr( get_option('religion') );
    echo '<input type="text" class="regular-text" name="religion" value="' . $value . '" placeholder="Religion">';
  }

  public function displayCasteCategory() {
    $value = esc_attr( get_option('caste_category') );
    echo '<input type="text" class="regular-text" name="caste_category" value="' . $value . '" placeholder="Caste Category">';
  }

  public function displayIsHandicap() {
    $value = esc_attr( get_option('is_handicap') );
    echo '<input type="text" class="regular-text" name="is_handicap" value="' . $value . '" placeholder="Is Handicap">';
  }

  public function displayBankAccountNo() {
    $value = esc_attr( get_option('bank_account_no') );
    echo '<input type="text" class="regular-text" name="bank_account_no" value="' . $value . '" placeholder="Bank Account ">';
  }

  public function displayAadhaarID() {
    $value = esc_attr( get_option('aadhaar_id') );
    echo '<input type="text" class="regular-text" name="aadhaar_id" value="' . $value . '" placeholder="Aadhssr ID">';
  }

  public function displayPhoto() {
    $value = esc_attr( get_option('photo') );
    echo '<input type="text" class="regular-text" name="photo" value="' . $value . '" placeholder="Photo">';
  }

  public function displayBankName() {
    $value = esc_attr( get_option('bank_name') );
    echo '<input type="text" class="regular-text" name="bank_name" value="' . $value . '" placeholder="Bank Name">';
  }

  public function displayBankBranch() {
    $value = esc_attr( get_option('bank_branch') );
    echo '<input type="text" class="regular-text" name="bank_branch" value="' . $value . '" placeholder="Bank Branch ">';
  }

  public function displayBankBranchCode() {
    $value = esc_attr( get_option('bank_branch_code') );
    echo '<input type="text" class="regular-text" name="bank_branch_code" value="' . $value . '" placeholder="Bank Branch Code ">';
  }

  public function displayFacultyUpdateListAction() {
    echo '<input type="hidden" name="action" value="update_faculty_getID_action">';
  }

  public function displayFacultyUpdateID( $id ) {
    echo '<input type="hidden" name="faculty_id" value="'. $id . '">';
  }

  public function addFaculty() {
    echo "ggg";
    if( current_user_can('add_faculty') ) {
      global $wpdb;
  		$table = $wpdb->prefix . 'acad_faculty';
      echo "inside hereeee";
      $check = $wpdb->insert( $table,
        array(
          'DepartmentID' => $_POST['department_id'],
  			  'FacultyName' => $_POST['faculty_name'],
  			  'YearOfJoining' => $_POST['year_of_joining'],
  			  'DateOfBirth' => $_POST['date_of_birth'],
  			  'PermanentAddressLine1' => $_POST['permanent_address_line1'],
  			  'PermanentAddressCountry' => $_POST['permanent_address_country'],
  			  'PermanentAddressState' => $_POST['permanent_address_state'],
          'PermanentAddressDistrict' => $_POST['permanent_address_district'],
  			  'PermanentAddressVillage' => $_POST['permanent_address_village'],
  			  'PermanentAddressTaluka' => $_POST['permanent_address_taluka'],
  			  'PermanentAddressPincode' => $_POST['permanent_address_pincode'],
  			  'TemporaryAddressLine1' => $_POST['temporary_address_line1'],
  			  'TemporaryAddressCountry' => $_POST['temporary_address_country'],
  			  'TemporaryAddressState' => $_POST['temporary_address_state'],
          'TemporaryAddressDistrict' => $_POST['temporary_address_district'],
  			  'TemporaryAddressVillage' => $_POST['temporary_address_village'],
  			  'TemporaryAddressTaluka' => $_POST['temporary_address_taluka'],
  			  'TemporaryAddressPincode' => $_POST['temporary_address_pincode'],
  			  'CollegeEmail' => $_POST['college_email'],
  			  'PersonalEmail' => $_POST['personal_email'],
  			  'ContactNo' => $_POST['contact_no'],
  			  'EmergencyContactNo' => $_POST['emergency_contact_no'],
  			  'RelievingDate' => $_POST['relieving_date'],
  			  'UniqueNo' => $_POST['unique_no'],
  			  'Gender' => $_POST['gender'],
  			  'BloodGroup' => $_POST['blood_group'],
  			  'Caste' => $_POST['caste'],
          'Religion' => $_POST['religion'],
          'CasteCategory' => $_POST['caste_category'],
          'IsHandicap' => $_POST['is_handicap'],
          'BankAccountNo' => $_POST['bank_account_no'],
          'AadhaarID' => $_POST['aadhaar_id'],
          'Photo' => $_POST['photo'],
          'BankName' => $_POST['bank_name'],
          'BankBranch' => $_POST['bank_branch'],
          'BankBranchCode' => $_POST['bank_branch_code']
        )
      );

      if( !is_a( $check, WP_ERROR ) ) {
        wp_redirect(admin_url('admin.php?page=acad_faculty'));
      }
      else {
        echo $check;
      }

      wp_redirect(admin_url('admin.php?page=acad_faculty'));
}
    else {
      echo "You are not autorized to add a new Faculty";

    }
  }

  public function viewFaculties() {
    if( current_user_can('add_faculty') || current_user_can('view_faculties') ) {
      global $wpdb;

      $department_table = $wpdb->prefix.'acad_department';
      $table = $wpdb->prefix.'acad_faculty';

      $rows = $wpdb->get_results( "SELECT * FROM $table" );


			echo '<table class="widefat", width="100%">
	  		<thead>
	    		<tr>
	      		<th>DepartmentID</th>
	      		<th>Faculty Name</th>
	      		<th>Year Of Joining</th>
	      		<th>Date of birth</th>
	      		<th>Permanenet Address Line1</th>
	      		<th>Permanenet Address Country</th>
	      		<th>Permanenet Address State</th>
            <th>Permanenent Address District</th>
            <th>Permanenent Address Vilage</th>
            <th>Permanenent Address Taluka</th>
            <th>Permanenent Address Pincode</th>
            <th>Temporary Address Line1</th>
            <th>Temporary Address Country </th>
            <th>Temporary Address State</th>
            <th>Temporary Address District</th>
            <th>Temporary Address Village</th>
            <th>Temporary Address Taluka</th>
            <th>Temporary Address Pincode</th>
            <th>College Email</th>
            <th>Personal email</th>
            <th>Contact No</th>
            <th>EmergencyContactNo</th>
            <th>Relieving Date</th>
            <th>Unique Number</th>
            <th>Gender</th>
            <th>Blood Group</th>
            <th>Caste</th>
            <th>Religion</th>
            <th>CasteCategory</th>
            <th>IsHandicap</th>
            <th>BankAccountNo</th>
            <th>Aadhaar ID</th>
            <th>Photo</th>
            <th>Bank Name</th>
            <th>Bank Branch</th>
            <th>Bank Branch Code</th>
            </tr>
	  		</thead>
	  		<tbody>';
	      	foreach($rows as $row){
  	          echo "<tr ><td>".$row->DepartmentID."</td><td>".$row->FacultyName."</td><td> ".$row->YearOfJoining.
            "</td><td>".$row->DateOfBirth."</td><td> ".$row->PermanentAddressLine1."</td><td>".$row->PermanentAddressCountry.
            "</td><td>".$row->PermanentAddressState."</td><td>".$row->PermanentAddressDistrict."</td><td>".$row->PermanentAddressVillage."</td><td>".$row->PermanentAddressTaluka."</td><td>".$row->PermanentAddressPincode."</td><td>".$row->TemporaryAddressLine1."</td><td>".$row->TemporaryAddressCountry."</td><td>".$row->TemporaryAddressState."</td><td>".$row->TemporaryAddressDistrict.
            "</td><td>".$row->TemporaryAddressVillage."</td><td>".$row->TemporaryAddressTaluka."</td><td>".$row->TemporaryAddressPincode.
            "</td><td>".$row->CollegeEmail."</td><td>".$row->PersonalEmail."</td><td>".$row->ContactNo.
            "</td><td>".$row->EmergencyContactNo."</td><td>".$row->RelievingDate."</td><td>".$row->UniqueNo.
            "</td><td>".$row->Gender."</td><td>".$row->Caste."</td><td>".$row->BloodGroup.
            "</td><td>".$row->Caste."</td><td>".$row->Religion."</td><td>".$row->CasteCategory.
            "</td><td>".$row->IsHandicap."</td><td>".$row->BankAccountNo."</td><td>".$row->AadhaarID.
            "</td><td>".$row->Photo."</td><td>".$row->BankName."</td><td>".$row->BankBranch."</td><td>".$row->BankBranchCode."</td></tr>\n";
		      }
	      echo '</tbody>
			</table>';
    }
  }

  public function updateFaculty() {

  }
}
?>
