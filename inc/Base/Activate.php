<?php

/**
 * @package  Acad Plugin
 */
namespace Inc\Base;
use Inc\Shortcodes\FrontEndShortcodes;

if( !class_exists('Activate') ) {

	class Activate {

		public $shortcodes;

		public static function activate() {
			self::install();
			$shortcodes = new FrontEndShortcodes();
			$shortcodes->userLogin();

			flush_rewrite_rules();
		}

  	public static function install() {

  		global $wpdb;

  		if ( ! is_blog_installed() ) {
  			return;
  		}

  		if ( ! defined( 'ACAD_INSTALLING' ) ) {
  			define( 'ACAD_INSTALLING', true );
  		}

			self::createTables();
			self::createRoles();
			self::insertDummyData();
    }

		/*
		Creates the database schema for the plugin
		*/

    private static function createTables() {
    	require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
    	global $wpdb;
    	global $charset_collate;
      //drop queries are for temporary purpose of developement
      $wpdb->query("DROP TABLE IF EXISTS {$wpdb->prefix}acad_department");
			$wpdb->query("DROP TABLE IF EXISTS {$wpdb->prefix}acad_course_types");
      $wpdb->query("DROP TABLE IF EXISTS {$wpdb->prefix}acad_course");
      $wpdb->query("DROP TABLE IF EXISTS {$wpdb->prefix}acad_curriculum");
      $wpdb->query("DROP TABLE IF EXISTS {$wpdb->prefix}acad_course_curriculum_mapping");
      $wpdb->query("DROP TABLE IF EXISTS {$wpdb->prefix}acad_program");
      $wpdb->query("DROP TABLE IF EXISTS {$wpdb->prefix}acad_semester");
      $wpdb->query("DROP TABLE IF EXISTS {$wpdb->prefix}acad_faculty");
      $wpdb->query("DROP TABLE IF EXISTS {$wpdb->prefix}acad_faculty_qualification");
      $wpdb->query("DROP TABLE IF EXISTS {$wpdb->prefix}acad_faculty_experience");
      $wpdb->query("DROP TABLE IF EXISTS {$wpdb->prefix}acad_faculty_course_mapping");
      $wpdb->query("DROP TABLE IF EXISTS {$wpdb->prefix}acad_student");
      $wpdb->query("DROP TABLE IF EXISTS {$wpdb->prefix}acad_student_admission");

    	$createsql = "CREATE TABLE IF NOT EXISTS {$wpdb->prefix}acad_department(
        DepartmentID INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
        DepartmentAbbreviation VARCHAR(45) UNIQUE NOT NULL,
        DepartmentName VARCHAR(100) UNIQUE NOT NULL,
        DepartmentCode VARCHAR(20) NULL,
        EstablishmentYear INTEGER NULL,
        FaxNo VARCHAR(20) NULL,
        PhoneNo VARCHAR(20) NULL,
        Email VARCHAR(150) NULL,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        PRIMARY KEY(DepartmentID)
    	);";
    	dbDelta($createsql);

			$createsql = "CREATE TABLE IF NOT EXISTS {$wpdb->prefix}acad_course_types(
        CourseTypeID INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
				CourseTypeName VARCHAR(100),
				created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
				PRIMARY KEY(CourseTypeID)
      );";
      dbDelta($createsql);

      $createsql = "CREATE TABLE IF NOT EXISTS {$wpdb->prefix}acad_course(
        CourseID INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
        DepartmentID INTEGER UNSIGNED NOT NULL,
				CourseTypeID INTEGER UNSIGNED NOT NULL,
        CourseName VARCHAR(45) NOT NULL,
        CourseAbbreviation VARCHAR(20) NULL,
        CourseCode VARCHAR(20) UNIQUE NOT NULL,
        SyllabusCode VARCHAR(255) NULL,
        IsTheory BOOL NOT NULL,
        CourseCredits INTEGER UNSIGNED NULL,
        TotalTeachingHours INTEGER UNSIGNED NOT NULL,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        PRIMARY KEY(CourseID),
        FOREIGN KEY(DepartmentID)
          REFERENCES {$wpdb->prefix}acad_department(DepartmentID)
            ON DELETE CASCADE
            ON UPDATE NO ACTION,
				FOREIGN KEY(CourseTypeID)
		      REFERENCES {$wpdb->prefix}acad_course_types(CourseTypeID)
		        ON DELETE CASCADE
		        ON UPDATE NO ACTION
      );";
      dbDelta($createsql);

      $createsql = "CREATE TABLE IF NOT EXISTS {$wpdb->prefix}acad_curriculum(
        CurriculumID INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
        CurriculumCode VARCHAR(20) UNIQUE,
        TotalCredits INTEGER NOT NULL,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        PRIMARY KEY(CurriculumID)
      );";
      dbDelta($createsql);

      $createsql = "CREATE TABLE IF NOT EXISTS {$wpdb->prefix}acad_course_curriculum_mapping(
        CourseCurriculumMappingID INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
        CurriculumID INTEGER UNSIGNED NOT NULL,
        CourseID INTEGER UNSIGNED NOT NULL,
        SemesterNumber INTEGER UNSIGNED NULL,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        PRIMARY KEY(CourseCurriculumMappingID),
        FOREIGN KEY(CourseID)
          REFERENCES {$wpdb->prefix}acad_course(CourseID)
            ON DELETE CASCADE
            ON UPDATE NO ACTION,
        FOREIGN KEY(CurriculumID)
          REFERENCES {$wpdb->prefix}acad_curriculum(CurriculumID)
            ON DELETE CASCADE
            ON UPDATE NO ACTION
      );";
      dbDelta($createsql);

      $createsql = "CREATE TABLE IF NOT EXISTS {$wpdb->prefix}acad_program(
        ProgramID INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
        DepartmentID INTEGER UNSIGNED NOT NULL,
        CurriculumID INTEGER UNSIGNED NOT NULL,
        BranchName VARCHAR(150) NULL,
        DegreeName  VARCHAR(100) NULL,
        ProgramAdmissionYear  YEAR NULL,
        ProgramCode VARCHAR(45) NULL,
        ProgramAbbreviation VARCHAR(20) NULL,
        LaunchYear YEAR NULL,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        PRIMARY KEY(ProgramID,DepartmentID),
        FOREIGN KEY(DepartmentID)
          REFERENCES {$wpdb->prefix}acad_department(DepartmentID)
            ON DELETE CASCADE
            ON UPDATE NO ACTION,
        FOREIGN KEY(CurriculumID)
          REFERENCES {$wpdb->prefix}acad_curriculum(CurriculumID)
            ON DELETE CASCADE
            ON UPDATE NO ACTION
      );";
      dbDelta($createsql);

      $createsql = "CREATE TABLE IF NOT EXISTS {$wpdb->prefix}acad_semester(
        SemesterID INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
        ProgramID INTEGER UNSIGNED NOT NULL,
        MaxCredit INTEGER UNSIGNED NOT NULL,
        MinCredit INTEGER UNSIGNED NOT NULL,
        DurationInMonths DECIMAL NULL,
        SemesterType VARCHAR(50) NULL,
        SemesterNumber INTEGER UNSIGNED NULL,
        IsCurrent BOOL NULL,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        PRIMARY KEY(SemesterID),
        FOREIGN KEY(ProgramID)
          REFERENCES {$wpdb->prefix}acad_program(ProgramID)
            ON DELETE CASCADE
            ON UPDATE NO ACTION
      );";
      dbDelta($createsql);

      $createsql = "CREATE TABLE IF NOT EXISTS {$wpdb->prefix}acad_faculty(
        FacultyID INTEGER UNSIGNED NOT NULL,
        DepartmentID INTEGER UNSIGNED NOT NULL,
        FacultyName VARCHAR(20) NULL,
        YearOfJoining  INTEGER NULL,
        DateOfBirth DATE NULL,
        PermanentAddressLine1 VARCHAR(45) NULL,
        PermanentAddressCountry VARCHAR(45) NULL,
        PermanentAddressState VARCHAR(45) NULL,
        PermanentAddressDistrict VARCHAR(45) NULL,
        PermanentAddressVillage VARCHAR(45) NULL,
        PermanentAddressTaluka VARCHAR(45) NULL,
        PermanentAddressPincode DECIMAL NULL,
        TemporaryAddressLine1 VARCHAR(45) NULL,
        TemporaryAddressCountry VARCHAR(45) NULL,
        TemporaryAddressState VARCHAR(45) NULL,
        TemporaryAddressDistrict VARCHAR(45) NULL,
        TemporaryAddressVillage VARCHAR(45) NULL,
        TemporaryAddressTaluka VARCHAR(45) NULL,
        TemporaryAddressPincode DECIMAL NULL,
        CollegeEmail VARCHAR(60) NULL,
        PersonalEmail VARCHAR(60) NULL,
        ContactNo DECIMAL NULL,
        EmergencyContactNo DECIMAL NULL,
        RelievingDate DATE NULL,
        UniqueNo VARCHAR(20) NULL,
        Gender VARCHAR(10) NULL,
        BloodGroup VARCHAR(5) NULL,
        Caste VARCHAR(20) NULL,
        Religion VARCHAR(20) NULL,
        CasteCategory VARCHAR(50) NULL,
        IsHandicap BOOL NULL,
        BankAccountNo DECIMAL NULL,
        AadhaarID DECIMAL NULL,
        Photo BLOB NULL,
        BankName VARCHAR(20) NULL,
        BankBranch VARCHAR(20) NULL,
        BankBranchCode VARCHAR(20) NULL,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        PRIMARY KEY(FacultyID),
        FOREIGN KEY(DepartmentID)
          REFERENCES {$wpdb->prefix}acad_department(DepartmentID)
            ON DELETE NO ACTION
            ON UPDATE NO ACTION
      );";
      dbDelta($createsql);

      $createsql = "CREATE TABLE IF NOT EXISTS {$wpdb->prefix}acad_faculty_qualification(
        FacultyQualificationID INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
        FacultyID INTEGER UNSIGNED NOT NULL,
        QualificationName VARCHAR(20) NULL,
        CollegeName VARCHAR(20) NULL,
        QualificationLevel VARCHAR(50) NULL,
        YearOfPassing  YEAR NULL,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        PRIMARY KEY(FacultyQualificationID),
        FOREIGN KEY(FacultyID)
          REFERENCES {$wpdb->prefix}acad_faculty(FacultyID)
            ON DELETE NO ACTION
            ON UPDATE NO ACTION
      );";
      dbDelta($createsql);

      $createsql = "CREATE TABLE IF NOT EXISTS {$wpdb->prefix}acad_faculty_experience(
        FacultyExperienceID INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
        FacultyID INTEGER UNSIGNED NOT NULL,
        EmployerName VARCHAR(45) NULL,
        Designation VARCHAR(20) NULL,
        FromDate DATE NULL,
        ToDate DATE NULL,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        PRIMARY KEY(FacultyExperienceID),
        FOREIGN KEY(FacultyID)
          REFERENCES {$wpdb->prefix}acad_faculty(FacultyID)
            ON DELETE NO ACTION
            ON UPDATE NO ACTION
      );";
      dbDelta($createsql);

      $createsql = "CREATE TABLE IF NOT EXISTS {$wpdb->prefix}acad_faculty_course_mapping(
        FacultyCourseMappingID INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
        SemesterID INTEGER UNSIGNED NOT NULL,
        CourseID INTEGER UNSIGNED NOT NULL,
        FacultyID INTEGER UNSIGNED NOT NULL,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        PRIMARY KEY(FacultyCourseMappingID, SemesterID),
        FOREIGN KEY(FacultyID)
          REFERENCES {$wpdb->prefix}acad_faculty(FacultyID)
            ON DELETE NO ACTION
            ON UPDATE NO ACTION,
        FOREIGN KEY(CourseID)
          REFERENCES {$wpdb->prefix}acad_course(CourseID)
            ON DELETE NO ACTION
            ON UPDATE NO ACTION,
        FOREIGN KEY(SemesterID)
          REFERENCES {$wpdb->prefix}acad_semester(SemesterID)
            ON DELETE NO ACTION
            ON UPDATE NO ACTION
      );";
      dbDelta($createsql);

      $createsql = "CREATE TABLE IF NOT EXISTS {$wpdb->prefix}acad_faculty_course_mapping(
        FacultyCourseMappingID INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
        SemesterID INTEGER UNSIGNED NOT NULL,
        CourseID INTEGER UNSIGNED NOT NULL,
        FacultyID INTEGER UNSIGNED NOT NULL,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        PRIMARY KEY(FacultyCourseMappingID, SemesterID),
        FOREIGN KEY(FacultyID)
          REFERENCES {$wpdb->prefix}acad_faculty(FacultyID)
            ON DELETE NO ACTION
            ON UPDATE NO ACTION,
        FOREIGN KEY(CourseID)
          REFERENCES {$wpdb->prefix}acad_course(CourseID)
            ON DELETE NO ACTION
            ON UPDATE NO ACTION,
        FOREIGN KEY(SemesterID)
          REFERENCES {$wpdb->prefix}acad_semester(SemesterID)
            ON DELETE NO ACTION
            ON UPDATE NO ACTION
      );";
      dbDelta($createsql);

      $createsql = "CREATE TABLE IF NOT EXISTS {$wpdb->prefix}acad_student(
        StudentEnrollmentNumber VARCHAR(20) NOT NULL,
				Password VARCHAR(50) NOT NULL,
        ProgramID INTEGER UNSIGNED NOT NULL,
        FirstName VARCHAR(20) NULL,
        MiddleName VARCHAR(20) NULL,
        LastName VARCHAR(20) NULL,
        MotherName VARCHAR(20) NULL,
        Gender VARCHAR(15) NULL,
        DOB DATE NULL,
        BloodGroup VARCHAR(20) NULL,
        TempAddrLine1 VARCHAR(45) NULL,
        TempAddrTaluka VARCHAR(45) NULL,
        TempAddrDistrict VARCHAR(45) NULL,
        TempAddrCountry VARCHAR(45) NULL,
        TempAddrState VARCHAR(45) NULL,
        TempAddrPostalCode VARCHAR(20) NULL,
        PermAddrLine1 VARCHAR(45) NULL,
        PermAddrTaluka VARCHAR(45) NULL,
        PermAddrDistrict VARCHAR(45) NULL,
        PermAddrCountry VARCHAR(45) NULL,
        PermAddrState VARCHAR(45) NULL,
        PermAddrPincode VARCHAR(20) NULL,
        PermAddrContactNo VARCHAR(20) NULL,
        PersonalContactNo VARCHAR(20) NULL,
        EmergencyContactNo VARCHAR(20) NULL,
        CollegeEmail VARCHAR(60) NULL,
        PersonalEmail VARCHAR(60) NULL,
        Caste VARCHAR(20) NULL,
        Religion VARCHAR(20) NULL,
        CasteCategory VARCHAR(20) NULL,
        IsHandicapped BOOL NULL,
        IsCurrent BOOL NULL,
        AadharID VARCHAR(20) NULL,
        Photo BLOB NULL,
        BankAccountNumber VARCHAR(20) NULL,
        BankName VARCHAR(20) NULL,
        BankBranchName VARCHAR(20) NULL,
        BankBranchCode VARCHAR(20) NULL,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        PRIMARY KEY(StudentEnrollmentNumber),
        FOREIGN KEY(ProgramID)
          REFERENCES {$wpdb->prefix}acad_program(ProgramID)
            ON DELETE NO ACTION
            ON UPDATE NO ACTION
      );";
      dbDelta($createsql);

      $createsql = "CREATE TABLE IF NOT EXISTS {$wpdb->prefix}acad_student_admission(
        StudentAdmissionID INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
        StudentEnrollmentNumber VARCHAR(20) NOT NULL,
        AdmissionDate DATE NULL,
        AdmissionYear YEAR NULL,
        AdmissionType VARCHAR(50) NULL,
        MeritMarks1 DECIMAL NULL,
        MeritMarks2 DECIMAL NULL,
        MeritRank INTEGER UNSIGNED NULL,
        AdmissionCategory VARCHAR(50) NULL,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        PRIMARY KEY(StudentAdmissionID),
        FOREIGN KEY(StudentEnrollmentNumber)
          REFERENCES {$wpdb->prefix}acad_student(StudentEnrollmentNumber)
            ON DELETE NO ACTION
            ON UPDATE NO ACTION
      );";
      dbDelta($createsql);

			$createsql = "CREATE TABLE IF NOT EXISTS {$wpdb->prefix}acad_enrollment(
				EnrollmentID INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
				StudentEnrollmentNumber VARCHAR(20) NOT NULL,
				SemesterID INTEGER UNSIGNED NOT NULL,
				CourseID INTEGER UNSIGNED NOT NULL,
				IsCurrentlyEnrolled BOOL NULL,
				IsApproved BOOL DEFAULT 0,
				IsDetained BOOL NULL,
				IsBacklog BOOL NULL,
				CourseGrade DECIMAL NULL,
				created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
				updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
				PRIMARY KEY(EnrollmentID),
				FOREIGN KEY(CourseID)
				  REFERENCES {$wpdb->prefix}acad_course(CourseID)
				    ON DELETE NO ACTION
				    ON UPDATE NO ACTION,
				FOREIGN KEY(SemesterID)
				  REFERENCES {$wpdb->prefix}acad_semester(SemesterID)
				    ON DELETE NO ACTION
				    ON UPDATE NO ACTION,
				FOREIGN KEY(StudentEnrollmentNumber)
				  REFERENCES {$wpdb->prefix}acad_student(StudentEnrollmentNumber)
				    ON DELETE NO ACTION
				    ON UPDATE NO ACTION
			);";
      dbDelta($createsql);

			$createsql = "CREATE TABLE IF NOT EXISTS {$wpdb->prefix}acad_faculty_registration_mapping(
				FacultyRegistrationMappingID INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
				FacultyID INTEGER UNSIGNED NOT NULL,
				SemesterID INTEGER UNSIGNED NOT NULL,
				ProgramID INTEGER UNSIGNED NOT NULL,
				DepartmentID INTEGER UNSIGNED NOT NULL,
				created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
				updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
				PRIMARY KEY(FacultyRegistrationMappingID),
				FOREIGN KEY(ProgramID)
				  REFERENCES {$wpdb->prefix}acad_program(ProgramID)
				    ON DELETE NO ACTION
				    ON UPDATE NO ACTION,
				FOREIGN KEY(DepartmentID)
				  REFERENCES {$wpdb->prefix}acad_department(DepartmentID)
				    ON DELETE NO ACTION
				    ON UPDATE NO ACTION,
				FOREIGN KEY(SemesterID)
				  REFERENCES {$wpdb->prefix}acad_semester(SemesterID)
				    ON DELETE NO ACTION
				    ON UPDATE NO ACTION,
				FOREIGN KEY(FacultyID)
				  REFERENCES {$wpdb->prefix}acad_faculty(FacultyID)
				    ON DELETE NO ACTION
				    ON UPDATE NO ACTION
			);";
      dbDelta($createsql);

			$createsql = "CREATE TABLE IF NOT EXISTS {$wpdb->prefix}acad_semester_registration(
				RegistrationID INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
				FacultyRegistrationMappingID INTEGER UNSIGNED NOT NULL,
				StudentEnrollmentNumber VARCHAR(20) NOT NULL,
				RegistrationDate DATE,
				RegistrationStatus VARCHAR(50) NULL,
				CreditsTaken INTEGER UNSIGNED NULL,
				created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
				updated_a TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
				PRIMARY KEY(RegistrationID),
				FOREIGN KEY(StudentEnrollmentNumber)
					REFERENCES {$wpdb->prefix}acad_student(StudentEnrollmentNumber)
						ON DELETE NO ACTION
						ON UPDATE NO ACTION,
				FOREIGN KEY(FacultyRegistrationMappingID)
					REFERENCES {$wpdb->prefix}acad_faculty_registration_mapping(FacultyRegistrationMappingID)
						ON DELETE NO ACTION
						ON UPDATE NO ACTION
			);";
      dbDelta($createsql);
    }

		/*
		Add roles one by one, along with their capapbilities to Wordpress
		*/

		public static function createRoles() {
    	add_role('student', 'Student', array(
     		'read' => true,
     		'enroll_course'  => true,
     		'view_faculties'  => true,
     		'view_faculty_qualification'  => true,
     		'view_course_syllabus'  => true,
     		'view_courses'  => true,
     		'view_departments'  => true,
     		'view_programs'  => true,
     		'view_students'  => true,
    	));

    	add_role('faculty', 'Faculty', array(
    		'read' => true,
    		'view_enrolled_students' => true,
    		'view_course_syllabus' => true,
    		'update_course_syllabus' => true,
      	'view_faculties'  => true,
      	'view_faculty_qualification'  => true,
     		'view_faculty_experience' => true,
     		'view_courses'  => true,
     		'view_departments'  => true,
     		'view_programs'  => true,
     		'approve_semester_registration'  => true,
    	 ));

			//This is the role that has access of the Wordpress admin dashboard
			$adminRole = get_role('administrator');
			$adminRole->add_cap( 'add_department', true );
			$adminRole->add_cap( 'update_department', true );
			$adminRole->add_cap( 'add_course_types', true );
			$adminRole->add_cap( 'add_course', true );
			$adminRole->add_cap( 'add_curriculum', true );
			$adminRole->add_cap( 'add_course_curriculum_mapping', true );
			$adminRole->add_cap( 'add_program', true );
			$adminRole->add_cap( 'add_semester', true );
    }

    public static function remove_roles() {
    	remove_role('student');
    	remove_role('faculty');
    }

		/*
		Insert sample data into the database after creation
		*/
		public static function insertDummyData() {
			global $wpdb;

			$insertsql = "INSERT INTO {$wpdb->prefix}acad_department(DepartmentID, DepartmentAbbreviation, DepartmentName, DepartmentCode, EstablishmentYear, FaxNo, PhoneNo,Email)VALUES (1, 'Mech', 'Mechanical Engineering', 'ME', 1970, '19827', '9872563789', 'mech@coep.ac.in'), (2, 'Civil', 'Civil Engineering', 'CE', 1972, '19817', '9877763789', 'civil@coep.ac.in'), (3, 'Electrical', 'Electrical Engineering', 'EE', 1972, '19837', '9872577789', 'electrical@coep.ac.in'), (4, 'CompIT', 'Computer Engineering and Information Technology', 'CEIT', 1975, '19777', '7772563789', 'compit@coep.ac.in'); ";
			$wpdb->query( $insertsql );

			$insertsql = "INSERT INTO {$wpdb->prefix}acad_course_types
			(CourseTypeID, CourseTypeName) VALUES (1, 'Mandatory Course'), (2, 'Department Elective'), (3, 'Institute Level Elective'), (4, 'Liberal Learning Course'); ";
			$wpdb->query( $insertsql );

			$insertsql = "INSERT INTO {$wpdb->prefix}acad_course
			(CourseID, DepartmentID, CourseTypeID, CourseName, CourseAbbreviation, CourseCode, SyllabusCode, IsTheory, CourseCredits, TotalTeachingHours) VALUES (1, 4, 1, 'Programming in C', 'PiC', 'CS104', 'CS104', 1, 3, 52), (2, 4, 1, 'Data Structures', 'DS', 'CS210', 'CS210', 1, 3, 52), (3, 1, 3, 'Robotics', 'Rob', 'ME301', 'Me301', 1, 3, 52), (4, 4, 1, 'Digital Singals', 'DigSig', 'CS301', 'CS301', 1, 3, 52), (5, 4, 1, 'Computer Networks', 'CN', 'CS401', 'CS401', 1, 3, 52), (6, 4, 2, 'Advanced Computer Networks', 'ACN', 'CS501', 'CS501', 1, 3, 52), (7, 4, 1, 'Database Management Systems', 'DBMS', 'CS601', 'CS601', 1, 3, 52), (8, 4, 2, 'Advanced Database Management Systems', 'ADBMS', 'CS701', 'CS701', 1, 3, 52), (9, 4, 2, 'Distributes Systems', 'DisSys', 'CS801', 'CS801', 1, 3, 52), (10, 4, 2, 'Graphics and Multimedia', 'GAM', 'CS102', 'CS102', 1, 3, 52), (11, 4, 1, 'Computer Networks', 'CN', 'CS103', 'CS103', 1, 3, 52), (12, 4, 1, 'Microprocessor', 'MP', 'CS105', 'CS105', 1, 3, 52), (13, 4, 1, 'Principles of Programming Languages', 'PPL', 'CS201', 'CS201', 1, 3, 52), (14, 4, 1, 'Advanced Microprocessor', 'AMP', 'CS202', 'CS202', 1, 3, 52), (15, 4, 1, 'Parallel Computing Architectures', 'PCA', 'CS203', 'CS203', 1, 3, 52),
			(16, 4, 2, 'Computer Architectures', 'CA', 'CS204', 'CS204', 1, 3, 52), (17, 4, 2, 'Cyber Security', 'CS', 'CS205', 'CS205', 1, 3, 52), (18, 4, 2, 'Computer Forensics', 'CF', 'CS206', 'CS206', 1, 3, 52), (19, 4, 3, 'German', 'Ger', 'IL201', 'IL201', 1, 3, 52), (20, 4, 3, 'Clay Art and Pottery', 'CAP', 'LLC201', 'LLC201', 1, 3, 52); ";
			$wpdb->query( $insertsql );

			$insertsql = "INSERT INTO {$wpdb->prefix}acad_curriculum
			(CurriculumID, CurriculumCode, TotalCredits) VALUES(1, 'CS201519', 160), (2, 'ME201519', 160), (3, 'CSH201519', 172), (4, 'EE201519', 160); ";
			$wpdb->query( $insertsql );

			$insertsql = "INSERT INTO {$wpdb->prefix}acad_course_curriculum_mapping
			(CourseCurriculumMappingID, CurriculumID, CourseID, SemesterNumber) VALUES (1, 1, 3, 2), (2, 3, 2, 3), (3, 3, 3, 2), (4, 3, 4, 3), (5, 3, 5, 4), (6, 3, 6, 5), (7, 3, 7, 6), (8, 3, 8, 7), (9, 3, 9, 8), (10, 3, 10, 1), (11, 3, 11, 1), (12, 3, 12, 1), (13, 3, 13, 2), (14, 3, 14, 2), (15, 3, 15, 2), (16, 3, 16, 2), (17, 3, 17, 2), (18, 3, 18, 2), (19, 3, 19, 2), (20, 3, 20, 2); ";
			$wpdb->query( $insertsql );

			$insertsql = "INSERT INTO {$wpdb->prefix}acad_program
			(ProgramID, DepartmentID, CurriculumID, BranchName, DegreeName, ProgramAdmissionYear, ProgramCode, ProgramAbbreviation, LaunchYear) VALUES(1, 4, 3, 'Computer Engineering and Information Technology', 'BTech', 2015, 'P-CSITH201519', 'CSIT1519', 2015), (2, 1, 2, 'Mechanical Engineering', 'BTech', 2015, 'P-ME201519', 'ME16519', 2015), (3, 4, 3, 'Computer Engineering and Information Technology', 'BTech', 2015, 'P-CSIT201519', 'CSIT1519', 2015); ";
			$wpdb->query( $insertsql );

			$insertsql = "INSERT INTO {$wpdb->prefix}acad_semester
			(SemesterID, ProgramID, MaxCredit, MinCredit, DurationInMonths, SemesterType, SemesterNumber, IsCurrent) VALUES (1, 1, 24, 18, 6, 'Odd', 1, 1), (2, 3, 24, 18, 6, 'Odd', 1, 1), (3, 3, 24, 18, 5, 'Even', 2, 0), (4, 3, 24, 18, 6, 'Odd', 3, 0), (5, 3, 24, 18, 5, 'Even', 4, 0), (6, 3, 24, 18, 6, 'Odd', 5, 0), (7, 3, 24, 18, 5, 'Even', 6, 0), (8, 3, 24, 18, 6, 'Odd', 7, 0), (9, 3, 24, 18, 5, 'Even', 8, 0); ";
			$wpdb->query( $insertsql );

			$insertsql = "INSERT INTO {$wpdb->prefix}acad_student
				(StudentEnrollmentNumber, Password, ProgramID, FirstName, MiddleName, LastName, MotherName, Gender, DOB, BloodGroup, TempAddrLine1, TempAddrCountry, TempAddrState, TempAddrDistrict, TempAddrTaluka, TempAddrPostalCode, PermAddrLine1, PermAddrCountry, PermAddrState, PermAddrDistrict, PermAddrTaluka, PermAddrPincode, PermAddrContactNo, PersonalContactNo, EmergencyContactNo, CollegeEmail, PersonalEmail, Caste, Religion, CasteCategory, IsHandicapped, IsCurrent, AadharID, Photo, BankAccountNumber, BankName, BankBranchName, BankBranchCode) VALUES (141603002, 'Srush',  3, 'Srushti', 'Avinash', 'Chaudhari', 'Sapana', 'Female', '1997-10-19', 'A+', 'Camp', 'India','Maharshtra','Pune','Pune', 12222,'Shivaji nagar', 'India',  'Maharshtra', 'Pune', 'Pune', 411005, 9234831234, 9968545674, 9923266788, 'chaudharisa16.comp@coep.ac.in', 'asrushti19@gmail.com', 'OBC', 'Hindu', 'OBC', '1', '1', '31456788543', 'Screenshot', '23456789', 'State Bank Of India', 'Pune', '411001'), (141603004, 'Priya',  3, 'Priya', 'Sanjay', 'Kadam', 'Sapana', 'Female', '1997-10-19', 'A+', 'Camp', 'India','Maharshtra','Pune','Pune', 12222,'Shivaji nagar', 'India',  'Maharshtra', 'Pune', 'Pune', 411005, 9234831234, 9968545674, 9923266788, 'kadamps16.comp@coep.ac.in', 'priyakadam@gmail.com', 'Open', 'Hindu', 'Open', '1', '1', '31456788543', 'Screenshot', '23456789', 'State Bank Of India', 'Pune', '411001'), (141603003, 'Vinay',  3, 'Vinay', 'Prakash', 'Desai', 'Sapana', 'Male', '1997-10-19', 'A+', 'Camp', 'India','Maharshtra','Pune','Pune', 12222,'Shivaji nagar', 'India',  'Maharshtra', 'Pune', 'Pune', 411005, 9234831234, 9968545674, 9923266788, 'desaivp.comp@coep.ac.in', 'vinaydesai@gmail.com', 'Open', 'Hindu', 'Open', '1', '1', '31456788543', 'Screenshot', '23456789', 'State Bank Of India', 'Pune', '411001');";
			$wpdb->query($insertsql);

			$insertsql = "INSERT INTO {$wpdb->prefix}acad_faculty
				(FacultyID, DepartmentID, FacultyName, YearOfJoining, DateOfBirth, PermanentAddressLine1, PermanentAddressCountry, PermanentAddressState, PermanentAddressDistrict, PermanentAddressVillage, PermanentAddressTaluka, PermanentAddressPincode, TemporaryAddressLine1, TemporaryAddressCountry,  TemporaryAddressState, TemporaryAddressDistrict, TemporaryAddressVillage,  TemporaryAddressTaluka, TemporaryAddressPincode, CollegeEmail, PersonalEmail, ContactNo, EmergencyContactNo, RelievingDate, UniqueNo, Gender, BloodGroup, Caste, Religion, CasteCategory, IsHandicap, BankAccountNo, AadhaarID, Photo, BankName, BankBranch, BankBranchCode) VALUES (1, 4, 'Ms. Shipra', '2010', '1990-12-1', 'Shivaji Nagar', 'India', 'Maharashtra', 'Pune', 'Pune', 'Pune', 23455, 'Swastik Nagar', 'India', 'Maharashtra', 'Pune', 'Pune', 'Pune', 411003, 'Mhaske16.comp@coep.ac.in', 'shipra@gmail.com', 9978657765, 9987564311, '2019-12-1', '1', 'Female', 'o+', 'Open', 'Hindu', 'Open', '1', 312224566, 334587543, 'Screensoht', 'State Bankof India', 'Swastik Nagar', '12222'); ";
			$wpdb->query($insertsql);

			$insertsql = "INSERT INTO {$wpdb->prefix}acad_faculty_registration_mapping
				(FacultyRegistrationMappingID, FacultyID, SemesterID, ProgramID, DepartmentID) VALUES (1, 1, 2, 3, 4);";
			$wpdb->query($insertsql);

			/*$insertsql = "INSERT INTO {$wpdb->prefix}acad_enrollment
				(EnrollmentID, StudentEnrollmentNumber, SemesterID, CourseID, IsCurrentlyEnrolled, IsApproved, IsDetained, IsBacklog, CourseGrade) VALUES(1, 141603002, 2, 11, 1, 0, 0, 0, 0), (2, 141603002, 2, 12, 1, 0, 0, 0, 0), (3, 141603002, 2, 10, 1, 0, 0, 0, 0), (4, 141603003, 2, 11, 1, 0, 0, 0, 0), (5, 141603003, 2, 12, 1, 0, 0, 0, 0), (6, 141603003, 2, 10, 1, 0, 0, 0, 0), (7, 141603004, 2, 12, 1, 0, 0, 0, 0), (8, 141603004, 2, 11, 1, 0, 0, 0, 0), (9, 141603004, 2, 10, 1, 0, 0, 0, 0); ";
			$wpdb->query($insertsql);

			$insertsql = "INSERT INTO {$wpdb->prefix}acad_semester_registration
				(RegistrationID, FacultyRegistrationMappingID, StudentEnrollmentNumber, RegistrationDate, RegistrationStatus, CreditsTaken) VALUES (1, 1, 141603002, 2019-05-13, 'Pending', 9), (2, 1, 141603003, 2019-05-13, 'Pending', 9), (3, 1, 141603004, 2019-05-13, 'Pending', 9); ";
			$wpdb->query($insertsql); */
		}

	}
}
 ?>
