<?php
/**
 * @package  AcadPlugin
 */
namespace Inc\Pages;

use Inc\Api\SettingsApi;
use Inc\Base\BaseController;

use Inc\Api\Callbacks\AdminCallbacks;
use Inc\Api\Callbacks\DepartmentCallbacks;
use Inc\Api\Callbacks\CourseTypesCallbacks;
use Inc\Api\Callbacks\CourseCallbacks;
use Inc\Api\Callbacks\CurriculumCallbacks;
use Inc\Api\Callbacks\CourseCurriculumMappingCallbacks;
use Inc\Api\Callbacks\ProgramCallbacks;
use Inc\Api\Callbacks\SemesterCallbacks;
use Inc\Api\Callbacks\FacultyRegistrationMappingCallbacks;
use Inc\Api\Callbacks\FacultyCallbacks;
use Inc\Api\Callbacks\FacultyQualificationCallbacks;
use Inc\Api\Callbacks\FacultyExperienceCallbacks;
use Inc\Api\Callbacks\FacultyRequestTypesCallbacks;
use Inc\Api\Callbacks\StudentCallbacks;
use Inc\Api\Callbacks\StudentAdmissionCallbacks;
use Inc\Api\Callbacks\StudentRequestsCallbacks;
use Inc\Api\Callbacks\StudentRequestTypesCallbacks;
use Inc\Api\Callbacks\ExamTypeCallbacks;
use Inc\Api\Callbacks\ExamCallbacks;
use Inc\Api\Callbacks\FeedbackCategoryCallbacks;
use Inc\Api\Callbacks\FacultyCourseMappingCallbacks;
/**
*
*/
class Admin extends BaseController
{
	public $settings;

	public $callbacks;
	public $dept_callbacks;
	public $course_types_callbacks;
	public $course_callbacks;
	public $curriculum_callbacks;
	public $ccm_callbacks;
	public $prog_callbacks;
	public $sem_callbacks;
	public $faculty_reg_map_callbacks;
	public $faculty_callbacks;
	public $faculty_qual_callbacks;
	public $faculty_exp_callbacks;
	public $faculty_req_typ_callbacks;
  public $student_req_typ_callbacks;
	public $student_callbacks;
	public $student_admission_callbacks;
	public $exam_type_callbacks;
	public $exam_callbacks;
	public $feedback_cat_callbacks;
	public $faculty_course_mapping_callbacks;

	public $pages = array();

	public $subpages = array();

	public function register()
	{
		$this->settings = new SettingsApi();

		$this->callbacks = new AdminCallbacks();
		$this->dept_callbacks = new DepartmentCallbacks();
		$this->course_types_callbacks = new CourseTypesCallbacks();
		$this->course_callbacks = new CourseCallbacks();
		$this->curriculum_callbacks = new CurriculumCallbacks();
		$this->ccm_callbacks = new CourseCurriculumMappingCallbacks();
		$this->prog_callbacks = new ProgramCallbacks();
		$this->sem_callbacks = new SemesterCallbacks();
		$this->faculty_reg_map_callbacks = new FacultyRegistrationMappingCallbacks();
		$this->faculty_callbacks = new FacultyCallbacks();
		$this->faculty_qual_callbacks = new FacultyQualificationCallbacks();
		$this->faculty_exp_callbacks = new FacultyExperienceCallbacks();
		$this->faculty_req_typ_callbacks = new FacultyRequestTypesCallbacks();
		$this->student_req_typ_callbacks = new StudentRequestTypesCallbacks();
		$this->student_callbacks = new StudentCallbacks();
		$this->student_admission_callbacks = new StudentAdmissionCallbacks();
		$this->exam_type_callbacks = new ExamTypeCallbacks();
		$this->exam_callbacks = new ExamCallbacks();
		$this->feedback_cat_callbacks = new FeedbackCategoryCallbacks();
		$this->faculty_course_mapping_callbacks = new FacultyCourseMappingCallbacks();

		$this->setPages();

		$this->setSubpages();

		$this->setSettings();
		$this->setSections();
		$this->setFields();
		$this->setFormActions();


		$this->settings->addPages( $this->pages )->withSubPage( 'Dashboard' )->addSubPages( $this->subpages )->register();
	}

	public function setPages()
	{
		$this->pages = array(
			array(
				'page_title' => 'ACAD',
				'menu_title' => 'ACAD',
				'capability' => 'manage_options',
				'menu_slug' => 'ACAD',
				'callback' => array( $this->callbacks, 'adminDashboard' ),
				'icon_url' => 'dashicons-store',
				'position' => 110
			)
		);
	}

	public function setSubpages()
	{
		$this->subpages = array(
			array(
				'parent_slug' => 'ACAD',
				'page_title' => 'Departments',
				'menu_title' => 'Departments',
				'capability' => 'manage_options',
				'menu_slug' => 'acad_department',
				'callback' => array( $this->callbacks, 'adminDepartment' )
			),
			array(
				'parent_slug' => 'ACAD',
				'page_title' => 'CourseTypes',
				'menu_title' => 'CourseTypes',
				'capability' => 'manage_options',
				'menu_slug' => 'acad_course_types',
				'callback' => array( $this->callbacks, 'adminCourseTypes' )
			),
			array(
				'parent_slug' => 'ACAD',
				'page_title' => 'Courses',
				'menu_title' => 'Courses',
				'capability' => 'manage_options',
				'menu_slug' => 'acad_course',
				'callback' => array( $this->callbacks, 'adminCourse' )
			),
			array(
				'parent_slug' => 'ACAD',
				'page_title' => 'Curriculums',
				'menu_title' => 'Curriculums',
				'capability' => 'manage_options',
				'menu_slug' => 'acad_curriculum',
				'callback' => array( $this->callbacks, 'adminCurriculum' )
			),
			array(
				'parent_slug' => 'ACAD',
				'page_title' => 'Course Curriculum Mapping',
				'menu_title' => 'Course Curriculum Mapping',
				'capability' => 'manage_options',
				'menu_slug' => 'acad_course_curriculum_mapping',
				'callback' => array( $this->callbacks, 'adminCourseCurriculumMapping' )
			),
			array(
				'parent_slug' => 'ACAD',
				'page_title' => 'Program',
				'menu_title' => 'Program',
				'capability' => 'manage_options',
				'menu_slug' => 'acad_program',
				'callback' => array( $this->callbacks, 'adminProgram' )
			),
			array(
				'parent_slug' => 'ACAD',
				'page_title' => 'Semester',
				'menu_title' => 'Semester',
				'capability' => 'manage_options',
				'menu_slug' => 'acad_semester',
				'callback' => array( $this->callbacks, 'adminSemester' )
			),
			array(
				'parent_slug' => 'ACAD',
				'page_title' => 'Faculty Registration Mapping',
				'menu_title' => 'Faculty Regsitration Mapping',
				'capability' => 'manage_options',
				'menu_slug' => 'acad_faculty_registration_mapping',
				'callback' => array( $this->callbacks, 'adminFacultyRegistrationMapping' )
			),
			array(
				'parent_slug' => 'ACAD',
				'page_title' => 'Faculty',
				'menu_title' => 'Faculty',
				'capability' => 'manage_options',
				'menu_slug' => 'acad_faculty',
				'callback' => array( $this->callbacks, 'adminFaculty' )
			),
			array(
				'parent_slug' => 'ACAD',
				'page_title' => 'Faculty Qualification',
				'menu_title' => 'Faculty Qualification',
				'capability' => 'manage_options',
				'menu_slug' => 'acad_faculty_qualification',
				'callback' => array( $this->callbacks, 'adminFacultyQualification' )
			),
			array(
				'parent_slug' => 'ACAD',
				'page_title' => 'Faculty Experience',
				'menu_title' => 'Faculty Experience',
				'capability' => 'manage_options',
				'menu_slug' => 'acad_faculty_experience',
				'callback' => array( $this->callbacks, 'adminFacultyExperience' )
			),
			array(
				'parent_slug' => 'ACAD',
				'page_title' => 'Exam Type',
				'menu_title' => 'Exam Type',
				'capability' => 'manage_options',
				'menu_slug' => 'acad_exam_type',
				'callback' => array( $this->callbacks, 'adminExamType' )
			),
			array(
				'parent_slug' => 'ACAD',
				'page_title' => 'Exam ',
				'menu_title' => 'Exam ',
				'capability' => 'manage_options',
				'menu_slug' => 'acad_exam',
				'callback' => array( $this->callbacks, 'adminExam' )
			),
			array(
				'parent_slug' => 'ACAD',
				'page_title' => 'Faculty Registration Mapping',
				'menu_title' => 'Faculty Registration Mapping',
				'capability' => 'manage_options',
				'menu_slug' => 'acad_faculty_registration_mapping',
				'callback' => array( $this->callbacks, 'adminFacultyRegistrationMapping' )
			),
			array(
				'parent_slug' => 'ACAD',
				'page_title' => 'Faculty Request Types',
				'menu_title' => 'Faculty Request Types',
				'capability' => 'manage_options',
				'menu_slug' => 'acad_faculty_request_types',
				'callback' => array( $this->callbacks, 'adminFacultyRequestTypes' )
			),
			array(
				'parent_slug' => 'ACAD',
				'page_title' => 'Student',
				'menu_title' => 'Student',
				'capability' => 'manage_options',
				'menu_slug' => 'acad_student',
				'callback' => array( $this->callbacks, 'adminStudent' )
			),
			array(
				'parent_slug' => 'ACAD',
				'page_title' => 'Student Admission',
				'menu_title' => 'Student Admission',
				'capability' => 'manage_options',
				'menu_slug' => 'acad_student_admission',
				'callback' => array( $this->callbacks, 'adminStudentAdmission' )
			),
			array(
				'parent_slug' => 'ACAD',
				'page_title' => 'Student Request Types',
				'menu_title' => 'Student Request Types',
				'capability' => 'manage_options',
				'menu_slug' => 'acad_student_request_types',
				'callback' => array( $this->callbacks, 'adminStudentRequestTypes' )
			),
			array(
				'parent_slug' => 'ACAD',
				'page_title' => 'Feedback Category',
				'menu_title' => 'Feedback Category',
				'capability' => 'manage_options',
				'menu_slug' => 'acad_feedback_category',
				'callback' => array( $this->callbacks, 'adminFeedbackCategory' )
			)
		);
	}

