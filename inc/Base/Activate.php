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
      /*$wpdb->query("DROP TABLE IF EXISTS {$wpdb->prefix}acad_department");
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
			*/
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

			$createsql = "CREATE TABLE IF NOT EXISTS {$wpdb->prefix}acad_faculty_course_mapping(
				FacultyCourseMappingID INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
			  SemesterID INTEGER UNSIGNED NOT NULL,
			  CourseID INTEGER UNSIGNED NOT NULL,
			  FacultyID INTEGER UNSIGNED NOT NULL,
			  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
			  updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
			  PRIMARY KEY(FacultyCourseMappingID, SemesterID),
			  FOREIGN KEY(FacultyID)
			    REFERENCES Faculty(FacultyID)
			      ON DELETE NO ACTION
			      ON UPDATE NO ACTION,
			  FOREIGN KEY(CourseID)
			    REFERENCES Course(CourseID)
			      ON DELETE NO ACTION
			      ON UPDATE NO ACTION,
			  FOREIGN KEY(SemesterID)
			    REFERENCES Semester(SemesterID)
			      ON DELETE NO ACTION
			      ON UPDATE NO ACTION
			);";
      dbDelta($createsql);

			$createsql = "CREATE TABLE IF NOT EXISTS {$wpdb->prefix}acad_faculty_request_types(
				FacultyRequestTypeID INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
				FacultyRequestTypeName VARCHAR(100) NOT NULL,
				created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
				updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
				PRIMARY KEY(FacultyRequestTypeID)
			);";
			dbDelta($createsql);

		$createsql = "CREATE TABLE IF NOT EXISTS {$wpdb->prefix}acad_faculty_requests(
				FacultyRequestID INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
				FacultyID INTEGER UNSIGNED NOT NULL,
				FacultyRequestSubject VARCHAR(200) NOT NULL,
				FacultyRequestDetails VARCHAR(500) NOT NULL,
				FacultyRequestTypeID INTEGER UNSIGNED NOT NULL,
				FacultyRequestStatus VARCHAR(20) NOT NULL,
				created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
				updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
				PRIMARY KEY(FacultyRequestID),
				FOREIGN KEY(FacultyID)
					REFERENCES {$wpdb->prefix}acad_faculty(FacultyID)
						ON DELETE NO ACTION
						ON UPDATE NO ACTION,
				FOREIGN KEY(FacultyRequestTypeID)
					REFERENCES {$wpdb->prefix}acad_faculty_request_types(FacultyRequestTypeID)
						ON DELETE NO ACTION
						ON UPDATE NO ACTION
		);";
		dbDelta($createsql);

			$createsql = "CREATE TABLE IF NOT EXISTS {$wpdb->prefix}acad_faculty_responses(
				FacultyResponseID INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
				FacultyRequestID INTEGER UNSIGNED NOT NULL,
				FacultyID INTEGER UNSIGNED NOT NULL,
				FacultyResponse VARCHAR(200) NOT NULL,
				IsApproved BOOL NULL,
				created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
				updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
				PRIMARY KEY(FacultyResponseID),
				FOREIGN KEY(FacultyID)
					REFERENCES {$wpdb->prefix}acad_faculty(FacultyID)
						ON DELETE NO ACTION
						ON UPDATE NO ACTION,
				FOREIGN KEY(FacultyRequestID)
					REFERENCES {$wpdb->prefix}acad_faculty_requests(FacultyRequestID)
						ON DELETE NO ACTION
						ON UPDATE NO ACTION
			);";
			dbDelta($createsql);

			$createsql = "CREATE TABLE IF NOT EXISTS {$wpdb->prefix}acad_exam_type(
				ExamTypeID INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
				ExamName INTEGER UNSIGNED NULL,
				MaxMark INTEGER UNSIGNED NULL,
				created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
				updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
				PRIMARY KEY(ExamTypeID)
			);";
			dbDelta($createsql);

			$createsql = "CREATE TABLE IF NOT EXISTS {$wpdb->prefix}acad_exam(
				ExamID INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
				FacultyID INTEGER UNSIGNED NOT NULL,
				CourseID INTEGER UNSIGNED NOT NULL,
				ExamTypeID INTEGER UNSIGNED NOT NULL,
				EvaluationType VARCHAR(50) NULL,
				DateOfExam DATE NULL,
				Duration DECIMAL NULL,
				TimeOfExam TIME NULL,
				Place VARCHAR(20) NULL,
				created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
				updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
				PRIMARY KEY(ExamID),
				FOREIGN KEY(ExamTypeID)
					REFERENCES {$wpdb->prefix}acad_exam_type(ExamTypeID)
						ON DELETE NO ACTION
						ON UPDATE NO ACTION,
				FOREIGN KEY(CourseID)
					REFERENCES {$wpdb->prefix}acad_course(CourseID)
						ON DELETE NO ACTION
						ON UPDATE NO ACTION,
				FOREIGN KEY(FacultyID)
					REFERENCES {$wpdb->prefix}acad_faculty(FacultyID)
						ON DELETE NO ACTION
						ON UPDATE NO ACTION
			);";
			dbDelta($createsql);

			$createsql = "CREATE TABLE IF NOT EXISTS {$wpdb->prefix}acad_student_request_types(
				StudentRequestTypeID INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
				StudentRequestTypeName VARCHAR(100) NOT NULL,
				created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
				updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
				PRIMARY KEY(StudentRequestTypeID)
			);";
			dbDelta($createsql);

			$createsql = "CREATE TABLE IF NOT EXISTS {$wpdb->prefix}acad_student_requests(
				StudentRequestID INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
			  StudentEnrollmentNumber VARCHAR(20) NOT NULL,
			  StudentRequestTypeID INTEGER UNSIGNED NOT NULL,
			  StudentRequestSubject VARCHAR(200) NOT NULL,
			  StudentRequestDetails VARCHAR(500) NOT NULL,
			  StudentRequestStatus VARCHAR(20) NOT NULL,
			  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
			  updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
			  PRIMARY KEY(StudentRequestID),
			  FOREIGN KEY(StudentEnrollmentNumber)
			    REFERENCES {$wpdb->prefix}acad_student(StudentEnrollmentNumber)
			      ON DELETE NO ACTION
			      ON UPDATE NO ACTION,
			  FOREIGN KEY(StudentRequestTypeID)
			    REFERENCES {$wpdb->prefix}acad_student_request_types(StudentRequestTypeID)
			      ON DELETE NO ACTION
			      ON UPDATE NO ACTION
		);";
		dbDelta($createsql);



			$createsql = "CREATE TABLE IF NOT EXISTS {$wpdb->prefix}acad_feedback_category(
			 FeedbackCategoryID INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
			 FeedbackCategoryName VARCHAR(20) NULL,
			 created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
			 updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
			 PRIMARY KEY(FeedbackCategoryID)
		);";
		dbDelta($createsql);

			$createsql = "CREATE TABLE IF NOT EXISTS {$wpdb->prefix}acad_student_exam_score(
				StudentExamScoreID INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
			  EnrollmentID INTEGER UNSIGNED NOT NULL,
			  ExamID INTEGER UNSIGNED NOT NULL,
			  StudentExamScore INTEGER UNSIGNED NULL,
			  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
			  updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
			  PRIMARY KEY(StudentExamScoreID),
			  FOREIGN KEY(ExamID)
			    REFERENCES {$wpdb->prefix}acad_exam(ExamID)
			      ON DELETE NO ACTION
			      ON UPDATE NO ACTION,
			  FOREIGN KEY(EnrollmentID)
			    REFERENCES {$wpdb->prefix}acad_enrollment(EnrollmentID)
			      ON DELETE NO ACTION
			      ON UPDATE NO ACTION
		);";
		dbDelta($createsql);

			$createsql = "CREATE TABLE IF NOT EXISTS {$wpdb->prefix}acad_student_attendance(
				StudentAttendanceID INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
			  EnrollmentID INTEGER UNSIGNED NOT NULL,
			  Date DATE NULL,
			  IsPresent BOOL NULL,
			  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
			  updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
			  PRIMARY KEY(StudentAttendanceID),
			  FOREIGN KEY(EnrollmentID)
			    REFERENCES {$wpdb->prefix}acad_enrollment(EnrollmentID)
			      ON DELETE NO ACTION
			      ON UPDATE NO ACTION
		);";
		dbDelta($createsql);

			$createsql = "CREATE TABLE IF NOT EXISTS {$wpdb->prefix}acad_log_table(
				  LogTableID INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
				  ModifiedBy INTEGER UNSIGNED NULL,
				  ModifiedOn DATETIME NULL,
				  CreatedBy INTEGER UNSIGNED NULL,
				  CreatedOn DATETIME NULL,
				  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
				  updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
				  PRIMARY KEY(LogTableID)
				);";
				dbDelta($createsql);

			$createsql = "CREATE TABLE IF NOT EXISTS {$wpdb->prefix}acad_faculty_attendance(
				FacultyAttendanceID INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
				FacultyID INTEGER UNSIGNED NOT NULL,
				CurrentDate DATE NULL,
				IsPresent BOOL NULL,
				created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
				updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
				PRIMARY KEY(FacultyAttendanceID),
				FOREIGN KEY(FacultyID)
					REFERENCES {$wpdb->prefix}acad_faculty(FacultyID)
						ON DELETE NO ACTION
						ON UPDATE NO ACTION
				);";
				dbDelta($createsql);

			$createsql = "CREATE TABLE IF NOT EXISTS {$wpdb->prefix}acad_student_feedback(
				StudentFeedbackID INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
			  EnrollmentID INTEGER UNSIGNED NOT NULL,
			  FeedbackCategory1Marks INTEGER UNSIGNED NULL,
			  Category2Marks INTEGER UNSIGNED NULL,
			  Category3Marks INTEGER UNSIGNED NULL,
			  Category4Marks INTEGER UNSIGNED NULL,
			  Category5Marks INTEGER UNSIGNED NULL,
			  Category6Marks INTEGER UNSIGNED NULL,
			  Category7Marks INTEGER UNSIGNED NULL,
			  Category8Marks INTEGER UNSIGNED NULL,
			  Category9Marks INTEGER UNSIGNED NULL,
			  Category10Marks INTEGER UNSIGNED NULL,
			  Remarks VARCHAR(255) NULL,
			  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
			  updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
			  PRIMARY KEY(StudentFeedbackID),
			  FOREIGN KEY(EnrollmentID)
			    REFERENCES {$wpdb->prefix}acad_enrollment(EnrollmentID)
			      ON DELETE NO ACTION
			      ON UPDATE NO ACTION
				);";
				dbDelta($createsql);

			$createsql = "CREATE TABLE IF NOT EXISTS {$wpdb->prefix}acad_student_sem_academic_record(
				 StudentAcademicRecordID INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
				 SemesterID INTEGER UNSIGNED NOT NULL,
				 StudentEnrollmentNumber VARCHAR(20) NOT NULL,
				 SemScore INTEGER UNSIGNED NULL,
				 IsPassed BOOL NULL,
				 IsDebarred BOOL NULL,
				 created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
				 updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
				 PRIMARY KEY(StudentAcademicRecordID),
			   FOREIGN KEY(StudentEnrollmentNumber)
				 REFERENCES {$wpdb->prefix}acad_student(StudentEnrollmentNumber)
					 ON DELETE NO ACTION
					 ON UPDATE NO ACTION
				 FOREIGN KEY(SemesterID)
				   REFERENCES {$wpdb->prefix}acad_semester(SemesterID)
	 				   ON DELETE NO ACTION
	 				   ON UPDATE NO ACTION
				);";
				dbDelta($createsql);

				$createsql = "CREATE TABLE IF NOT EXISTS {$wpdb->prefix}acad_student_responses(
				StudentResponseID INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
				StudentRequestID INTEGER UNSIGNED NOT NULL,
				FacultyID INTEGER UNSIGNED NOT NULL,
				StudentResponse VARCHAR(200) NOT NULL,
				IsApproved BOOL NULL,
				created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
				updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
				PRIMARY KEY(StudentResponseID),
				FOREIGN KEY(FacultyID)
				REFERENCES {$wpdb->prefix}acad_faculty(FacultyID)
					ON DELETE NO ACTION
					ON UPDATE NO ACTION,
				FOREIGN KEY(StudentRequestID)
				REFERENCES {$wpdb->prefix}acad_student_requests(StudentRequestID)
					ON DELETE NO ACTION
					ON UPDATE NO ACTION
				); ";
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
     		'view_students'  => true
    	));

    	add_role('faculty', 'Faculty', array(
    		'read' => true,
				'approve_semester_registration'  => true
    	 ));

			//This is the role that has access of the Wordpress admin dashboard
			$adminRole = get_role('administrator');
			$adminRole->add_cap( 'add_department', true );
			$adminRole->add_cap( 'update_department', tru );
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
				(StudentEnrollmentNumber, Password, ProgramID, FirstName, MiddleName, LastName, MotherName, Gender, DOB, BloodGroup, TempAddrLine1, TempAddrCountry, TempAddrState, TempAddrDistrict, TempAddrTaluka, TempAddrPostalCode, PermAddrLine1, PermAddrCountry, PermAddrState, PermAddrDistrict, PermAddrTaluka, PermAddrPincode, PermAddrContactNo, PersonalContactNo, EmergencyContactNo, CollegeEmail, PersonalEmail, Caste, Religion, CasteCategory, IsHandicapped, IsCurrent, AadharID, Photo, BankAccountNumber, BankName, BankBranchName, BankBranchCode) VALUES (141603001, 'Bharte12',  3, 'Abhishek', 'Sudhakar', 'Bharte', 'Avni', 'Male', '1997-12-09', 'A+', 'COEP HOSTEL', 'India','Maharshtra','Pune','Pune', 411005,'Pingle Vasti', 'India',  'Maharshtra', 'Pune', 'Pune', 411005, 9045321345, 9968545674, 9923266788, 'bharteas16.comp@coep.ac.in', 'abhishek16@gmail.com', 'OBC', 'Hindu', 'OBC', '1', '1', '31456788543', 'Screenshot', '23456789', 'State Bank Of India', 'Pune', '411001'),

