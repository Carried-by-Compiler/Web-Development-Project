/*
Courses table
*/
CREATE TABLE IF NOT EXISTS `Courses` (
	`Course_ID` int unsigned NOT NULL,
	`Name` varchar(128) NOT NULL,
	PRIMARY KEY (`Course_ID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ;

/*
Users table
*/
CREATE TABLE IF NOT EXISTS `Users` (
    `User_ID` int unsigned NOT NULL,
    `FirstName` varchar(128) NOT NULL,
    `LastName` varchar(128) NOT NULL,
    `Email` varchar(128) NOT NULL,
    `Subject` int unsigned NOT NULL,
    `Rep_Points` int DEFAULT '0',
    `Password` varchar(255) NOT NULL,
    PRIMARY KEY (`User_ID`),
    UNIQUE KEY (`Email`),
    FOREIGN KEY (`Subject`) REFERENCES `Courses`(`Course_ID`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ;

/*
Tasks table
*/
CREATE TABLE IF NOT EXISTS `Tasks` (
    `Task_ID` int unsigned NOT NULL AUTO_INCREMENT, /* Auto generates task id      */
    `Owner` int unsigned NOT NULL,                  /* References to the user's id */
    `Date_Created` datetime NOT NULL,
    `Title` varchar(255) DEFAULT NULL,
    `Type` varchar(20) DEFAULT NULL,
    `Description` text DEFAULT NULL,
    `Pages` int unsigned DEFAULT 0,
    `Words` int unsigned DEFAULT 0,
    `Format` varchar(10) DEFAULT NULL,
    `Claimant_Review` text DEFAULT NULL
    PRIMARY KEY (`Task_ID`, `Owner`),
    /* 	A user's tasks should be deleted when a user is removed
    	so that potential claimants cannot ask a non-existent user for their task 
    */
    FOREIGN KEY (`Owner`) REFERENCES `Users`(`User_ID`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ;

/*
Tags table
*/
CREATE TABLE IF NOT EXISTS `Tags` (
	`Tag_ID` int unsigned NOT NULL AUTO_INCREMENT,
	`Title` varchar(20) NOT NULL,
	`Course_ID` int unsigned NOT NULL,
	PRIMARY KEY (`Tag_ID`),
	FOREIGN KEY (`Course_ID`) REFERENCES `Courses`(`Course_ID`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ;

/*
Task_Tags table
*/
CREATE TABLE IF NOT EXISTS `Task_Tags` (
	`Task_ID` int unsigned NOT NULL,
	`Tag_ID` int unsigned NOT NULL,
	PRIMARY KEY (`Task_ID`, `Tag_ID`),
	FOREIGN KEY (`Task_ID`) REFERENCES `Tasks`(`Task_ID`) ON DELETE CASCADE ON UPDATE CASCADE,
	FOREIGN KEY (`Tag_ID`) REFERENCES `Tags`(`Tag_ID`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ;

/*
Deadlines table
*/
CREATE TABLE IF NOT EXISTS `Deadlines` (
	`Task_ID` int unsigned NOT NULL,
	`Claim_D` datetime NOT NULL,
	`Sub_D` datetime NOT NULL,
	PRIMARY KEY (`Task_ID`),
	FOREIGN KEY (`Task_ID`) REFERENCES `Tasks`(`Task_ID`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ;

/*
Task_Status table
*/
CREATE TABLE IF NOT EXISTS `Task_Status` (
	`Task_ID` int unsigned NOT NULL,
	`Status` varchar(20) NOT NULL DEFAULT 'PENDING_CLAIM',
	`Claimant` int unsigned DEFAULT NULL, /* what happens when the user deletes their profile? */
	`Rating` varchar(10) DEFAULT NULL,
	PRIMARY KEY (`Task_ID`),
	FOREIGN KEY (`Task_ID`) REFERENCES `Tasks`(`Task_ID`) ON DELETE CASCADE ON UPDATE CASCADE,
	FOREIGN KEY (`Claimant`) REFERENCES `Users`(`User_ID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ;

/*
Banned_Users
*/
CREATE TABLE IF NOT EXISTS `Banned_Users` (
	`Banned_User` int unsigned NOT NULL,
	`Banner` int unsigned NOT NULL,
	`Date_Banned` datetime NOT NULL,
	`Ban_Desc` text DEFAULT NULL,
	PRIMARY KEY(`Banned_User`),
	FOREIGN KEY (`Banned_User`) REFERENCES `Users`(`User_ID`),
	FOREIGN KEY (`Banner`) REFERENCES `Users`(`User_ID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ;

/*
Flagged_Tasks
*/
CREATE TABLE IF NOT EXISTS `Flagged_Tasks` (
	`Task_ID` int unsigned NOT NULL,
	`Flagger` int unsigned NOT NULL,
	`Flag_Desc` varchar(15) NOT NULL,
	`Review_Status` varchar(10) DEFAULT 'UNCHECKED',
	`Date_Flagged` datetime NOT NULL,
	PRIMARY KEY(`Task_ID`, `Flagger`),
	FOREIGN KEY(`Task_ID`) REFERENCES `Tasks`(`Task_ID`) ON DELETE CASCADE ON UPDATE CASCADE,
	FOREIGN KEY(`Flagger`) REFERENCES `Users`(`User_ID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ;