	public function setSettings()
	{
		$args = array(
			array(
				'option_group' => 'acad_department_options_group',
				'option_name' => 'action'
			),
			array(
				'option_group' => 'acad_department_options_group',
				'option_name' => 'department_abbreviation'
			),
			array(
				'option_group' => 'acad_department_options_group',
				'option_name' => 'department_name'
			),
			array(
				'option_group' => 'acad_department_options_group',
				'option_name' => 'department_code'
			),
			array(
				'option_group' => 'acad_department_options_group',
				'option_name' => 'establishment_year'
			),
			array(
				'option_group' => 'acad_department_options_group',
				'option_name' => 'fax_no'
			),
			array(
				'option_group' => 'acad_department_options_group',
				'option_name' => 'phone_no'
			),
			array(
				'option_group' => 'acad_department_options_group',
				'option_name' => 'email'
			),
			array(
				'option_group' => 'acad_course_types_options_group',
				'option_name' => 'action'
			),
			array(
				'option_group' => 'acad_course_types_options_group',
				'option_name' => 'course_type_name'
			),
			array(
				'option_group' => 'acad_course_options_group',
				'option_name' => 'action'
			),
			array(
				'option_group' => 'acad_course_options_group',
				'option_name' => 'department_id'
			),
			array(
				'option_group' => 'acad_course_options_group',
				'option_name' => 'course_name'
			),
			array(
				'option_group' => 'acad_course_options_group',
				'option_name' => 'course_type'
			),
			array(
				'option_group' => 'acad_course_options_group',
				'option_name' => 'course_abbreviation'
			),
			array(
				'option_group' => 'acad_course_options_group',
				'option_name' => 'course_code'
			),
			array(
				'option_group' => 'acad_course_options_group',
				'option_name' => 'syllabus_code'
			),
			array(
				'option_group' => 'acad_course_options_group',
				'option_name' => 'is_theory'
			),
			array(
				'option_group' => 'acad_course_options_group',
				'option_name' => 'course_credits'
			),
			array(
				'option_group' => 'acad_course_options_group',
				'option_name' => 'total_teaching_hours'
			),
			array(
				'option_group' => 'acad_curriculum_options_group',
				'option_name' => 'action'
			),
			array(
				'option_group' => 'acad_curriculum_options_group',
				'option_name' => 'curriculum_code'
			),
			array(
				'option_group' => 'acad_curriculum_options_group',
				'option_name' => 'total_credits'
			),
			array (
				'option_group' => 'acad_course_curriculum_mapping_options_group',
				'option_name' => 'action'
			),
			array (
				'option_group' => 'acad_course_curriculum_mapping_options_group',
				'option_name' => 'course'
			),
			array (
				'option_group' => 'acad_course_curriculum_mapping_options_group',
				'option_name' => 'curriculum'
			),
			array (
				'option_group' => 'acad_course_curriculum_mapping_options_group',
				'option_name' => 'semester_number'
			),
			array (
				'option_group' => 'acad_program_options_group',
				'option_name' => 'action'
			),
			array (
				'option_group' => 'acad_program_options_group',
				'option_name' => 'department_id'
			),
			array (
				'option_group' => 'acad_program_options_group',
				'option_name' => 'curriculum_id'
			),
			array (
				'option_group' => 'acad_program_options_group',
				'option_name' => 'branch_name'
			),
			array (
				'option_group' => 'acad_program_options_group',
				'option_name' => 'degree_name'
			),
			array (
				'option_group' => 'acad_program_options_group',
				'option_name' => 'admission_year'
			),
			array (
				'option_group' => 'acad_program_options_group',
				'option_name' => 'program_code'
			),
			array (
				'option_group' => 'acad_program_options_group',
				'option_name' => 'program_abbreviation'
			),
			array (
				'option_group' => 'acad_program_options_group',
				'option_name' => 'launch_year'
			),
			array (
				'option_group' => 'acad_semester_options_group',
				'option_name' => 'action'
			),
			array (
				'option_group' => 'acad_semester_options_group',
				'option_name' => 'program'
			),
			array (
				'option_group' => 'acad_semester_options_group',
				'option_name' => 'max_credits'
			),
			array (
				'option_group' => 'acad_semester_options_group',
				'option_name' => 'min_credits'
			),
			array (
				'option_group' => 'acad_semester_options_group',
				'option_name' => 'duration'
			),
			array (
				'option_group' => 'acad_semester_options_group',
				'option_name' => 'semester_type'
			),
			array (
				'option_group' => 'acad_semester_options_group',
				'option_name' => 'semester_number'
			),
			array (
				'option_group' => 'acad_semester_options_group',
				'option_name' => 'is_current'
			),
			array (
				'option_group' => 'acad_faculty_registration_mapping_options_group',
				'option_name' => 'action'
			),
			array (
				'option_group' => 'acad_faculty_registration_mapping_options_group',
				'option_name' => 'department'
			),
			array (
				'option_group' => 'acad_faculty_registration_mapping_options_group',
				'option_name' => 'program'
			),
			array (
				'option_group' => 'acad_faculty_registration_mapping_options_group',
				'option_name' => 'semester'
			),
			array (
				'option_group' => 'acad_faculty_registration_mapping_options_group',
				'option_name' => 'faculty'
			),
			array(
			  'option_group' => 'acad_student_feedback_options_group',
			  'option_name' => 'action'
			),
			array(
			  'option_group' => 'acad_student_feedback_options_group',
			  'option_name' => 'enrollment_id'
			),
			array(
			  'option_group' => 'acad_student_feedback_options_group',
			  'option_name' => 'feedback_category1_marks'
			),
			array(
			  'option_group' => 'acad_student_feedback_options_group',
			  'option_name' => 'category2_marks'
			),
			array(
			  'option_group' => 'acad_student_feedback_options_group',
			  'option_name' => 'category3_marks'
			),
			array(
			  'option_group' => 'acad_student_feedback_options_group',
			  'option_name' => 'category4_marks'
			),
			array(
			  'option_group' => 'acad_student_feedback_options_group',
			  'option_name' => 'category5_marks'
			),
			array(
			  'option_group' => 'acad_student_feedback_options_group',
			  'option_name' => 'category6_marks'
			),
			array(
			  'option_group' => 'acad_student_feedback_options_group',
			  'option_name' => 'category7_marks'
			),
			array(
			  'option_group' => 'acad_student_feedback_options_group',
			  'option_name' => 'category8_marks'
			),
			array(
			  'option_group' => 'acad_student_feedback_options_group',
			  'option_name' => 'category9_marks'
			),
			array(
			  'option_group' => 'acad_student_feedback_options_group',
			  'option_name' => 'category10_marks'
			),
			array(
			  'option_group' => 'acad_student_feedback_options_group',
			  'option_name' => 'remarks'
			),
			array(
			  'option_group' => 'acad_faculty_course_mapping_options_group',
			  'option_name' => 'action'
			),
			array(
			  'option_group' => 'acad_faculty_course_mapping_options_group',
			  'option_name' => 'semester_id'
			),
			array(
			  'option_group' => 'acad_faculty_course_mapping_options_group',
			  'option_name' => 'course_id'
			),
			array(
			  'option_group' => 'acad_faculty_course_mapping_options_group',
			  'option_name' => 'faculty_id'
			),
			array(
	      'option_group' => 'acad_faculty_options_group',
	      'option_name' => 'action'
	    ),
	    array(
	      'option_group' => 'acad_faculty_options_group',
	      'option_name' => 'department_id'
	    ),
	    array(
	      'option_group' => 'acad_faculty_options_group',
	      'option_name' => 'faculty_name'
	    ),
	    array(
	      'option_group' => 'acad_faculty_options_group',
	      'option_name' => 'year_of_joining'
	    ),
	    array(
	      'option_group' => 'acad_faculty_options_group',
	      'option_name' => 'date_of_birth'
	    ),
	    array(
	      'option_group' => 'acad_faculty_options_group',
	      'option_name' => 'permanent_address_line1'
	    ),
	    array(
	      'option_group' => 'acad_faculty_options_group',
	      'option_name' => 'permanent_address_country'
	    ),
	    array(
	      'option_group' => 'acad_faculty_options_group',
	      'option_name' => 'permanent_address_state'
	    ),
	    array(
	      'option_group' => 'acad_faculty_options_group',
	      'option_name' => 'permanent_address_district'
	    ),
	    array(
	      'option_group' => 'acad_faculty_options_group',
	      'option_name' => 'permanent_address_village'
	    ),
	    array(
	      'option_group' => 'acad_faculty_options_group',
	      'option_name' => 'permanent_address_taluka'
	    ),
	    array(
	      'option_group' => 'acad_faculty_options_group',
	      'option_name' => 'permanent_address_pincode'
	    ),
	    array(
	      'option_group' => 'acad_faculty_options_group',
	      'option_name' => 'temporary_address_line1'
	    ),
	    array(
	      'option_group' => 'acad_faculty_options_group',
	      'option_name' => 'temporary_address_country'
	    ),
	    array(
	      'option_group' => 'acad_faculty_options_group',
	      'option_name' => 'temporary_address_state'
	    ),
	    array(
	      'option_group' => 'acad_faculty_options_group',
	      'option_name' => 'temporary_address_district'
	    ),
	    array(
	      'option_group' => 'acad_faculty_options_group',
	      'option_name' => 'temporary_address_village'
	    ),
	    array(
	      'option_group' => 'acad_faculty_options_group',
	      'option_name' => 'temporary_address_taluka'
	    ),
	    array(
	      'option_group' => 'acad_faculty_options_group',
	      'option_name' => 'temporary_address_pincode'
	    ),
	    array(
	      'option_group' => 'acad_faculty_options_group',
	      'option_name' => 'college_email'
	    ),
	    array(
	      'option_group' => 'acad_faculty_options_group',
	      'option_name' => 'personal_email'
	    ),
	    array(
	      'option_group' => 'acad_faculty_options_group',
	      'option_name' => 'contact_no'
	    ),
	    array(
	      'option_group' => 'acad_faculty_options_group',
	      'option_name' => 'emergency_contact_no'
	    ),
	    array(
	      'option_group' => 'acad_faculty_options_group',
	      'option_name' => 'relieving_date'
	    ),
	    array(
	      'option_group' => 'acad_faculty_options_group',
	      'option_name' => 'unique_no'
	    ),array(
	      'option_group' => 'acad_faculty_options_group',
	      'option_name' => 'gender'
	    ),
	    array(
	      'option_group' => 'acad_faculty_options_group',
	      'option_name' => 'blood_group'
	    ),
	    array(
	      'option_group' => 'acad_faculty_options_group',
	      'option_name' => 'caste'
	    ),
	    array(
	      'option_group' => 'acad_faculty_options_group',
	      'option_name' => 'religion'
	    ),array(
	      'option_group' => 'acad_faculty_options_group',
	      'option_name' => 'caste_category'
	    ),
	    array(
	      'option_group' => 'acad_faculty_options_group',
	      'option_name' => 'is_handicap'
	    ),
	    array(
	      'option_group' => 'acad_faculty_options_group',
	      'option_name' => 'bank_account_no'
	    ),
	    array(
	      'option_group' => 'acad_faculty_options_group',
	      'option_name' => 'aadhaar_id'
	    ),
	    array(
	      'option_group' => 'acad_faculty_options_group',
	      'option_name' => 'photo'
	    ),
	    array(
	      'option_group' => 'acad_faculty_options_group',
	      'option_name' => 'bank_name'
	    ),
	    array(
	      'option_group' => 'acad_faculty_options_group',
	      'option_name' => 'bank_branch'
	    ),
	    array(
	      'option_group' => 'acad_faculty_options_group',
	      'option_name' => 'bank_branch_code'
	    ),
	 /* This is for Faculty qualification*/
			array(
			  'option_group' => 'acad_faculty_qualification_options_group',
			  'option_name' => 'action'
			),
			array(
			  'option_group' => 'acad_faculty_qualification_options_group',
			  'option_name' => 'faculty_id'
			),
			array(
			  'option_group' => 'acad_faculty_qualification_options_group',
			  'option_name' => 'qualification_name'
			),
			array(
			  'option_group' => 'acad_faculty_qualification_options_group',
			  'option_name' => 'college_name'
			),
			array(
			  'option_group' => 'acad_faculty_qualification_options_group',
			  'option_name' => 'qualification_level'
			),
			array(
			  'option_group' => 'acad_faculty_qualification_options_group',
			  'option_name' => 'year_of_passing'
			),
			/* This is for Faculty experience */
			array(
			  'option_group' => 'acad_faculty_experience_options_group',
			  'option_name' => 'action'
			),
			array(
			  'option_group' => 'acad_faculty_experience_options_group',
			  'option_name' => 'faculty_id'
			),
			array(
			  'option_group' => 'acad_faculty_experience_options_group',
			  'option_name' => 'employer_name'
			),
			array(
			  'option_group' => 'acad_faculty_experience_options_group',
			  'option_name' => 'designation'
			),
			array(
			  'option_group' => 'acad_faculty_experience_options_group',
			  'option_name' => 'from_date'
			),
			array(
			  'option_group' => 'acad_faculty_experience_options_group',
			  'option_name' => 'to_date'
			),
	/*This is for Faculty Request Types*/
			array(
				'option_group' => 'acad_faculty_request_types_options_group',
				'option_name' => 'action'
			),
			array(
				'option_group' => 'acad_faculty_request_types_options_group',
				'option_name' => 'faculty_request_type_name'
			),
			/*This is for feedback_category*/
			array(
				'option_group' => 'acad_feedback_category_options_group',
				'option_name' => 'action'
			),
			array(
				'option_group' => 'acad_feedback_category_options_group',
				'option_name' => 'feedback_category_name'
			),
			/* This is for Student */
			array(
				'option_group' => 'acad_student_options_group',
				'option_name' => 'action'
			),

			array(
				'option_group' => 'acad_student_options_group',
				'option_name' => 'program_id'
			),
			array(
				'option_group' => 'acad_student_options_group',
				'option_name' => 'first_name'
			),
			array(
				'option_group' => 'acad_student_options_group',
				'option_name' => 'middle_name'
			),
			array(
				'option_group' => 'acad_student_options_group',
				'option_name' => 'last_name'
			),
			array(
				'option_group' => 'acad_student_options_group',
				'option_name' => 'mother_name'
			),
			array(
				'option_group' => 'acad_student_options_group',
				'option_name' => 'gender'
			),
			array(
				'option_group' => 'acad_student_options_group',
				'option_name' => 'dob'
			),
			array(
				'option_group' => 'acad_student_options_group',
				'option_name' => 'blood_group'
			),
			array(
				'option_group' => 'acad_student_options_group',
				'option_name' => 'temp_addr_line_1'
			),
			array(
				'option_group' => 'acad_student_options_group',
				'option_name' => 'temp_addr_taluka'
			),
			array(
				'option_group' => 'acad_student_options_group',
				'option_name' => 'temp_addr_district'
			),
			array(
				'option_group' => 'acad_student_options_group',
				'option_name' => 'temp_addr_country'
			),
			array(
				'option_group' => 'acad_student_options_group',
				'option_name' => 'temp_addr_state'
			),
			array(
				'option_group' => 'acad_student_options_group',
				'option_name' => 'temp_addr_postal_code'
			),
			array(
				'option_group' => 'acad_student_options_group',
				'option_name' => 'perm_addr_line_1'
			),
			array(
				'option_group' => 'acad_student_options_group',
				'option_name' => 'perm_addr_taluka'
			),
			array(
				'option_group' => 'acad_student_options_group',
				'option_name' => 'perm_addr_district'
			),
			array(
				'option_group' => 'acad_student_options_group',
				'option_name' => 'perm_addr_country'
			),
			array(
				'option_group' => 'acad_student_options_group',
				'option_name' => 'perm_addr_state'
			),
			array(
				'option_group' => 'acad_student_options_group',
				'option_name' => 'perm_addr_pincode'
			),
			array(
				'option_group' => 'acad_student_options_group',
				'option_name' => 'perm_addr_contact_no'
			),
			array(
				'option_group' => 'acad_student_options_group',
				'option_name' => 'personal_contact_no'
			),
			array(
				'option_group' => 'acad_student_options_group',
				'option_name' => 'emergency_contact_no'
			),
			array(
				'option_group' => 'acad_student_options_group',
				'option_name' => 'college_email'
			),array(
				'option_group' => 'acad_student_options_group',
				'option_name' => 'personal_email'
			),
			array(
				'option_group' => 'acad_student_options_group',
				'option_name' => 'caste'
			),
			array(
				'option_group' => 'acad_student_options_group',
				'option_name' => 'religion'
			),
			array(
				'option_group' => 'acad_student_options_group',
				'option_name' => 'caste_category'
			),array(
				'option_group' => 'acad_student_options_group',
				'option_name' => 'is_handicapped'
			),
			array(
				'option_group' => 'acad_student_options_group',
				'option_name' => 'is_current'
			),
			array(
				'option_group' => 'acad_student_options_group',
				'option_name' => 'aadhar_id'
			),
			array(
				'option_group' => 'acad_student_options_group',
				'option_name' => 'photo'
			),
			array(
				'option_group' => 'acad_student_options_group',
				'option_name' => 'bank_account_number'
			),
			array(
				'option_group' => 'acad_student_options_group',
				'option_name' => 'bank_name'
			),
			array(
				'option_group' => 'acad_student_options_group',
				'option_name' => 'bank_branch_name'
			),
			array(
				'option_group' => 'acad_student_options_group',
				'option_name' => 'bank_branch_code'
			),
			/* This is for Student Admission*/
			array(
				'option_group' => 'acad_student_admission_options_group',
				'option_name' => 'action'
			),
			array(
				'option_group' => 'acad_student_admission_options_group',
				'option_name' => 'student_enrollment_number'
			),
			array(
				'option_group' => 'acad_student_admission_options_group',
				'option_name' => 'admission_date'
			),
			array(
				'option_group' => 'acad_student_admission_options_group',
				'option_name' => 'admission_year'
			),
			array(
				'option_group' => 'acad_student_admission_options_group',
				'option_name' => 'admission_type'
			),
			array(
				'option_group' => 'acad_student_admission_options_group',
				'option_name' => 'merit_marks1'
			),
			array(
				'option_group' => 'acad_student_admission_options_group',
				'option_name' => 'merit_marks2'
			),
			array(
				'option_group' => 'acad_student_admission_options_group',
				'option_name' => 'merit_rank'
			),
			array(
				'option_group' => 'acad_student_admission_options_group',
				'option_name' => 'admission_category'
			),
			/* This is for Student requests*/
			array(
			  'option_group' => 'acad_faculty_registration_mapping_options_group',
			  'option_name' => 'action'
			),
			array(
			  'option_group' => 'acad_faculty_registration_mapping_options_group',
			  'option_name' => 'faculty_id'
			),
			array(
			  'option_group' => 'acad_faculty_registration_mapping_options_group',
			  'option_name' => 'semester_id'
			),
			array(
			  'option_group' => 'acad_faculty_registration_mapping_options_group',
			  'option_name' => 'program_id'
			),
			array(
			  'option_group' => 'acad_faculty_registration_mapping_options_group',
			  'option_name' => 'department_id'
			),
			array(
			  'option_group' => 'acad_faculty_registration_mapping_options_group',
			  'option_name' => 'student_enrollment_number'
			),
			array(
				'option_group' => 'acad_student_request_types_options_group',
				'option_name' => 'action'
			),
			array(
				'option_group' => 'acad_student_request_types_options_group',
				'option_name' => 'student_request_type_name'
			),
			/*This is for ExamType*/
			array(
				'option_group' => 'acad_exam_type_options_group',
				'option_name' => 'action'
			),
			array(
				'option_group' => 'acad_exam_type_options_group',
				'option_name' => 'exam_name'
			),
			array(
				'option_group' => 'acad_exam_type_options_group',
				'option_name' => 'max_mark'
			),
			/*This is for Exam*/
			array(
				'option_group' => 'acad_exam_options_group',
				'option_name' => 'action'
			),
			array(
			  'option_group' => 'acad_exam_options_group',
			  'option_name' => 'faculty_id'
			),
			array(
			  'option_group' => 'acad_exam_options_group',
			  'option_name' => 'course_id'
			),
			array(
			  'option_group' => 'acad_exam_options_group',
			  'option_name' => 'exam_type_id'
			),
			array(
			  'option_group' => 'acad_exam_options_group',
			  'option_name' => 'evaluation_type'
			),
			array(
			  'option_group' => 'acad_exam_options_group',
			  'option_name' => 'date_of_exam'
			),
			array(
			  'option_group' => 'acad_exam_options_group',
			  'option_name' => 'duration'
			),
			array(
			  'option_group' => 'acad_exam_options_group',
			  'option_name' => 'time_of_exam'
			),
			array(
			  'option_group' => 'acad_exam_options_group',
			  'option_name' => 'place'
			)
		);

		$this->settings->setSettings( $args );
	}

