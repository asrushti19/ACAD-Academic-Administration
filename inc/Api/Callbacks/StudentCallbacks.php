<?php
/**
 * @package  AcadPlugin
 */
namespace Inc\Api\Callbacks;

use Inc\Base\BaseController;

class StudentCallbacks extends BaseController {
  public function acadStudentSection() {
    echo "<h3> Student Addition </h3>";
  }

  public function displayStudentAction() {
    echo '<input type="hidden" name="action" value="add_student_action">';
  }

  public function displayProgramID() {
    global $wpdb;
    $table = $wpdb->prefix.'acad_program';
    $rows = $wpdb->get_results( "SELECT * FROM $table" );

    echo '<select name="program_id">';
    foreach ($rows as $row ) {
      //echo $row->DepartmentID . " ";
      echo '<option value="'. $row->ProgramID . '"> '.$row->ProgramID .'</option>';
    }
    echo '</select>';
  }

  public function displayFirstName() {
    $value = esc_attr( get_option('first_name') );
    echo '<input type="text" class="regular-text" name="first_name" value="' . $value . '" placeholder="First Name">';
  }

  public function displayMiddleName() {
    $value = esc_attr( get_option('middle_name') );
    echo '<input type="text" class="regular-text" name="middle_name" value="' . $value . '" placeholder="Middle Name">';
  }

  public function displayLastName() {
    $value = esc_attr( get_option('last_name') );
    echo '<input type="text" class="regular-text" name="last_name" value="' . $value . '" placeholder="Last Name">';
  }

  public function displayMotherName() {
    $value = esc_attr( get_option('mother_name') );
    echo '<input type="text" class="regular-text" name="mother_name" value="' . $value . '" placeholder="Mother Name">';
  }

  public function displayGender() {
    $value = esc_attr( get_option('gender') );
    echo '<input type="text" class="regular-text" name="gender" value="' . $value . '" placeholder="Gender">';
  }

  public function displayDOB() {
    $value = esc_attr( get_option('dob') );
    echo '<input type="text" class="regular-text" name="dob" value="' . $value . '" placeholder="DOB">';
  }

  public function displayBloodGroup() {
    $value = esc_attr( get_option('blood_group') );
    echo '<input type="text" class="regular-text" name="blood_group" value="' . $value . '" placeholder="Blood group">';
  }

  public function displayTempAddrLine1() {
    $value = esc_attr( get_option('temp_addr_line_1') );
    echo '<input type="text" class="regular-text" name="temp_addr_line_1" value="' . $value . '" placeholder="Temp Address Line 1">';
  }

  public function displayTempAddrTaluka() {
    $value = esc_attr( get_option('temp_addr_taluka') );
    echo '<input type="text" class="regular-text" name="temp_addr_taluka" value="' . $value . '" placeholder="Temporary Address Taluka">';
  }

  public function displayTempAddrDistrict() {
    $value = esc_attr( get_option('temp_addr_district') );
    echo '<input type="text" class="regular-text" name="temp_addr_district" value="' . $value . '" placeholder="Temp Address District">';
  }

  public function displayTempAddrCountry() {
    $value = esc_attr( get_option('temp_addr_country') );
    echo '<input type="text" class="regular-text" name="temp_addr_country" value="' . $value . '" placeholder="TEmporry Adress Country">';
  }

  public function displayTempAddrState() {
    $value = esc_attr( get_option('temp_addr_state') );
    echo '<input type="text" class="regular-text" name="temp_addr_state" value="' . $value . '" placeholder="Temp Address State">';
  }

  public function displayTempAddrPostalCode() {
    $value = esc_attr( get_option('temp_addr_postal_code') );
    echo '<input type="text" class="regular-text" name="temp_addr_postal_code" value="' . $value . '" placeholder="TEmporry Adress Postal Code">';
  }

  public function displayPermAddrLine1() {
    $value = esc_attr( get_option('perm_addr_line1') );
    echo '<input type="text" class="regular-text" name="perm_addr_line1" value="' . $value . '" placeholder="Permanent Address Line 1">';
  }

  public function displayPermAddrTaluka() {
    $value = esc_attr( get_option('perm_addr_taluka') );
    echo '<input type="text" class="regular-text" name="perm_addr_taluka" value="' . $value . '" placeholder="Permanent PermanentAddressTaluka">';
  }

  public function displayPermAddrDistrict() {
    $value = esc_attr( get_option('perm_addr_district') );
    echo '<input type="text" class="regular-text" name="perm_addr_district" value="' . $value . '" placeholder="Permanent Address District">';
  }

  public function displayPermAddrCountry() {
    $value = esc_attr( get_option('perm_addr_country') );
    echo '<input type="text" class="regular-text" name="perm_addr_country" value="' . $value . '" placeholder="Permanent Address Country">';
  }