(141603002, 'Srush',  3, 'Srushti', 'Avinash', 'Chaudhari', 'Sakshi', 'Female', '1997-11-11', 'A+', 'COEP Hostel', 'India','Maharshtra','Pune','Pune', 411005,'Balaji Nagar', 'India',  'Maharshtra', 'Pune', 'Pune', 411005, 9987342133, 9968545674, 9923266788, 'chaudharisa16.comp@coep.ac.in', 'asrushti19@gmail.com', 'OBC', 'Hindu', 'OBC', '1', '1', '31456788543', 'Screenshot', '23456789', 'State Bank Of India', 'Pune', '411001'),

(141603003, 'Vinay@123',  3, 'Vinay', 'Rajesh', 'Desai', 'swati', 'Male', '1996-05-25', 'A+', 'COEP Hostel', 'India','Maharshtra','Pune','Pune', 411005,'CIDCO', 'India',  'Maharshtra', 'Pune', 'Pune', 411005, 9987856643, 9968545674, 9923266788, 'desaivr16.comp@coep.ac.in', 'desaivinay@gmail.com', 'Open', 'Hindu', 'Open', '1', '1', '31456788543', 'Screenshot', '23456789', 'State Bank Of India', 'Pune', '411001'),

(141603004, 'kadamps1',  3, 'Priya', 'Sanjay', 'Kadam', 'Vaishnavi', 'Female', '1997-12-08', 'A+', 'COEP Hostel', 'India','Maharshtra','Pune','Pune', 411005,'Shastri Nagar', 'India',  'Maharshtra', 'Pune', 'Pune', 411005, 9023768956, 9968545674, 9923266788, 'kadaps16.comp@coep.ac.in', 'priya.kadam844@gmail.com', 'Open', 'Hindu', 'Open', '1', '1', '31456788543', 'Screenshot', '23456789', 'State Bank Of India', 'Pune', '411001'),