	public function setSections()
	{
		$args = array(
			array(
				'id' => 'acad_department_section',
				'title' => 'Department',
				'callback' => array( $this->dept_callbacks, 'acadDepartmentSection' ),
				'page' => 'acad_department'
			),
			array(
				'id' => 'acad_course_types_section',
				'title' => 'Course Types',
				'callback' => array( $this->course_types_callbacks, 'acadCourseTypesSection' ),
				'page' => 'acad_course_types'
			),
			array(
				'id' => 'acad_course_section',
				'title' => 'Course',
				'callback' => array( $this->course_callbacks, 'acadCourseSection' ),
				'page' => 'acad_course'
			),
			array(
				'id' => 'acad_curriculum_section',
				'title' => 'Curriculum',
				'callback' => array( $this->course_callbacks, 'acadCurriculumSection' ),
				'page' => 'acad_curriculum'
			),
			array(
				'id' => 'acad_course_curriculum_mapping_section',
				'title' => 'Course Curriculum Mapping',
				'callback' => array( $this->ccm_callbacks, 'acadCourseCurriculumSection' ),
				'page' => 'acad_course_curriculum_mapping'
			),
			array(
				'id' => 'acad_program_section',
				'title' => 'Program',
				'callback' => array( $this->prog_callbacks, 'acadProgramSection' ),
				'page' => 'acad_program'
			),
			array(
				'id' => 'acad_semester_section',
				'title' => 'Semester',
				'callback' => array( $this->sem_callbacks, 'acadSemesterSection' ),
				'page' => 'acad_semester'
			),
			array(
				'id' => 'acad_faculty_registration_mapping_section',
				'title' => 'Faculty Registration Mapping',
				'callback' => array( $this->faculty_reg_map_callbacks, 'acadFacultyRegistrationMappingSection' ),
				'page' => 'acad_faculty_registration_mapping'
			),
			array(
				'id' => 'acad_faculty_course_mapping_section',
				'title' => 'Faculty Course Mapping',
				'callback' => array( $this->faculty_course_mapping_callbacks, 'acadFacultyCourseMappingSection' ),
				'page' => 'acad_faculty_course_mapping'
			),
			array(
				'id' => 'acad_faculty_section',
				'title' => 'Faculty',
				'callback' => array( $this->faculty_callbacks, 'acadFacultySection' ),
				'page' => 'acad_faculty'
			),
			array(
				'id' => 'acad_faculty_qualification_section',
				'title' => 'Faculty Qualification',
				'callback' => array( $this->faculty_qual_callbacks, 'acadFacultyQualificationSection' ),
				'page' => 'acad_faculty_qualification'
			),
			array(
					'id' => 'acad_faculty_experience_section',
					'title' => 'Faculty Experience',
					'callback' => array( $this->faculty_exp_callbacks, 'acadFacultyExperienceSection' ),
					'page' => 'acad_faculty_experience'
			),
			array(
				'id' => 'acad_faculty_request_types_section',
				'title' => 'Faculty Request Types',
				'callback' => array( $this->faculty_req_typ_callbacks, 	'acadFacultyRequestTypesSection' ),
				'page' => 'acad_faculty_request_types'
		  ),
			array(
				'id' => 'acad_student_section',
				'title' => 'Student',
				'callback' => array( $this->student_callbacks, 'acadStudentSection' ),
				'page' => 'acad_student'
			),
			array(
				'id' => 'acad_student_admission_section',
				'title' => 'Student',
				'callback' => array( $this->student_admission_callbacks, 'acadStudentAdmissionSection' ),
				'page' => 'acad_student_admission'
			),
			array(
				'id' => 'acad_student_request_types_section',
				'title' => 'Student Request Types',
				'callback' => array( $this->student_req_typ_callbacks, 'acadStudentRequestTypesSection' ),
				'page' => 'acad_student_request_types'
			),
			array(
				'id' => 'acad_exam_type_section',
				'title' => 'Exam Type',
				'callback' => array( $this->exam_type_callbacks, 'acadExamTypeSection' ),
				'page' => 'acad_exam_type'
			),
			array(
				'id' => 'acad_exam_section',
				'title' => 'Exam Type',
				'callback' => array( $this->exam_callbacks, 'acadExamSection' ),
				'page' => 'acad_exam'
			),
			array(
				'id' => 'acad_feedback_category_section',
				'title' => 'Feedback Category',
				'callback' => array( $this->feedback_cat_callbacks, 'acadFeedbackCategorySection' ),
				'page' => 'acad_feedback_category'
			)
		);

		$this->settings->setSections( $args );
	}