  public function displayPermAddrState() {
    $value = esc_attr( get_option('perm_addr_state') );
    echo '<input type="text" class="regular-text" name="perm_addr_state" value="' . $value . '" placeholder="Permanent Address State">';
  }

  public function displayPermAddrPincode() {
    $value = esc_attr( get_option('perm_addr_pincode') );
    echo '<input type="text" class="regular-text" name="perm_addr_pincode" value="' . $value . '" placeholder="Permanent Address Pincode">';
  }

  public function displayPermAddrContactNo() {
    $value = esc_attr( get_option('perm_addr_contact_no') );
    echo '<input type="text" class="regular-text" name="perm_addr_contact_no" value="' . $value . '" placeholder="Permanent Address Contact">';
  }

  public function displayPersonalContactNo() {
    $value = esc_attr( get_option('personal_contact_no') );
    echo '<input type="text" class="regular-text" name="personal_contact_no" value="' . $value . '" placeholder="personal contact no">';
  }

  public function displayEmergencyContactNo() {
    $value = esc_attr( get_option('emergency_contact_no') );
    echo '<input type="text" class="regular-text" name="emergency_contact_no" value="' . $value . '" placeholder="Emergency Contact No">';
  }

  public function displayCollegeEmail() {
    $value = esc_attr( get_option('college_email') );
    echo '<input type="text" class="regular-text" name="college_email" value="' . $value . '" placeholder="College Email">';
  }

