-- phpMyAdmin commands to create the database locally
-- open up localhost/phpmyadmin
-- create a new database called tamuccdb
-- open up the database and go to the sql tab
-- put these commands below to create the database locally

-- create users entity 
CREATE TABLE users (
	UIN INT(11) NOT NULL,
    First_Name VARCHAR(255) NOT NULL,
    M_Initial VARCHAR(1),
    Last_Name VARCHAR(255) NOT NULL,
    Username VARCHAR(30) NOT NULL,
    Passwords VARCHAR(255) NOT NULL,
    User_Type VARCHAR(10) NOT NULL,
    -- find a way to creat user_type a determining key for college student or admin view
    Email VARCHAR(100),
    Discord_Name VARCHAR(100),
    PRIMARY KEY (UIN)
);

CREATE TABLE Students(
    UIN INT(11) PRIMARY KEY,
    Gender VARCHAR(255) NOT NULL,
    Hispanic BIT NOT NULL,
    Race VARCHAR(255) NOT NULL,
    USCitizen BIT NOT NULL,
    First_Generation BIT NOT NULL,
    DOB VARCHAR(255) NOT NULL,
    GPA DECIMAL(3,2) NOT NULL,
    Major VARCHAR(255) NOT NULL,
    Minor1 VARCHAR(255),
    Minor2 VARCHAR(255),
    Expected_Grad VARCHAR(255),
    School VARCHAR(255) NOT NULL,
    Current_Classification VARCHAR(255) NOT NULL,
    Stdent_Type VARCHAR(255) NOT NULL,
    Phone_Num VARCHAR(10) NOT NULL,
    FOREIGN KEY (UIN) REFERENCES users(UIN)
);

CREATE TABLE Classes (
    Class_ID INT(10) NOT NULL,
    Class_Name VARCHAR(255) NOT NULL,
    Class_Desc VARCHAR(255) NOT NULL,
    Class_Type VARCHAR(255) NOT NULL,
    PRIMARY KEY (Class_ID)
);

CREATE TABLE Class_Enrollment(
    CE_Num INT(10) NOT NULL,
    UIN INT(11) NOT NULL,
    Class_ID INT(10) NOT NULL,
    Stat VARCHAR(255) NOT NULL,
    Semester VARCHAR(255) NOT NULL,
    Year INT(4) NOT NULL,
    PRIMARY KEY (CE_Num),
    FOREIGN KEY (UIN) REFERENCES Students(UIN),
    FOREIGN KEY (Class_ID) REFERENCES Classes(Class_ID)
);