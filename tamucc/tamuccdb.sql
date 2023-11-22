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