(141603005, 'Priya24',  3, 'Priyanka', 'Vikram', 'Karande', 'Swapnali', 'Female', '1996-12-20', 'A+', 'COEP Hostel', 'India','Maharshtra','Pune','Pune', 411005,'Shiveshwar Colony', 'India',  'Maharshtra', 'Pune', 'Pune', 411005, 9111234532, 9968545674, 9923266788, 'karandepv16.comp@coep.ac.in', 'priyapri.karande@gmail.com', 'Open', 'Hindu', 'Open', '1', '1', '31456788543', 'Screenshot', '23456789', 'State Bank Of India', 'Pune', '411001'),

(141603006, 'Saman12',  3, 'Varsha', 'Rajesh', 'Mahajan', 'Mrunali', 'Female', '1996-12-21', 'A+', 'COEP Hostel', 'India','Maharshtra','Pune','Pune', 411005,'Warje Chowk', 'India',  'Maharshtra', 'Pune', 'Pune', 411005, 9989976099, 9968545674, 9923266788, 'mahajanvr16.comp@coep.ac.in', 'varshmahajan@gmail.com', 'Open', 'Hindu', 'Open', '1', '1', '31456788543', 'Screenshot', '23456789', 'State Bank Of India', 'Pune', '411001'),

(141603007, 'Swati1234#',  3, 'Swati', 'Mahadeb', 'Nimbolkar', 'Anita', 'Female', '1996-02-21', 'A+', 'COEP Hostel', 'India','Maharshtra','Pune','Pune', 411005,'Shivaji Chowk', 'India',  'Maharshtra', 'Pune', 'Pune', 411005, 7789456129, 9968545674, 9923266788, 'nimbolkarsm16.comp@coep.ac.in', 'swatiitssachi@gmail.com', 'Open', 'Hindu', 'Open', '1', '1', '31456788543', 'Screenshot', '23456789', 'State Bank Of India', 'Pune', '411001'),

