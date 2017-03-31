INSERT INTO Courses (Course_ID, Name) VALUES
(111, 'Computer Science'),
(222, 'Engineering'),
(333, "Mathematics"),
(444, "Science"),
(555, "Law"),
(666, "Business");

INSERT INTO Tags (Title, Course_ID) VALUES
('programming', 111),
('web design', 111),
('operating systems', 111),
('software testing', 111),
('graphic design', 111),
('games development', 111),
('electronics', 222),
('mechanics', 222),
('aeronautics', 222),
('civil', 222),
('circuits', 222),
('engineering maths', 222),
('algebra', 333),
('statistics', 333),
('R', 333),
('trigonometry', 333),
('calculus', 333),
('probability', 333),
('graph theory', 333),
('physics', 444),
('chemistry', 444),
('biology', 444),
('contract law', 555),
('civil rights law', 555),
('maritime law', 555),
('criminal law', 555),
('family law', 555),
('environmental law', 555),
('money', 666),
('accountancy', 666);

/*
Sample Users
*/
INSERT INTO Users (User_ID, FirstName, LastName, Email, Subject, Password) VALUES
(15167798, 'John', 'Juele', '15167798@studentmail.ul.ie', 111, 'John1234'),
(11111111, 'Sophia', 'Colgan', '11111111@studentmail.ul.ie', 111, 'Sophia1234'),
(22222222, 'Eoghan', 'Casey', '22222222@studentmail.ul.ie', 111, 'Eoghan1234'),
(33333333, 'Donagh', 'Kelleher', '33333333@studentmail.ul.ie', 111, 'Donagh1234');