	public function setFields()
	{
		$args = array(
			array(
				'id' => 'action',
				'title' => '',
				'callback' => array( $this->dept_callbacks, 'displayDepartmentAction' ),
				'page' => 'acad_department',
				'section' => 'acad_department_section',
				'args' => array(
					'label_for' =>  'action'
				)
			),
			array(
				'id' => 'department_abbreviation',
				'title' => 'Department Abbreviation',
				'callback' => array( $this->dept_callbacks, 'displayDepartmentAbbreviation' ),
				'page' => 'acad_department',
				'section' => 'acad_department_section',
				'args' => array(
					'label_for' =>  'department_abbreviation'
				)
			),
			array(
				'id' => 'department_name',
				'title' => 'Department Name',
				'callback' => array( $this->dept_callbacks, 'displayDepartmentName' ),
				'page' => 'acad_department',
				'section' => 'acad_department_section',
				'args' => array(
					'label_for' => 'department_name'
				)
			),
			array(
				'id' => 'department_code',
				'title' => 'Department Code',
				'callback' => array( $this->dept_callbacks, 'displayDepartmentCode' ),
				'page' => 'acad_department',
				'section' => 'acad_department_section',
				'args' => array(
					'label_for' => 'department_code'
				)
			),
			array(
				'id' => 'establishment_year',
				'title' => 'Establishment Year',
				'callback' => array( $this->dept_callbacks, 'displayEstablishmentYear' ),
				'page' => 'acad_department',
				'section' => 'acad_department_section',
				'args' => array(
					'label_for' => 'establishment_year'
				)
			),
			array(
				'id' => 'fax_no',
				'title' => 'Fax No',
				'callback' => array( $this->dept_callbacks, 'displayFaxNo' ),
				'page' => 'acad_department',
				'section' => 'acad_department_section',
				'args' => array(
					'label_for' => 'fax_no'
				)
			),
			array(
				'id' => 'phone_no',
				'title' => 'Phone No',
				'callback' => array( $this->dept_callbacks, 'displayPhoneNo' ),
				'page' => 'acad_department',
				'section' => 'acad_department_section',
				'args' => array(
					'label_for' => 'phone_no'
				)
			),
			array(
				'id' => 'email',
				'title' => 'Email',
				'callback' => array( $this->dept_callbacks, 'displayEmail' ),
				'page' => 'acad_department',
				'section' => 'acad_department_section',
				'args' => array(
					'label_for' => 'email'
				)
			),
			array(
				'id' => 'action',
				'title' => '',
				'callback' => array( $this->course_types_callbacks, 'displayCourseTypesAction' ),
				'page' => 'acad_course_types',
				'section' => 'acad_course_types_section',
				'args' => array(
					'label_for' => 'action'
				)
			),
			array(
				'id' => 'course_type_name',
				'title' => 'Course Type',
				'callback' => array( $this->course_types_callbacks, 'displayCourseTypesName' ),
				'page' => 'acad_course_types',
				'section' => 'acad_course_types_section',
				'args' => array(
					'label_for' => 'course_type_name'
				)
			),
			array(
				'id' => 'action',
				'title' => '',
				'callback' => array( $this->course_callbacks, 'displayCourseAction' ),
				'page' => 'acad_course',
				'section' => 'acad_course_section',
				'args' => array(
					'label_for' => 'action'
				)
			),
			array(
				'id' => 'department_id',
				'title' => 'Course Department',
				'callback' => array( $this->course_callbacks, 'displayCourseDepartment' ),
				'page' => 'acad_course',
				'section' => 'acad_course_section',
				'args' => array(
					'label_for' => 'department_id'
				)
			),
			array(
				'id' => 'course_name',
				'title' => 'Course Name',
				'callback' => array( $this->course_callbacks, 'displayCourseName' ),
				'page' => 'acad_course',
				'section' => 'acad_course_section',
				'args' => array(
					'label_for' => 'course_name'
				)
			),
			array(
				'id' => 'course_type',
				'title' => 'Course Type',
				'callback' => array( $this->course_callbacks, 'displayCourseType' ),
				'page' => 'acad_course',
				'section' => 'acad_course_section',
				'args' => array(
					'label_for' => 'course_type'
				)
			),
			array(
				'id' => 'course_abbreviation',
				'title' => 'Course Abbreviation',
				'callback' => array( $this->course_callbacks, 'displayCourseAbbreviation' ),
				'page' => 'acad_course',
				'section' => 'acad_course_section',
				'args' => array(
					'label_for' => 'course_abbreviation'
				)
			),
			array(
				'id' => 'course_code',
				'title' => 'Course Code',
				'callback' => array( $this->course_callbacks, 'displayCourseCode' ),
				'page' => 'acad_course',
				'section' => 'acad_course_section',
				'args' => array(
					'label_for' => 'course_code'
				)
			),
			array(
				'id' => 'syllabus_code',
				'title' => 'Syllabus Code',
				'callback' => array( $this->course_callbacks, 'displaySyllabusCode' ),
				'page' => 'acad_course',
				'section' => 'acad_course_section',
				'args' => array(
					'label_for' => 'syllabus_code'
				)
			),
			array(
				'id' => 'is_theory',
				'title' => 'Theory',
				'callback' => array( $this->course_callbacks, 'displayCourseTheory' ),
				'page' => 'acad_course',
				'section' => 'acad_course_section',
				'args' => array(
					'label_for' => 'is_theory'
				)
			),
			array(
				'id' => 'course_credits',
				'title' => 'Course Credits',
				'callback' => array( $this->course_callbacks, 'displayCourseCredits' ),
				'page' => 'acad_course',
				'section' => 'acad_course_section',
				'args' => array(
					'label_for' => 'course_credits'
				)
			),
			array(
				'id' => 'total_teaching_hours',
				'title' => 'Total Teaching Hours',
				'callback' => array( $this->course_callbacks, 'displayTotalTeachingHours' ),
				'page' => 'acad_course',
				'section' => 'acad_course_section',
				'args' => array(
					'label_for' => 'total_teaching_hours'
				)
			),
			array(
				'id' => 'action',
				'title' => '',
				'callback' => array( $this->curriculum_callbacks, 'displayCurriculumAction' ),
				'page' => 'acad_curriculum',
				'section' => 'acad_curriculum_section',
				'args' => array(
					'label_for' => 'action'
				)
			),
			array(
				'id' => 'curriculum_code',
				'title' => 'Curriculum Code',
				'callback' => array( $this->curriculum_callbacks, 'displayCurriculumCode' ),
				'page' => 'acad_curriculum',
				'section' => 'acad_curriculum_section',
				'args' => array(
					'label_for' => 'curriculum_code'
				)
			),
			array(
				'id' => 'total_credits',
				'title' => 'Total Credits',
				'callback' => array( $this->curriculum_callbacks, 'displayTotalCredits' ),
				'page' => 'acad_curriculum',
				'section' => 'acad_curriculum_section',
				'args' => array(
					'label_for' => 'total_credits'
				)
			),
			array(
				'id' => 'action',
				'title' => '',
				'callback' => array( $this->ccm_callbacks, 'displayCcmAction' ),
				'page' => 'acad_course_curriculum_mapping',
				'section' => 'acad_course_curriculum_mapping_section',
				'args' => array(
					'label_for' => 'action'
				)
			),
			array(
				'id' => 'course',
				'title' => 'Course',
				'callback' => array( $this->ccm_callbacks, 'displayCcmCourse' ),
				'page' => 'acad_course_curriculum_mapping',
				'section' => 'acad_course_curriculum_mapping_section',
				'args' => array(
					'label_for' => 'course'
				)
			),
			array(
				'id' => 'curriculum',
				'title' => 'Curricullum',
				'callback' => array( $this->ccm_callbacks, 'displayCcmCurriculum' ),
				'page' => 'acad_course_curriculum_mapping',
				'section' => 'acad_course_curriculum_mapping_section',
				'args' => array(
					'label_for' => 'curriculum'
				)
			),
			array(
				'id' => 'semester_number',
				'title' => 'Semester Number',
				'callback' => array( $this->ccm_callbacks, 'displayCcmSemesterNumber' ),
				'page' => 'acad_course_curriculum_mapping',
				'section' => 'acad_course_curriculum_mapping_section',
				'args' => array(
					'label_for' => 'semester_number'
				)
			),
			array(
				'id' => 'action',
				'title' => '',
				'callback' => array( $this->prog_callbacks, 'displayAction' ),
				'page' => 'acad_program',
				'section' => 'acad_program_section',
				'args' => array(
					'label_for' => 'action'
				)
			),
			array(
				'id' => 'department_id',
				'title' => 'Department',
				'callback' => array( $this->prog_callbacks, 'displayDepartment' ),
				'page' => 'acad_program',
				'section' => 'acad_program_section',
				'args' => array(
					'label_for' => 'department_id'
				)
			),
			array(
				'id' => 'curriculum_id',
				'title' => 'Curriculum',
				'callback' => array( $this->prog_callbacks, 'displayCurriculum' ),
				'page' => 'acad_program',
				'section' => 'acad_program_section',
				'args' => array(
					'label_for' => 'curriculum_id'
				)
			),
			array(
				'id' => 'branch_name',
				'title' => 'Branch Name',
				'callback' => array( $this->prog_callbacks, 'displayBranchName' ),
				'page' => 'acad_program',
				'section' => 'acad_program_section',
				'args' => array(
					'label_for' => 'branch_name'
				)
			),
			array(
				'id' => 'degree_name',
				'title' => 'Degree Name',
				'callback' => array( $this->prog_callbacks, 'displayDegreeName' ),
				'page' => 'acad_program',
				'section' => 'acad_program_section',
				'args' => array(
					'label_for' => 'degree_name'
				)
			),
			array(
				'id' => 'admission_year',
				'title' => 'Admission Year',
				'callback' => array( $this->prog_callbacks, 'displayAdmissionYear' ),
				'page' => 'acad_program',
				'section' => 'acad_program_section',
				'args' => array(
					'label_for' => 'admission_year'
				)
			),
			array(
				'id' => 'program_code',
				'title' => 'Program Code',
				'callback' => array( $this->prog_callbacks, 'displayProgramCode' ),
				'page' => 'acad_program',
				'section' => 'acad_program_section',
				'args' => array(
					'label_for' => 'program_code'
				)
			),
			array(
				'id' => 'program_abbreviation',
				'title' => 'Program Abbreviation',
				'callback' => array( $this->prog_callbacks, 'displayProgramAbbreviation' ),
				'page' => 'acad_program',
				'section' => 'acad_program_section',
				'args' => array(
					'label_for' => 'program_abbreviation'
				)
			),
			array(
				'id' => 'launch_year',
				'title' => 'Launch Year',
				'callback' => array( $this->prog_callbacks, 'displayLaunchYear' ),
				'page' => 'acad_program',
				'section' => 'acad_program_section',
				'args' => array(
					'label_for' => 'launch_year'
				)
			),
			array(
				'id' => 'action',
				'title' => '',
				'callback' => array( $this->sem_callbacks, 'displayAction' ),
				'page' => 'acad_semester',
				'section' => 'acad_semester_section',
				'args' => array(
					'label_for' => 'action'
				)
			),
			array(
				'id' => 'program',
				'title' => 'Program',
				'callback' => array( $this->sem_callbacks, 'displayProgram' ),
				'page' => 'acad_semester',
				'section' => 'acad_semester_section',
				'args' => array(
					'label_for' => 'program'
				)
			),
			array(
				'id' => 'max_credits',
				'title' => 'Maximum Credits',
				'callback' => array( $this->sem_callbacks, 'displayMaxCredits' ),
				'page' => 'acad_semester',
				'section' => 'acad_semester_section',
				'args' => array(
					'label_for' => 'max_credits'
				)
			),
			array(
				'id' => 'min_credits',
				'title' => 'Minimum Credits',
				'callback' => array( $this->sem_callbacks, 'displayMinCredits' ),
				'page' => 'acad_semester',
				'section' => 'acad_semester_section',
				'args' => array(
					'label_for' => 'min_credits'
				)
			),
			array(
				'id' => 'duration',
				'title' => 'Duration (in months)',
				'callback' => array( $this->sem_callbacks, 'displayDuration' ),
				'page' => 'acad_semester',
				'section' => 'acad_semester_section',
				'args' => array(
					'label_for' => 'duration'
				)
			),
			array(
				'id' => 'semester_type',
				'title' => 'Semester Type',
				'callback' => array( $this->sem_callbacks, 'displaySemesterType' ),
				'page' => 'acad_semester',
				'section' => 'acad_semester_section',
				'args' => array(
					'label_for' => 'semester_type'
				)
			),
			array(
				'id' => 'semester_number',
				'title' => 'Semester Number',
				'callback' => array( $this->sem_callbacks, 'displaySemesterNumber' ),
				'page' => 'acad_semester',
				'section' => 'acad_semester_section',
				'args' => array(
					'label_for' => 'semester_number'
				)
			),
			array(
				'id' => 'is_current',
				'title' => 'Is Current',
				'callback' => array( $this->sem_callbacks, 'displayIsCurrent' ),
				'page' => 'acad_semester',
				'section' => 'acad_semester_section',
				'args' => array(
					'label_for' => 'is_current'
				)
			),
			array(
				'id' => 'action',
				'title' => '',
				'callback' => array( $this->faculty_reg_map_callbacks, 'displayAction' ),
				'page' => 'acad_faculty_registration_mapping',
				'section' => 'acad_faculty_registration_mapping_section',
				'args' => array(
					'label_for' => 'action'
				)
			),
			array(
				'id' => 'department',
				'title' => 'Department',
				'callback' => array( $this->faculty_reg_map_callbacks, 'displayDepartment' ),
				'page' => 'acad_faculty_registration_mapping',
				'section' => 'acad_faculty_registration_mapping_section',
				'args' => array(
					'label_for' => 'department'
				)
			),
			array(
				'id' => 'program',
				'title' => 'Program',
				'callback' => array( $this->faculty_reg_map_callbacks, 'displayProgram' ),
				'page' => 'acad_faculty_registration_mapping',
				'section' => 'acad_faculty_registration_mapping_section',
				'args' => array(
					'label_for' => 'program'
				)
			),
			array(
				'id' => 'semester',
				'title' => 'Semester',
				'callback' => array( $this->faculty_reg_map_callbacks, 'displaySemester' ),
				'page' => 'acad_faculty_registration_mapping',
				'section' => 'acad_faculty_registration_mapping_section',
				'args' => array(
					'label_for' => 'semester'
				)
			),
			array(
				'id' => 'faculty',
				'title' => 'Faculty',
				'callback' => array( $this->faculty_reg_map_callbacks, 'displayFaculty' ),
				'page' => 'acad_faculty_registration_mapping',
				'section' => 'acad_faculty_registration_mapping_section',
				'args' => array(
					'label_for' => 'faculty'
				)
			),
			array(
			  'id' => 'action',
			  'title' => '',
			  'callback' => array( $this->faculty_course_mapping_callbacks, 'displayFacultyCourseMappingAction' ),
			  'page' => 'acad_faculty_course_mapping',
			  'section' => 'acad_faculty_course_mapping_section',
			  'args' => array(
			    'label_for' =>  'action'
			  )
			),
			array(
			  'id' => 'semester_id',
			  'title' => 'Semester ID',
			  'callback' => array( $this->faculty_course_mapping_callbacks, 'displaySemesterID' ),
			  'page' => 'acad_faculty_course_mapping',
			  'section' => 'acad_faculty_course_mapping_section',
			  'args' => array(
			    'label_for' => 'semester_id'
			  )
			),
			array(
			  'id' => 'course_id',
			  'title' => 'Course ID',
			  'callback' => array( $this->faculty_course_mapping_callbacks, 'displayCourseID' ),
			  'page' => 'acad_faculty_course_mapping',
			  'section' => 'acad_faculty_course_mapping_section',
			  'args' => array(
			    'label_for' => 'course_id'
			  )
			),
			array(
			  'id' => 'faculty_id',
			  'title' => 'Faculty ID',
			  'callback' => array( $this->faculty_course_mapping_callbacks, 'displayFacultyID' ),
			  'page' => 'acad_faculty_course_mapping',
			  'section' => 'acad_faculty_course_mapping_section',
			  'args' => array(
			    'label_for' => 'faculty_id'
			  )
			),
			/*For Faculty */
			array(
				'id' => 'action',
				'title' => '',
				'callback' => array( $this->faculty_callbacks, 'displayFacultyAction' ),
				'page' => 'acad_faculty',
				'section' => 'acad_faculty_section',
				'args' => array(
					'label_for' =>  'action'
				)
			),

			array(
				'id' => 'department_id',
				'title' => 'Department ID',
				'callback' => array( $this->faculty_callbacks, 'displayDepartmentID' ),
				'page' => 'acad_faculty',
				'section' => 'acad_faculty_section',
				'args' => array(
					'label_for' =>  'department_id'
				)
			),
			array(
				'id' => 'faculty_name',
				'title' => 'Faculty Name',
				'callback' => array( $this->faculty_callbacks, 'displayFacultyName' ),
				'page' => 'acad_faculty',
				'section' => 'acad_faculty_section',
				'args' => array(
					'label_for' => 'faculty_name'
				)
			),
			array(
				'id' => 'year_of_joining',
				'title' => 'Year of Joining',
				'callback' => array( $this->faculty_callbacks, 'displayYearOfJoining' ),
				'page' => 'acad_faculty',
				'section' => 'acad_faculty_section',
				'args' => array(
					'label_for' => 'year_of_joining'
				)
			),
			array(
				'id' => 'date_of_birth',
				'title' => 'Date Of Birth',
				'callback' => array( $this->faculty_callbacks, 'displayDateOfBirth' ),
				'page' => 'acad_faculty',
				'section' => 'acad_faculty_section',
				'args' => array(
					'label_for' => 'date_of_birth'
				)
			),
			array(
				'id' => 'permanent_address_line1',
				'title' => 'Permanent Address Line1',
				'callback' => array( $this->faculty_callbacks, 'displayPermanentAddressLine1' ),
				'page' => 'acad_faculty',
				'section' => 'acad_faculty_section',
				'args' => array(
					'label_for' => 'permanent_address_line1'
				)
			),
			array(
				'id' => 'permanent_address_country',
				'title' => 'Permanent Address Country',
				'callback' => array( $this->faculty_callbacks, 'displayPermanentAddressCountry' ),
				'page' => 'acad_faculty',
				'section' => 'acad_faculty_section',
				'args' => array(
					'label_for' => 'permanent_address_country'
				)
			),
			array(
				'id' => 'permanent_address_state',
				'title' => 'Permanent Address State',
				'callback' => array( $this->faculty_callbacks, 'displayPermanentAddressState' ),
				'page' => 'acad_faculty',
				'section' => 'acad_faculty_section',
				'args' => array(
					'label_for' => 'permanent_address_state'
				)
			),
			array(
				'id' => 'permanent_address_district',
				'title' => 'Permanent Address District',
				'callback' => array( $this->faculty_callbacks, 'displayPermanentAddressDistrict' ),
				'page' => 'acad_faculty',
				'section' => 'acad_faculty_section',
				'args' => array(
					'label_for' =>  'permanent_address_district'
				)
			),
			array(
				'id' => 'permanent_address_village',
				'title' => 'Permanent Address Village',
				'callback' => array( $this->faculty_callbacks, 'displayPermanentAddressVillage' ),
				'page' => 'acad_faculty',
				'section' => 'acad_faculty_section',
				'args' => array(
					'label_for' => 'permanent_address_village'
				)
			),
			array(
				'id' => 'permanent_address_taluka',
				'title' => 'Permanent Address Taluka',
				'callback' => array( $this->faculty_callbacks, 'displayPermanentAddressTaluka' ),
				'page' => 'acad_faculty',
				'section' => 'acad_faculty_section',
				'args' => array(
					'label_for' => 'permanent_address_village'
				)
			),
			array(
				'id' => 'permanent_address_pincode',
				'title' => 'Permanent Address Pincode',
				'callback' => array( $this->faculty_callbacks, 'displayPermanentAddressPincode' ),
				'page' => 'acad_faculty',
				'section' => 'acad_faculty_section',
				'args' => array(
					'label_for' => 'permanent_address_pincode'
				)
			),
			array(
				'id' => 'temporary_address_line1',
				'title' => 'Temporary Address Line1',
				'callback' => array( $this->faculty_callbacks, 'displayTemporaryAddressLine1' ),
				'page' => 'acad_faculty',
				'section' => 'acad_faculty_section',
				'args' => array(
					'label_for' => 'temporary_address_line1'
				)
			),
			array(
				'id' => 'temporary_address_country',
				'title' => 'Temprary Address Country',
				'callback' => array( $this->faculty_callbacks, 'displayTemporaryAddressCountry' ),
				'page' => 'acad_faculty',
				'section' => 'acad_faculty_section',
				'args' => array(
					'label_for' => 'temporary_address_country'
				)
			),
			array(
				'id' => 'temporary_address_state',
				'title' => 'Temporary Address State',
				'callback' => array( $this->faculty_callbacks, 'displayTemporaryAddressState' ),
				'page' => 'acad_faculty',
				'section' => 'acad_faculty_section',
				'args' => array(
					'label_for' => 'temporary_address_state'
				)
			),
			array(
				'id' => 'temporary_address_district',
				'title' => 'Temporary Address District',
				'callback' => array( $this->faculty_callbacks, 'displayTemporaryAddressDistrict' ),
				'page' => 'acad_faculty',
				'section' => 'acad_faculty_section',
				'args' => array(
					'label_for' => 'temporary_address_district'
				)
			),
			array(
				'id' => 'temporary_address_village',
				'title' => 'Temporary Address Village',
				'callback' => array( $this->faculty_callbacks, 'displayTemporaryAddressVillage' ),
				'page' => 'acad_faculty',
				'section' => 'acad_faculty_section',
				'args' => array(
					'label_for' =>  'temporary_address_village'
				)
			),
			array(
				'id' => 'temporary_address_taluka',
				'title' => 'Temporary Address Taluka',
				'callback' => array( $this->faculty_callbacks, 'displayTemporaryAddressTaluka' ),
				'page' => 'acad_faculty',
				'section' => 'acad_faculty_section',
				'args' => array(
					'label_for' => 'temporary_address_taluka'
				)
			),
			array(
				'id' => 'temporary_address_pincode',
				'title' => 'Temporary Address pincode',
				'callback' => array( $this->faculty_callbacks, 'displayTemporaryAddressPincode' ),
				'page' => 'acad_faculty',
				'section' => 'acad_faculty_section',
				'args' => array(
					'label_for' => 'temporary_address_pincode'
				)
			),
			array(
				'id' => 'college_email',
				'title' => 'College Email',
				'callback' => array( $this->faculty_callbacks, 'displayCollegEmail' ),
				'page' => 'acad_faculty',
				'section' => 'acad_faculty_section',
				'args' => array(
					'label_for' => 'college_email'
				)
			),
			array(
				'id' => 'personal_email',
				'title' => 'Personal Email',
				'callback' => array( $this->faculty_callbacks, 'displayPersonalEmail' ),
				'page' => 'acad_faculty',
				'section' => 'acad_faculty_section',
				'args' => array(
					'label_for' => 'personal_email'
				)
			),
			array(
				'id' => 'contact_no',
				'title' => 'Contact No',
				'callback' => array( $this->faculty_callbacks, 'displayContactNo' ),
				'page' => 'acad_faculty',
				'section' => 'acad_faculty_section',
				'args' => array(
					'label_for' => 'contact_no'
				)
			),
			array(
				'id' => 'emergency_contact_no',
				'title' => 'Emergency Contact',
				'callback' => array( $this->faculty_callbacks, 'displayEmergencyContactNo' ),
				'page' => 'acad_faculty',
				'section' => 'acad_faculty_section',
				'args' => array(
					'label_for' =>  'emergency_contact_no'
				)
			),
			array(
				'id' => 'relieiving_date',
				'title' => 'Relieving DAte',
				'callback' => array( $this->faculty_callbacks, 'displayRelievingDate' ),
				'page' => 'acad_faculty',
				'section' => 'acad_faculty_section',
				'args' => array(
					'label_for' => 'relieving_date'
				)
			),
			array(
				'id' => 'unique_no',
				'title' => 'Unique No',
				'callback' => array( $this->faculty_callbacks, 'displayUniqueNo' ),
				'page' => 'acad_faculty',
				'section' => 'acad_faculty_section',
				'args' => array(
					'label_for' => 'unique_no'
				)
			),
			array(
				'id' => 'gender',
				'title' => 'Gender',
				'callback' => array( $this->faculty_callbacks, 'displayGender' ),
				'page' => 'acad_faculty',
				'section' => 'acad_faculty_section',
				'args' => array(
					'label_for' => 'gender'
				)
			),
			array(
				'id' => 'blood_group',
				'title' => 'Blood Group',
				'callback' => array( $this->faculty_callbacks, 'displayBloodGroup' ),
				'page' => 'acad_faculty',
				'section' => 'acad_faculty_section',
				'args' => array(
					'label_for' => 'blood_group'
				)
			),
			array(
				'id' => 'caste',
				'title' => 'Caste',
				'callback' => array( $this->faculty_callbacks, 'displayCaste' ),
				'page' => 'acad_faculty',
				'section' => 'acad_faculty_section',
				'args' => array(
					'label_for' => 'caste'
				)
			),
			array(
				'id' => 'religion',
				'title' => 'Religion',
				'callback' => array( $this->faculty_callbacks, 'displayReligion' ),
				'page' => 'acad_faculty',
				'section' => 'acad_faculty_section',
				'args' => array(
					'label_for' => 'religion'
				)
			),
			array(
				'id' => 'caste_category',
				'title' => 'Caste Category',
				'callback' => array( $this->faculty_callbacks, 'displayCasteCategory' ),
				'page' => 'acad_faculty',
				'section' => 'acad_faculty_section',
				'args' => array(
					'label_for' => 'caste_category'
				)
			),
			array(
				'id' => 'is_handicap',
				'title' => 'Is Handicap',
				'callback' => array( $this->faculty_callbacks, 'displayIsHandicap' ),
				'page' => 'acad_faculty',
				'section' => 'acad_faculty_section',
				'args' => array(
					'label_for' => 'is_handicap'
				)
			),
			array(
				'id' => 'bank_account_no',
				'title' => 'Bank Account Number',
				'callback' => array( $this->faculty_callbacks, 'displayBankAccountNo' ),
				'page' => 'acad_faculty',
				'section' => 'acad_faculty_section',
				'args' => array(
					'label_for' => 'bank_account_no'
				)
			),
			array(
				'id' => 'aadhaar_id',
				'title' => 'Aadhaar ID',
				'callback' => array( $this->faculty_callbacks, 'displayAadhaarID' ),
				'page' => 'acad_faculty',
				'section' => 'acad_faculty_section',
				'args' => array(
					'label_for' => 'aadhaar_id'
				)
			),
			array(
				'id' => 'photo',
				'title' => 'Photo',
				'callback' => array( $this->faculty_callbacks, 'displayPhoto' ),
				'page' => 'acad_faculty',
				'section' => 'acad_faculty_section',
				'args' => array(
					'label_for' => 'photo'
				)
			),
			array(
				'id' => 'bank_name',
				'title' => 'Bank Name',
				'callback' => array( $this->faculty_callbacks, 'displayBankName' ),
				'page' => 'acad_faculty',
				'section' => 'acad_faculty_section',
				'args' => array(
					'label_for' => 'bank_name'
				)
			),
			array(
				'id' => 'bank_branch',
				'title' => 'Bank Branch Name',
				'callback' => array( $this->faculty_callbacks, 'displayBankBranch' ),
				'page' => 'acad_faculty',
				'section' => 'acad_faculty_section',
				'args' => array(
					'label_for' => 'bank_branch'
				)
			),
			array(
				'id' => 'bank_branch_code',
				'title' => 'Bank branch code',
				'callback' => array( $this->faculty_callbacks, 'displayBankBranchCode' ),
				'page' => 'acad_faculty',
				'section' => 'acad_faculty_section',
				'args' => array(
					'label_for' => 'bank_branch_code'
				)
			),
			/* This is for Faculty Qualification */
			array(
				'id' => 'action',
				'title' => '',
				'callback' => array( $this->faculty_qual_callbacks, 'displayFacultyQualificationAction' ),
				'page' => 'acad_faculty_qualification',
				'section' => 'acad_faculty_qualification_section',
				'args' => array(
					'label_for' =>  'action'
				)
			),
			array(
				'id' => 'faculty_id',
				'title' => 'Faculty ID',
				'callback' => array( $this->faculty_qual_callbacks, 'displayFacultyID' ),
				'page' => 'acad_faculty_qualification',
				'section' => 'acad_faculty_qualification_section',
				'args' => array(
					'label_for' =>  'faculty_id'
				)
			),
			array(
				'id' => 'qualification_name',
				'title' => 'Qualification Name',
				'callback' => array( $this->faculty_qual_callbacks, 'displayQualificationName' ),
				'page' => 'acad_faculty_qualification',
				'section' => 'acad_faculty_qualification_section',
				'args' => array(
					'label_for' => 'qualification_name'  )
			),
			array(
				'id' => 'college_name',
				'title' => 'College Name',
				'callback' => array( $this->faculty_qual_callbacks, 'displayCollegeName' ),
				'page' => 'acad_faculty_qualification',
				'section' => 'acad_faculty_qualification_section',
				'args' => array(
					'label_for' => 'college_name'
				)
			),
			array(
				'id' => 'qualification_level',
				'title' => 'Faculty Qualification Level',
				'callback' => array( $this->faculty_qual_callbacks, 'displayQualificationLevel' ),
				'page' => 'acad_faculty_qualification',
				'section' => 'acad_faculty_qualification_section',
				'args' => array(
					'label_for' => 'qualification_level'
				)
			),
			array(
				'id' => 'year_of_passing',
				'title' => 'Year of PAssing',
				'callback' => array( $this->faculty_qual_callbacks, 'displayYearOfPassing' ),
				'page' => 'acad_faculty_qualification',
				'section' => 'acad_faculty_qualification_section',
				'args' => array(
					'label_for' => 'year_of_passing'
				)
			),
			/* This is for Faculty Experience */
			array(
				'id' => 'action',
				'title' => '',
				'callback' => array( $this->faculty_exp_callbacks, 'displayFacultyExperienceAction' ),
				'page' => 'acad_faculty_experience',
				'section' => 'acad_faculty_experience_section',
				'args' => array(
					'label_for' =>  'action'
				)
			),
			array(
				'id' => 'faculty_id',
				'title' => 'Faculty ID',
				'callback' => array( $this->faculty_exp_callbacks, 'displayFacultyID' ),
				'page' => 'acad_faculty_experience',
				'section' => 'acad_faculty_experience_section',
				'args' => array(
					'label_for' =>  'faculty_id'
				)
			),
			array(
				'id' => 'employer_name',
				'title' => 'Employer Name',
				'callback' => array( $this->faculty_exp_callbacks, 'displayEmployerName' ),
				'page' => 'acad_faculty_experience',
				'section' => 'acad_faculty_experience_section',
				'args' => array(
					'label_for' => 'employer_name'
					)
			),
			array(
				'id' => 'designation',
				'title' => 'Designation',
				'callback' => array( $this->faculty_exp_callbacks, 'displayDesignation' ),
				'page' => 'acad_faculty_experience',
				'section' => 'acad_faculty_experience_section',
				'args' => array(
					'label_for' => 'designation'
				)
			),
			array(
				'id' => 'from_date',
				'title' => 'From date',
				'callback' => array( $this->faculty_exp_callbacks, 'displayFromDate' ),
				'page' => 'acad_faculty_experience',
				'section' => 'acad_faculty_experience_section',
				'args' => array(
					'label_for' => 'from_date'
				)
			),
			array(
				'id' => 'to_date',
				'title' => 'To Date',
				'callback' => array( $this->faculty_exp_callbacks, 'displayToDate' ),
				'page' => 'acad_faculty_experience',
				'section' => 'acad_faculty_experience_section',
				'args' => array(
					'label_for' => 'to_date'
				)
			),
			/* Faculty Reqest */
			array(
				'id' => 'action',
				'title' => '',
				'callback' => array( $this->feedback_cat_callbacks, 'displayFeedbackCategoryAction' ),
				'page' => 'acad_feedback_category',
				'section' => 'acad_feedback_category_section',
				'args' => array(
					'label_for' => 'action'
				)
			),
			array(
				'id' => 'feedback_category_name',
				'title' => 'Feedback Category Name',
				'callback' => array( $this->feedback_cat_callbacks, 'displayFeedbackCategoryName' ),
				'page' => 'acad_feedback_category',
				'section' => 'acad_feedback_category_section',
				'args' => array(
					'label_for' => 'feedback_category_name'
				)
			),
			array(
				'id' => 'action',
				'title' => '',
				'callback' => array( $this->student_callbacks, 'displayStudentAction' ),
				'page' => 'acad_student',
				'section' => 'acad_student_section',
				'args' => array(
					'label_for' =>  'action'
				)
			),

			array(
			  'id' => 'program_id',
			  'title' => 'Program ID',
			  'callback' => array( $this->student_callbacks, 'displayProgramID' ),
			  'page' => 'acad_student',
			  'section' => 'acad_student_section',
			  'args' => array(
					'label_for' => 'program_id'
			  )
			),
			array(
			  'id' => 'firstname',
			  'title' => 'First Name',
			  'callback' => array( $this->student_callbacks, 'displayFirstName' ),
			  'page' => 'acad_student',
			  'section' => 'acad_student_section',
			  'args' => array(
			    'label_for' => 'first_name'
			  )
			),
			array(
			  'id' => 'middle_name',
			  'title' => 'Middle Name',
			  'callback' => array( $this->student_callbacks, 'displayMiddleName' ),
			  'page' => 'acad_student',
			  'section' => 'acad_student_section',
			  'args' => array(
			    'label_for' => 'middle_name'
			  )
			),
			array(
			  'id' => 'last_name',
			  'title' => 'Last Name',
			  'callback' => array( $this->student_callbacks, 'displayLastName' ),
			  'page' => 'acad_student',
			  'section' => 'acad_student_section',
			  'args' => array(
			    'label_for' => 'last_name'
			  )
			),
			array(
			  'id' => 'mother_name',
			  'title' => 'Mother Name',
			  'callback' => array( $this->student_callbacks, 'displayMiddleName' ),
			  'page' => 'acad_student',
			  'section' => 'acad_student_section',
			  'args' => array(
			    'label_for' => 'mother_name'
			  )
			),
			array(
			  'id' => 'gender',
			  'title' => 'Gender',
			  'callback' => array( $this->student_callbacks, 'displayGender' ),
			  'page' => 'acad_student',
			  'section' => 'acad_student_section',
			  'args' => array(
			    'label_for' => 'gender'
			  )
			),
			array(
			  'id' => 'dob',
			  'title' => 'DOB',
			  'callback' => array( $this->student_callbacks, 'displayDOB' ),
			  'page' => 'acad_student',
			  'section' => 'acad_student_section',
			  'args' => array(
			    'label_for' => 'dob'
			  )
			),
			array(
			  'id' => 'blood_group',
			  'title' => 'Blood Group',
			  'callback' => array( $this->student_callbacks, 'displayBloodGroup' ),
			  'page' => 'acad_student',
			  'section' => 'acad_student_section',
			  'args' => array(
			    'label_for' =>  'blood_group'
			  )
			),
			array(
			  'id' => 'temp_addr_line_1',
			  'title' => 'Temp Addr Line1',
			  'callback' => array( $this->student_callbacks, 'displayTempAddrLine1' ),
			  'page' => 'acad_student',
			  'section' => 'acad_student_section',
			  'args' => array(
			    'label_for' => 'temp_addr_line_1'
			  )
			),
			array(
			  'id' => 'temp_addr_taluka',
			  'title' => 'Temp Address Taluka',
			  'callback' => array( $this->student_callbacks, 'displayTempAddrTaluka' ),
			  'page' => 'acad_student',
			  'section' => 'acad_student_section',
			  'args' => array(
			    'label_for' => 'temp_addr_taluka'
			  )
			),
			array(
			  'id' => 'tempaddrdistrict',
			  'title' => 'Tem Addr District',
			  'callback' => array( $this->student_callbacks, 'displayTempAddrDistrict' ),
			  'page' => 'acad_student',
			  'section' => 'acad_student_section',
			  'args' => array(
			    'label_for' => 'temp_addr_district'
			  )
			),
			array(
			  'id' => 'temp_addr_country',
			  'title' => 'Temporary Address Country',
			  'callback' => array( $this->student_callbacks, 'displayTempAddrCountry' ),
			  'page' => 'acad_student',
			  'section' => 'acad_student_section',
			  'args' => array(
			    'label_for' => 'temp_addr_country'
			  )
			),
			array(
			  'id' => 'temp_addr_state',
			  'title' => 'Temporary Address State',
			  'callback' => array( $this->student_callbacks, 'displayTempAddrState' ),
			  'page' => 'acad_student',
			  'section' => 'acad_student_section',
			  'args' => array(
			    'label_for' => 'temp_addr_state'
			  )
			),
			array(
			  'id' => 'temp_addr_postal_code',
			  'title' => 'TempAddrPostalCode',
			  'callback' => array( $this->student_callbacks, 'displayTempAddrPostalCode' ),
			  'page' => 'acad_student',
			  'section' => 'acad_student_section',
			  'args' => array(
			    'label_for' => 'temp_addr_postal_code'
			  )
			),
			array(
			  'id' => 'perm_addr_line_1',
			  'title' => 'Perm addr',
			  'callback' => array( $this->student_callbacks, 'displayPermAddrLine1' ),
			  'page' => 'acad_student',
			  'section' => 'acad_student_section',
			  'args' => array(
			    'label_for' =>  'perm_addr_line_1'
			  )
			),
			array(
			  'id' => 'perm_addr_taluka',
			  'title' => 'Permanent Address Taluka',
			  'callback' => array( $this->student_callbacks, 'displayPermAddrTaluka' ),
			  'page' => 'acad_student',
			  'section' => 'acad_student_section',
			  'args' => array(
			    'label_for' => 'perm_addr_taluka'
			  )
			),
			array(
			  'id' => 'perm_addr_district',
			  'title' => 'Permanent Address District',
			  'callback' => array( $this->student_callbacks, 'displayPermAddrDistrict' ),
			  'page' => 'acad_student',
			  'section' => 'acad_student_section',
			  'args' => array(
			    'label_for' => 'permaddrdistrict'
			  )
			),
			array(
			  'id' => 'perm_addr_country',
			  'title' => 'Fax No',
			  'callback' => array( $this->student_callbacks, 'displayPermAddrCountry' ),
			  'page' => 'acad_student',
			  'section' => 'acad_student_section',
			  'args' => array(
			    'label_for' => 'perm_addr_country'
			  )
			),
			array(
			  'id' => 'perm_addr_pincode',
			  'title' => 'permaddrpincode',
			  'callback' => array( $this->student_callbacks, 'displayPermAddrPincode' ),
			  'page' => 'acad_student',
			  'section' => 'acad_student_section',
			  'args' => array(
			    'label_for' => 'perm_addr_pincode'
			  )
			),
			array(
			  'id' => 'perm_addr_contact_no',
			  'title' => 'Perm Addr Contact No',
			  'callback' => array( $this->student_callbacks, 'displayPermAddrContactNo' ),
			  'page' => 'acad_student',
			  'section' => 'acad_student_section',
			  'args' => array(
			    'label_for' => 'perm_addr_contact_no'
			  )
			),
			array(
			  'id' => 'personal_contact_no',
			  'title' => 'Personal Contact',
			  'callback' => array( $this->student_callbacks, 'displayPersonalContactNo' ),
			  'page' => 'acad_student',
			  'section' => 'acad_student_section',
			  'args' => array(
			    'label_for' =>  'personal_contact_no'
			  )
			),
			array(
			  'id' => 'emergency_contact_no',
			  'title' => 'Emergency Contact No',
			  'callback' => array( $this->student_callbacks, 'displayEmergencyContactNo' ),
			  'page' => 'acad_student',
			  'section' => 'acad_student_section',
			  'args' => array(
			    'label_for' => 'emergency_contact_no'
			  )
			),
			array(
			  'id' => 'college_email',
			  'title' => 'Colleg Email',
			  'callback' => array( $this->student_callbacks, 'displayCollegeEmail' ),
			  'page' => 'acad_student',
			  'section' => 'acad_student_section',
			  'args' => array(
			    'label_for' => 'college_email'
			  )
			),
			array(
			  'id' => 'personal_email',
			  'title' => 'Personal Email',
			  'callback' => array( $this->student_callbacks, 'displayPersonalEmail' ),
			  'page' => 'acad_student',
			  'section' => 'acad_student_section',
			  'args' => array(
			    'label_for' => 'personal_email'
			  )
			),
			array(
			  'id' => 'caste',
			  'title' => 'Caste',
			  'callback' => array( $this->student_callbacks, 'displayCaste' ),
			  'page' => 'acad_student',
			  'section' => 'acad_student_section',
			  'args' => array(
			    'label_for' => 'caste'
			  )
			),
			array(
			  'id' => 'religion',
			  'title' => 'Religion',
			  'callback' => array( $this->student_callbacks, 'displayReligion' ),
			  'page' => 'acad_student',
			  'section' => 'acad_student_section',
			  'args' => array(
			    'label_for' => 'religion'
			  )
			),
			array(
			  'id' => 'caste_category',
			  'title' => 'Email',
			  'callback' => array( $this->student_callbacks, 'displayCasteCategory' ),
			  'page' => 'acad_student',
			  'section' => 'acad_student_section',
			  'args' => array(
			    'label_for' => 'caste_category'
			  )
			),
			array(
			  'id' => 'is_handicapped',
			  'title' => 'Is Handicapped',
			  'callback' => array( $this->student_callbacks, 'displayIsHandicapped' ),
			  'page' => 'acad_student',
			  'section' => 'acad_student_section',
			  'args' => array(
			    'label_for' => 'is_handicapped'
			  )
			),
			array(
			  'id' => 'is_current',
			  'title' => 'Is Current',
			  'callback' => array( $this->student_callbacks, 'displayIsCurrent' ),
			  'page' => 'acad_student',
			  'section' => 'acad_student_section',
			  'args' => array(
			    'label_for' => 'is_current'
			  )
			),
			array(
				'id' => 'aadhar_id',
				'title' => 'Aadhar ID',
				'callback' => array( $this->student_callbacks, 'displayAadharID' ),
				'page' => 'acad_student',
				'section' => 'acad_student_section',
				'args' => array(
					'label_for' => 'aadhar_id'
				)
			),
			array(
				'id' => 'photo',
				'title' => 'Photo',
				'callback' => array( $this->student_callbacks, 'displayPhoto' ),
				'page' => 'acad_student',
				'section' => 'acad_student_section',
				'args' => array(
					'label_for' => 'photo'
				)
			),
			array(
				'id' => 'bank_account_number',
				'title' => 'Bank Account Number',
				'callback' => array( $this->student_callbacks, 'displayBankAccountNumber' ),
				'page' => 'acad_student',
				'section' => 'acad_student_section',
				'args' => array(
					'label_for' => 'bank_account_number'
				)
			),
			array(
				'id' => 'bank_name',
				'title' => 'Bank Name',
				'callback' => array( $this->student_callbacks, 'displayBankName' ),
				'page' => 'acad_student',
				'section' => 'acad_student_section',
				'args' => array(
					'label_for' => 'bank_name'
				)
			),
			array(
				'id' => 'bank_branch_name',
				'title' => 'Bank Branch Name',
				'callback' => array( $this->student_callbacks, 'displayBankBranchName' ),
				'page' => 'acad_student',
				'section' => 'acad_student_section',
				'args' => array(
					'label_for' => 'bank_branch_name'
				)
			),
			array(
				'id' => 'bank_branch_code',
				'title' => 'Bank branch code',
				'callback' => array( $this->student_callbacks, 'displayBankBranchCode' ),
				'page' => 'acad_student',
				'section' => 'acad_student_section',
				'args' => array(
					'label_for' => 'bank_branch_code'
				)
			),
			/* This is for Student Admission*/
			array(
			  'id' => 'action',
			  'title' => '',
			  'callback' => array( $this->student_admission_callbacks, 'displayStudentAdmissionAction' ),
			  'page' => 'acad_student_admission',
			  'section' => 'acad_student_admission_section',
			  'args' => array(
			    'label_for' =>  'action'
			  )
			),
			array(
			  'id' => 'student_enrollment_number',
			  'title' => 'Student Enrollment Number',
			  'callback' => array( $this->student_admission_callbacks, 'displayStudentEnrollmentNumber' ),
			  'page' => 'acad_student_admission',
			  'section' => 'acad_student_admission_section',
			  'args' => array(
			    'label_for' =>  'student_enrollment_number'
			  )
			),
			array(
			  'id' => 'admission_date',
			  'title' => 'Admission Date',
			  'callback' => array( $this->student_admission_callbacks, 'displayAdmissionDate' ),
			  'page' => 'acad_student_admission',
			  'section' => 'acad_student_admission_section',
			  'args' => array(
			    'label_for' => 'admission_date'  )
			),
			array(
			  'id' => 'admission_year',
			  'title' => 'Admission Year',
			  'callback' => array( $this->student_admission_callbacks, 'displayAdmissionYear' ),
			  'page' => 'acad_student_admission',
			  'section' => 'acad_student_admission_section',
			  'args' => array(
			    'label_for' => 'admission_year'
			  )
			),
			array(
			  'id' => 'admission_type',
			  'title' => 'Admission Type',
			  'callback' => array( $this->student_admission_callbacks, 'displayAdmissionType' ),
			  'page' => 'acad_student_admission',
			  'section' => 'acad_student_admission_section',
			  'args' => array(
			    'label_for' => 'admission_type'
			  )
			),
			array(
			  'id' => 'merit_marks1',
			  'title' => 'Merit Marks 1',
			  'callback' => array( $this->student_admission_callbacks, 'displayMeritMarks1' ),
			  'page' => 'acad_student_admission',
			  'section' => 'acad_student_admission_section',
			  'args' => array(
			    'label_for' => 'merit_marks1'
			  )
			),
			array(
			  'id' => 'merit_marks2',
			  'title' => 'merit Marks 2',
			  'callback' => array( $this->student_admission_callbacks, 'displayMeritMarks2' ),
			  'page' => 'acad_student_admission',
			  'section' => 'acad_student_admission_section',
			  'args' => array(
			    'label_for' => 'merit_marks2'
			  )
			),
			array(
			  'id' => 'merit_rank',
			  'title' => 'Merit Rank',
			  'callback' => array( $this->student_admission_callbacks, 'displayMeritRank' ),
			  'page' => 'acad_student_admission',
			  'section' => 'acad_student_admission_section',
			  'args' => array(
			    'label_for' => 'merit_rank'
			  )
			),
			array(
			  'id' => 'admission_category',
			  'title' => 'Admission Category',
			  'callback' => array( $this->student_admission_callbacks, 'displayAdmissionCategory' ),
			  'page' => 'acad_student_admission',
			  'section' => 'acad_student_admission_section',
			  'args' => array(
			    'label_for' => 'admission_category'
			  )
			),
			/* For Student Request types */
			array(
				'id' => 'action',
				'title' => '',
				'callback' => array( $this->student_req_typ_callbacks, 'displayStudentRequestTypesAction' ),
				'page' => 'acad_student_request_types',
				'section' => 'acad_student_request_types_section',
				'args' => array(
					'label_for' =>  'action'
				)
			),
			array(
				'id' => 'student_request_type_name',
				'title' => 'Student Request Type name',
				'callback' => array( $this->student_req_typ_callbacks, 'displayStudentRequestTypeName' ),
				'page' => 'acad_student_request_types',
				'section' => 'acad_student_request_types_section',
				'args' => array(
					'label_for' => 'student_request_type_name'
				)
			),
			/* For Exam Type */
			array(
				'id' => 'action',
				'title' => '',
				'callback' => array( $this->exam_type_callbacks, 'displayExamTypeAction' ),
				'page' => 'acad_exam_type',
				'section' => 'acad_exam_type_section',
				'args' => array(
					'label_for' =>  'action'
				)
			),
			array(
				'id' => 'exam_name',
				'title' => 'ExamName',
				'callback' => array( $this->exam_type_callbacks, 'displayExamName' ),
				'page' => 'acad_exam_type',
				'section' => 'acad_exam_type_section',
				'args' => array(
					'label_for' => 'exam_name'
				)
			),
			array(
				'id' => 'max_mark',
				'title' => 'MaxMark',
				'callback' => array( $this->exam_type_callbacks, 'displayMaxMark' ),
				'page' => 'acad_exam_type',
				'section' => 'acad_exam_type_section',
				'args' => array(
					'label_for' => 'max_mark'
				)
			),

			/* For Exam  */

			array(
				'id' => 'action',
				'title' => '',
				'callback' => array( $this->exam_callbacks, 'displayExamAction' ),
				'page' => 'acad_exam',
				'section' => 'acad_exam_section',
				'args' => array(
					'label_for' =>  'action'
				)
			),

			array(
			  'id' => 'facultyid',
			  'title' => 'FacultyID',
			  'callback' => array( $this->exam_callbacks, 'displayFacultyID' ),
			  'page' => 'acad_exam',
			  'section' => 'acad_exam_section',
			  'args' => array(
			    'label_for' => 'facultyid'
			  )
			),
			array(
			  'id' => 'courseid',
			  'title' => 'CourseID',
			  'callback' => array( $this->exam_callbacks, 'displayCourseID' ),
			  'page' => 'acad_exam',
			  'section' => 'acad_exam_section',
			  'args' => array(
			    'label_for' => 'courseid'
			  )
			),
			array(
			  'id' => 'examtypeid',
			  'title' => 'ExamTypeID',
			  'callback' => array( $this->exam_callbacks, 'displayExamTypeID' ),
			  'page' => 'acad_exam',
			  'section' => 'acad_exam_section',
			  'args' => array(
			    'label_for' => 'examtypeid'
			  )
			),
			array(
			  'id' => 'evaluationtype',
			  'title' => 'EvaluationType',
			  'callback' => array( $this->exam_callbacks, 'displayEvaluationType' ),
			  'page' => 'acad_exam',
			  'section' => 'acad_exam_section',
			  'args' => array(
			    'label_for' => 'evaluationtype'
			  )
			),
			array(
			  'id' => 'dateofexam',
			  'title' => 'DateOfExam',
			  'callback' => array( $this->exam_callbacks, 'displayDateOfExam' ),
			  'page' => 'acad_exam',
			  'section' => 'acad_exam_section',
			  'args' => array(
			    'label_for' => 'dateofexam'
			  )
			),
			array(
			  'id' => 'duration',
			  'title' => 'Duration',
			  'callback' => array( $this->exam_callbacks, 'displayDuration' ),
			  'page' => 'acad_exam',
			  'section' => 'acad_exam_section',
			  'args' => array(
			    'label_for' => 'duration'
			  )
			),
			array(
			  'id' => 'timeofexam',
			  'title' => 'TimeOfExam',
			  'callback' => array( $this->exam_callbacks, 'displayTimeOfExam' ),
			  'page' => 'acad_exam',
			  'section' => 'acad_exam_section',
			  'args' => array(
			    'label_for' => 'timeofexam'
			  )
			),
			array(
			  'id' => 'place',
			  'title' => 'Place',
			  'callback' => array( $this->exam_callbacks, 'displayPlace' ),
			  'page' => 'acad_exam',
			  'section' => 'acad_exam_section',
			  'args' => array(
			    'label_for' => 'place'
			  )
			)
		);

		$this->settings->setFields( $args );
	}

