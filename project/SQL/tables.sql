/*
Users table
*/
CREATE TABLE IF NOT EXISTS `Users` (
    `User_ID` int(10) NOT NULL,
    `FirstName` varchar(128) NOT NULL,
    `LastName` varchar(128) NOT NULL,
    `Email` varchar(128) NOT NULL,
    `Subject` varchar(126) NOT NULL,
    `Password` varchar(126) NOT NULL,
    PRIMARY KEY (`User_ID`),
    UNIQUE KEY (`Email`)
);

/*
Tasks Table
*/
CREATE TABLE IF NOT EXISTS `Tasks` (
    `Task_ID` int(10) NOT NULL,
    `Type` varchar(128) NOT NULL,
    `Description` varchar(4096),
    `Tags` varchar(128),
    `Pages` int(255),
    `Words` int(255),
    `Preview_ID` int(10) NOT NULL,
    `Claimed` tinyint(1) NOT NULL DEFAULT FALSE,
    PRIMARY KEY (`Task_ID`),
    UNIQUE KEY (`Preview_ID`)
);
