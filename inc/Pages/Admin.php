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
			)
		);

		$this->settings->setFormActions( $args );
	}

}
 ?>