(141603008, 'Kumar88',  3, 'Kumar', 'Avinash', 'Swati', 'Sandhya', 'Male', '1996-05-29', 'A+', 'COEP Hostel', 'India','Maharshtra','Pune','Pune', 411005,'Mayur nagar', 'India',  'Maharshtra', 'Pune', 'Pune', 411005, 9987123456, 9968545674, 9923266788, 'kumarsw16.comp@coep.ac.in', 'kumarswati@gmail.com', 'OBC', 'Hindu', 'OBC', '1', '1', '31456788543', 'Screenshot', '23456789', 'State Bank Of India', 'Pune', '411001'),

(141603009, 'Ram88',  3, 'Rameshwar', 'Avinash', 'Raut', 'Anita', 'Male', '1996-05-29', 'A+', 'COEP Hostel', 'India','Maharshtra','Pune','Pune', 411005,'Mayur nagar', 'India',  'Maharshtra', 'Pune', 'Pune', 411005, 9987123456, 9968545674, 9923266788, 'raut16.comp@coep.ac.in', 'ramesh@gmail.com', 'OBC', 'Hindu', 'OBC', '1', '1', '31456788543', 'Screenshot', '23456789', 'State Bank Of India', 'Pune', '411001'),

(1416030010, 'patil88',  3, 'Omkar', 'Suresh', 'Patil', 'Swati', 'Male', '1996-06-20', 'A+', 'COEP Hostel', 'India','Maharshtra','Pune','Pune', 411005,'Mayur nagar', 'India',  'Maharshtra', 'Pune', 'Pune', 411005, 9987123456, 9968545674, 9923266788, 'patilsw16.comp@coep.ac.in', 'omakr5@gmail.com', 'OBC', 'Hindu', 'OBC', '1', '1', '31456788543', 'Screenshot', '23456789', 'State Bank Of India', 'Pune', '411001'); ";
			$wpdb->query($insertsql);

			$insertsql = "INSERT INTO {$wpdb->prefix}acad_faculty
				(FacultyID, DepartmentID, FacultyName, YearOfJoining, DateOfBirth, PermanentAddressLine1, PermanentAddressCountry, PermanentAddressState, PermanentAddressDistrict, PermanentAddressVillage, PermanentAddressTaluka, PermanentAddressPincode, TemporaryAddressLine1, TemporaryAddressCountry,  TemporaryAddressState, TemporaryAddressDistrict, TemporaryAddressVillage,  TemporaryAddressTaluka, TemporaryAddressPincode, CollegeEmail, PersonalEmail, ContactNo, EmergencyContactNo, RelievingDate, UniqueNo, Gender, BloodGroup, Caste, Religion, CasteCategory, IsHandicap, BankAccountNo, AadhaarID, Photo, BankName, BankBranch, BankBranchCode) VALUES (1, 4, 'Ms. Shipra', '2010', '1990-12-1', 'Shivaji Nagar', 'India', 'Maharashtra', 'Pune', 'Pune', 'Pune', 23455, 'Swastik Nagar', 'India', 'Maharashtra', 'Pune', 'Pune', 'Pune', 411003, 'Mhaske16.comp@coep.ac.in', 'shipra@gmail.com', 9978657765, 9987564311, '2019-12-1', '1', 'Female', 'o+', 'Open', 'Hindu', 'Open', '1', 312224566, 334587543, 'Screensoht', 'State Bankof India', 'Swastik Nagar', '12222'),

