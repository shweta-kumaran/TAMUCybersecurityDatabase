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
    Username VARCHAR(150) NOT NULL,
    Passwords VARCHAR(255) NOT NULL,
    User_Type VARCHAR(50) NOT NULL,
    Email VARCHAR(150),
    Discord_Name VARCHAR(150),
    PRIMARY KEY (UIN)
);

CREATE TABLE Classes (
    Class_ID INT(10) NOT NULL,
    Class_Name VARCHAR(256) NOT NULL,
    Class_Desc VARCHAR(256) NOT NULL,
    Class_Type VARCHAR(256) NOT NULL,
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
    FOREIGN KEY (UIN) REFERENCES users(UIN),
    FOREIGN KEY (Class_ID) REFERENCES Classes(Class_ID)
);