	public function setFormActions() {
		$args = array(
			array(
				'tag' => 'admin_post_add_department_action',
				'function_to_add' => array( $this->dept_callbacks, 'addDepartment' )
			),
			array(
				'tag' => 'admin_post_nopriv_add_department_action',
				'function_to_add' => array( $this->dept_callbacks, 'addDepartment' )
			),
			array(
				'tag' => 'admin_post_add_course_types_action',
				'function_to_add' => array( $this->course_types_callbacks, 'addCourseType' )
			),
			array(
				'tag' => 'admin_post_add_course_action',
				'function_to_add' => array( $this->course_callbacks, 'addCourse' )
			),
			array(
				'tag' => 'admin_post_add_curriculum_action',
				'function_to_add' => array( $this->curriculum_callbacks, 'addCurriculum' )
			),
			array(
				'tag' => 'admin_post_add_course_curriculum_mapping_action',
				'function_to_add' => array ( $this->ccm_callbacks, 'addCcm' )
			),
			array(
				'tag' => 'admin_post_add_program_action',
				'function_to_add' => array( $this->prog_callbacks, 'addProgram' )
			),
			array(
				'tag' => 'admin_post_add_semester_action',
				'function_to_add' => array( $this->sem_callbacks, 'addSemester' )
			),
			array(
				'tag' => 'admin_post_add_faculty_registration_mapping_action',
				'function_to_add' => array( $this->faculty_reg_map_callbacks, 'addFacultyRegistrationMapping' )
			),
			array(
				'tag' => 'admin_post_add_faculty_action',
				'function_to_add' => array( $this->faculty_callbacks, 'addFaculty' )
			),
			array(
				'tag' => 'admin_post_add_exam_action',
				'function_to_add' => array( $this->exam_callbacks, 'addExam' )
			),
			array(
				'tag' => 'admin_post_add_faculty_course_mapping_action',
				'function_to_add' => array( $this->faculty_course_mapping_callbacks, 'addFacultyCourseMapping' )
			),
			array(
				'tag' => 'admin_post_add_student_action',
				'function_to_add' => array( $this->student_callbacks, 'addStudent' )
			),
			array(
				'tag' => 'admin_post_add_exam_type_action',
				'function_to_add' => array( $this->exam_type_callbacks, 'addExamType' )
			),
			array(
				'tag' => 'admin_post_add_student_admission_action',
				'function_to_add' => array( $this->student_admission_callbacks, 'addStudentAdmission' )
			),
			array(
				'tag' => 'admin_post_add_faculty_qualification_action',
				'function_to_add' => array( $this->faculty_qual_callbacks, 'addFacultyQualification' )
			),
			array(
				'tag' => 'admin_post_add_faculty_experience_action',
				'function_to_add' => array( $this->faculty_exp_callbacks, 'addFacultyExperience' )
			),
			array(
				'tag' => 'admin_post_add_faculty_request_types_action',
				'function_to_add' => array( $this->faculty_req_typ_callbacks, 'addFacultyRequestTypes' )
			),
			array(
				'tag' => 'admin_post_add_student_request_types_action',
				'function_to_add' => array( $this->student_req_typ_callbacks, 'addStudentRequestTypes' )
			),
		);

		$this->settings->setFormActions( $args );
	}

}
 ?>