(2, 2, 'Mr. Amit Joshi', '2010', '1988-15-12', 'Shivaji Nagar', 'India', 'Maharashtra', 'Pune', 'Pune', 'Pune', 32455, 'Chando Chowk', 'India', 'Maharashtra', 'Pune', 'Pune', 'Pune', 411003, 'Joshi15.comp@coep.ac.in', 'amitjoshi9@gmail.com', 9978443544, 9934334598, '2019-02-1', '1', 'Male', 'a+', 'Open', 'Hindu', 'Open', '1', 234224555, 56777543, 'Screensoht', 'State Bankof India', 'Chandni Chowk', '123321'),

(3, 3, 'Mr. Sushil Deshmukh', '2010', '1990-04-11', 'Shivaji Nagar', 'India', 'Maharashtra', 'Pune', 'Pune', 'Pune', 32456, 'Keshav Nagar', 'India', 'Maharashtra', 'Pune', 'Pune', 'Pune', 411004, 'Deshmukh15.entc@coep.ac.in', 'dehsmukhss@gmail.com', 78459815, 75896542, '2019-11-1', '1', 'Male', 'b+', 'Open', 'Hindu', 'Open', '1', 78542295, 33256415, 'Screensoht', 'State Bankof India', 'Keshav Nagar', '87422'),