  public function displayPersonalEmail() {
    $value = esc_attr( get_option('personal_email') );
    echo '<input type="text" class="regular-text" name="personal_email" value="' . $value . '" placeholder="Perspnal Email">';
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

  public function displayIsHandicapped() {
    $value = esc_attr( get_option('is_handicapped') );
    echo '<input type="text" class="regular-text" name="is_handicapped" value="' . $value . '" placeholder="Handicapped">';
  }

  public function displayIsCurrent() {
    $value = esc_attr( get_option('is_current') );
    echo '<input type="text" class="regular-text" name="is_current" value="' . $value . '" placeholder="Current">';
  }

  public function displayAadharID() {
    $value = esc_attr( get_option('aadhar_id') );
    echo '<input type="text" class="regular-text" name="aadhar_id" value="' . $value . '" placeholder="Aadhar ID">';
  }

  public function displayPhoto() {
    $value = esc_attr( get_option('photo') );
    echo '<input type="text" class="regular-text" name="photo" value="' . $value . '" placeholder="Photo">';
  }

  public function displayBankAccountNumber() {
    $value = esc_attr( get_option('bank_account_number') );
    echo '<input type="text" class="regular-text" name="bank_account_number" value="' . $value . '" placeholder="Bank Account Number ">';
  }

  public function displayBankName() {
    $value = esc_attr( get_option('bank_name') );
    echo '<input type="text" class="regular-text" name="bank_name" value="' . $value . '" placeholder="Bank Name">';
  }

  public function displayBankBranchName() {
    $value = esc_attr( get_option('bank_branch_name') );
    echo '<input type="text" class="regular-text" name="bank_branch_name" value="' . $value . '" placeholder="Bank Branch ">';
  }

  public function displayBankBranchCode() {
    $value = esc_attr( get_option('bank_branch_code') );
    echo '<input type="text" class="regular-text" name="bank_branch_code" value="' . $value . '" placeholder="Bank Branch Code ">';
  }

  public function displayStudentUpdateListAction() {
    echo '<input type="hidden" name="action" value="update_student_getID_action">';
  }

  public function displayStudentUpdateID( $id ) {
    echo '<input type="hidden" name="student_id" value="'. $id . '">';
  }

  public function addStudent() {

    if( current_user_can('add_student') ) {
      global $wpdb;
  		$table = $wpdb->prefix . 'acad_student';

      $check = $wpdb->insert( $table,
        array(
          'ProgramID' => $_POST['program_id'],
  			  'FirstName' => $_POST['first_name'],
  			  'MiddleName' => $_POST['middle_name'],
  			  'LastName' => $_POST['last_name'],
  			  'MotherName' => $_POST['mother_name'],
  			  'Gender' => $_POST['gender'],
  			  'DOB' => $_POST['dob'],
          'BloodGroup' => $_POST['blood_group'],
  			  'TempAddrLine1' => $_POST['temp_addr_line_1'],
  			  'TempAddrTaluka' => $_POST['temp_addr_taluka'],
  			  'TempAddrDistrict' => $_POST['temp_addr_district'],
  			  'TempAddrCountry' => $_POST['temp_addr_country'],
  			  'TempAddrState' => $_POST['temp_addr_state'],
  			  'TempAddrPostalCode' => $_POST['temp_addr_postal_code'],
          'PermAddrLine1' => $_POST['perm_addr_line_1'],
  			  'PermAddrTaluka' => $_POST['perm_addr_taluka'],
  			  'PermAddrDistrict' => $_POST['perm_addr_district'],
  			  'PermAddrCountry' => $_POST['perm_addr_country'],
  			  'PermAddrState' => $_POST['perm_addr_state'],
  			  'PermAddrPincode' => $_POST['perm_addr_pincode'],
  			  'PermAddrContactNo' => $_POST['perm_addr_contact_no'],
          'PersonalContactNo' => $_POST['personal_contact_no'],
  			  'EmergencyContactNo' => $_POST['emergency_contact_no'],
  			  'CollegeEmail' => $_POST['college_email'],
  			  'PersonalEmail' => $_POST['personal_email'],
  			  'Caste' => $_POST['caste'],
  			  'Religion' => $_POST['religion'],
  			  'CasteCategory' => $_POST['caste_category'],
          'IsHandicapped' => $_POST['is_handicapped'],
         'IsCurrent' => $_POST['is_current'],
         'AadharID' => $_POST['aadhar_id'],
          'Photo' => $_POST['photo'],
         'BankAccountNumber' => $_POST['bank_account_numberccountnumber'],
         'BankName' => $_POST['bank_namenme'],
         'BankBranchName' => $_POST['bank_branch_name'],
         'BankBranchCode' => $_POST['bank_branch_code']
        )
      );

      wp_redirect(admin_url('admin.php?page=acad_student'));
    }

    else {
      echo "You are not autorized to add a new Student";
    }
  }

  public function viewStudents() {
    if( current_user_can('add_student') || current_user_can('view_students') ) {
      global $wpdb;

      $table = $wpdb->prefix.'acad_program';
      $table = $wpdb->prefix.'acad_student';
      $rows = $wpdb->get_results( "SELECT * FROM $table" );


			echo '<table class="widefat", width="100%">
	  		<thead>
	    		<tr>
	      		<th>ProgramID</th>
	      		<th>First name</th>
	      		<th>Middle Name</th>
	      		<th>Last name</th>
	      		<th>Mother name</th>
	      		<th>Gender</th>
	      		<th>DOB</th>
            <th>Blood Group</th>
            <th>TempAddr Line1</th>
            <th>TempAddr Taluka</th>
            <th>TempAddrDistrict</th>
            <th>TempAddr Country</th>
            <th>TempAddr State </th>
            <th>TempAddrPostalCode</th>
            <th>PermAddrLine1</th>
            <th>PermAddr Taluka</th>
            <th>PermAddr District</th>
            <th>PermAddr Country</th>
            <th>PermAddrState</th>
            <th>PermAddr Pincode</th>
            <th>PermAddr Contact No</th>
            <th>PersonalContactNo</th>
            <th>EmergencyContactNo</th>
            <th>CollegeEmail</th>
            <th>PersonalEmail</th>
            <th>Caste</th>
            <th>Religion</th>
            <th>CasteCategory</th>
            <th>IsHandicapped</th>
            <th>IsCurrent</th>
            <th>AadharID</th>
            <th>Phhoto</th>
            <th>BankAccountNumber</th>
            <th>Bank Name</th>
            <th>Bank Branch</th>
            <th>Bank Branch Code</th>
            </tr>
	  		</thead>
	  		<tbody>';
	      	foreach($rows as $row){
	          echo "</td><td>".$row->ProgramID."</td><td>".$row->FirstName."</td><td> ".$row->MiddleName.
            "</td><td>".$row->LastName."</td><td> ".$row->MotherName."</td><td>".$row->Gender.
            "</td><td>".$row->DOB."</td><td>".$row->BloodGroup."</td><td>".$row->TempAddrLine1.
            "</td><td>".$row->TempAddrTaluka."</td><td>".$row->TempAddrDistrict."</td><td>".$row->TempAddrCountry.
            "</td><td>".$row->TempAddrState."</td><td>".$row->TempAddrPostalCode."</td><td>".$row->PermAddrLine1.
            "</td><td>".$row->PermAddrTaluka."</td><td>".$row->PermAddrDistrict."</td><td>".$row->PermAddrCountry.
            "</td><td>".$row->PermAddrState."</td><td>".$row->PermAddrPincode."</td><td>".$row->PermAddrContactNo.
            "</td><td>".$row->PersonalContactNo."</td><td>".$row->EmergencyContactNo."</td><td>".$row->CollegeEmail.
            "</td><td>".$row->PersonalEmail."</td><td>".$row->Caste."</td><td>".$row->Religion.
            "</td><td>".$row->CasteCategory."</td><td>".$row->IsHandicapped."</td><td>".$row->IsCurrent.
            "</td><td>".$row->AadharID."</td><td>".$row->Photo."</td><td>".$row->BankAccountNumber.
            "</td><td>".$row->BankName."</td><td>".$row->BankBranchName."</td><td>".$row->BankBranchCode."</td></tr>\n";
		      }
	      echo '</tbody>
			</table>';
    }
  }

  public function updateStudent() {

  }
}
?>