(4, 4, 'Mrs. Sheetal Rathod', '2010', '1989-12-1', 'Shivaji Nagar', 'India', 'Maharashtra', 'Pune', 'Pune', 'Pune', 23455, 'Pingle Vasti', 'India', 'Maharashtra', 'Pune', 'Pune', 'Pune', 411043, 'Rathod15.comp@coep.ac.in', 'sheeetalrathod@gmail.com', 9987794512, 7798641125, '2019-12-1', '1', 'Female', 'o+', 'Open', 'Hindu', 'Open', '1', 234124566, 667587543, 'Screensoht', 'State Bankof India', 'Pingle Vasti', '67222'),

(5, 5, 'Ms. Apeksha Thorat', '2010', '1987-09-18', 'Shivaji Nagar', 'India', 'Maharashtra', 'Pune', 'Pune', 'Pune', 23455, 'Hadapsar Area', 'India', 'Maharashtra', 'Pune', 'Pune', 'Pune', 411012, 'Thorat12.comp@coep.ac.in', 'shipra@gmail.com', 7798641352, 88564791258, '2018-12-1', '1', 'Female', 'o+', 'Open', 'Hindu', 'Open', '1', 79864412, 33154285, 'Screensoht', 'State Bankof India', 'Hadapsar Branch', '12222'),

(6,6, 'Mrs. Archana Patil', '2010', '1988-11-20', 'Shivaji Nagar', 'India', 'Maharashtra', 'Pune', 'Pune', 'Pune', 23455, 'Koregoan Park', 'India', 'Maharashtra', 'Pune', 'Pune', 'Pune', 411003, 'Patl15.it@coep.ac.in', 'archanapatil12@gmail.com', 7785441259, 9987564311, '2019-11-1', '1', 'Female', 'b+', 'Open', 'Hindu', 'Open', '1', 12458545, 7785459, 'Screensoht', 'State Bankof India', 'Koregoan Park Branch', '12222'),

(7,7, 'Mrs. Sandhya Deshmukh', '2010', '1985-12-30', 'Shivaji Nagar', 'India', 'Maharashtra', 'Pune', 'Pune', 'Pune', 23455, 'Mundhwa', 'India', 'Maharashtra', 'Pune', 'Pune', 'Pune', 411123, 'Deshmukh15.it@coep.ac.in', 'sandhyad1@gmail.com', 7485124577, 9985648759, '2019-11-1', '1', 'Female', 'o+', 'Open', 'Hindu', 'Open', '1', 78451258, 748512, 'Screensoht', 'State Bankof India', 'Mundhwa Branch', '14526'),

(8,8, 'Mrs. Ajit Raut', '2010', '1989-01-29', 'Shivaji Nagar', 'India', 'Maharashtra', 'Pune', 'Pune', 'Pune', 23455, 'Pimpri', 'India', 'Maharashtra', 'Pune', 'Pune', 'Pune', 412006, 'Raut15.it@coep.ac.in', 'ajit10@gmail.com', 7546125839, 7485124598, '2019-11-1', '1', 'Male', 'o+', 'Open', 'Hindu', 'Open', '1', 21343, 1233, 'Screensoht', 'State Bankof India', 'Pimpri Branch', '12222'),

(9,9, 'Mrs. Shraddha Kasliwal', '2010', '1988-12-04', 'Shivaji Nagar', 'India', 'Maharashtra', 'Pune', 'Pune', 'Pune', 23455, 'Koregoan Park', 'India', 'Maharashtra', 'Pune', 'Pune', 'Pune', 411003, 'Kasliwal15.it@coep.ac.in', 'shraddhak@gmail.com', 7485124598, 9748645312, '2019-11-1', '1', 'Female', 'a+', 'Open', 'Hindu', 'Open', '1', 12345, 23445, 'Screensoht', 'State Bankof India', 'Koregoan Park Branch', '12222'),

(10,10, 'Mrs. Shweta Desai', '2010', '1988-01-22', 'Shivaji Nagar', 'India', 'Maharashtra', 'Pune', 'Pune', 'Pune', 23455, 'Baner', 'India', 'Maharashtra', 'Pune', 'Pune', 'Pune', 411003, 'desai15.comp@coep.ac.in', 'desai9@gmail.com', 7485914658, 7948612589, '2019-11-1', '1', 'Female', 'a+', 'Open', 'Hindu', 'Open', '1', 542234, 223455, 'Screensoht', 'State Bankof India', 'Koregoan Park Branch', '12222');";
			$wpdb->query($insertsql);

			$insertsql = "INSERT INTO {$wpdb->prefix}acad_faculty_registration_mapping
				(FacultyRegistrationMappingID, FacultyID, SemesterID, ProgramID, DepartmentID) VALUES (1, 1, 2, 3, 4);";
			$wpdb->query($insertsql);

			$insertsql = "INSERT INTO {$wpdb->prefix}acad_enrollment
				(EnrollmentID, StudentEnrollmentNumber, SemesterID, CourseID, IsCurrentlyEnrolled, IsApproved, IsDetained, IsBacklog, CourseGrade) VALUES(1, 141603002, 2, 11, 1, 0, 0, 0, 0), (2, 141603002, 2, 12, 1, 0, 0, 0, 0), (3, 141603002, 2, 10, 1, 0, 0, 0, 0), (4, 141603003, 2, 11, 1, 0, 0, 0, 0), (5, 141603003, 2, 12, 1, 0, 0, 0, 0), (6, 141603003, 2, 10, 1, 0, 0, 0, 0), (7, 141603004, 2, 12, 1, 0, 0, 0, 0), (8, 141603004, 2, 11, 1, 0, 0, 0, 0), (9, 141603004, 2, 10, 1, 0, 0, 0, 0); ";
			$wpdb->query($insertsql);

			$insertsql = "INSERT INTO {$wpdb->prefix}acad_semester_registration
				(RegistrationID, FacultyRegistrationMappingID, StudentEnrollmentNumber, RegistrationDate, RegistrationStatus, CreditsTaken) VALUES (1, 1, 141603002, '2019-05-13', 'Pending', 9), (2, 1, 141603003, '2019-05-13', 'Pending', 9), (3, 1, 141603004, '2019-05-13', 'Pending', 9); ";
			$wpdb->query($insertsql);

			$insertsql = "INSERT INTO {$wpdb->prefix}acad_faculty_course_mapping
				(FacultyCourseMappingID, SemesterID, CourseID, FacultyID) VALUES(1, 1, 1, 1), (2, 1, 10, 1), (3, 1, 11, 1), (4, 1, 12, 1), (5, 1, 15, 1), (6, 1, 16, 1), (7, 1, 17, 1), (8, 1, 18, 1); ";
			$wpdb->query($insertsql);

			$insertsql = "INSERT INTO {$wpdb->prefix}acad_faculty_qualification
			(FacultyID, QualificationName, CollegeName, QualificationLevel, YearOfPassing) VALUES(1, 'M.tech', 'COEP', 3, 2014 ),(2,'M.tech', 'COEP', 3, 2009 ),(3,'B.tech', 'COEP', 3, 2010 ),(4,'M.tech', 'COEP', 2, '2010' ),(5,'M.tech', 'COEP', 3, 2011 ); ";

			$insertsql = "INSERT INTO {$wpdb->prefix}acad_faculty_experience
			(FacultyID, QualificationName, CollegeName, QualificationLevel, YearOfPassing) VALUES(1, 'M.tech', 'COEP', 3, 2014 ),(2,'M.tech', 'COEP', 3, 2009 ),(3,'B.tech', 'COEP', 3, 2010 ),(4,'M.tech', 'COEP', 2, '2010' ),(5,'M.tech', 'COEP', 3, 2011 ); ";




		}

	}
}
 ?>
