-- file: schema.sql
-- author: Matthew Katsenes
-- usage: to create tiro.db with initial values...
-- 	$ sqlite3 tiro.db < tiro_new.sql
-- ********************************

-- userRecords
-- This is the table holding names/passwords for authentication.
-- user data and relations are stored in the individual tables for Teachers, Students, and Admins.
CREATE TABLE IF NOT EXISTS userRecords (
	username	TEXT PRIMARY KEY,
	password	TEXT,
	role		INT		-- 0 = Admin, 1 = Teacher, 2 = Student
);

-- teacherUsers
CREATE TABLE IF NOT EXISTS teacherUsers (
	username TEXT PRIMARY KEY,
	first_name TEXT,
	middle_name TEXT,
	last_name TEXT,
	email TEXT,
	website TEXT
);

-- textItems
CREATE TABLE IF NOT EXISTS textItems (
	dir_name TEXT PRIMARY KEY,
	title TEXT,
	creation_date DATE,
	last_edit DATE,
	author_id TEXT
		CONSTRAINT author_fk REFERENCES teacherUsers(username) ON DELETE CASCADE,
	status		INT NOT NULL,        /* 0: not_shared; 1: limited_access; 2: shared  */
	plugins		TEXT
);

-- create adminUsers
CREATE TABLE adminUsers (
	username	TEXT PRIMARY KEY,
	email		TEXT,
	preferences	TEXT
);

-- create studentUsers
CREATE TABLE studentUsers (
	username	TEXT PRIMARY KEY,
	teacher_id	TEXT NOT NULL
		CONSTRAINT fk_teacher REFERENCES teacherUsers(username) ON DELETE CASCADE,
	email		TEXT,
	preferences	TEXT
);

-- create newsItems
CREATE TABLE newsItems (
	item_id		INTEGER NOT NULL PRIMARY KEY,
	author_id 	VARCHAR(128) NOT NULL
		CONSTRAINT fk_author REFERENCES adminUsers(username) ON DELETE CASCADE,
	slug		TEXT,
	full_text	TEXT
);


-- *****************
-- Much help on triggers and fk constraints from:
-- http://rcs-comp.com/site/index.php/view/Utilities-SQLite_foreign_key_trigger_generator
-- *****************

-- textItems insert creation_date, check foreign key.
CREATE TRIGGER create_text INSERT ON textItems
BEGIN
	UPDATE textItems SET creation_date = strftime("%m-%d-%Y %H:%M:%S",'now') WHERE title = new.title;
	UPDATE textItems SET last_edit = strftime("%m-%d-%Y %H:%M:%S",'now') WHERE title = new.title;
	SELECT RAISE(ROLLBACK, 'insert on table textItems violates foreign key constraint.') WHERE new.author_id IS NOT NULL AND (SELECT username FROM teacherUsers WHERE username = NEW.author_id) IS NULL;
END;

-- Foreign Key preventing update on textItems
CREATE TRIGGER update_text BEFORE UPDATE ON textItems
BEGIN
	UPDATE textItems SET last_edit = strftime("%m-%d-%Y %H:%M:%S",'now') WHERE title = new.title;
	SELECT RAISE(ROLLBACK, 'update on table textItems violates foreign key constraint')
	WHERE new.author_id IS NOT NULL AND (SELECT username FROM teacherUsers WHERE username = NEW.author_id) IS NULL;
END;

-- studentUsers check foreign key.
CREATE TRIGGER check_teacher INSERT ON studentUsers
BEGIN
	SELECT RAISE(ROLLBACK, 'insert on table studentUsers violates foreign key constraint.') WHERE new.teacher_id IS NOT NULL AND (SELECT username FROM teacherUsers WHERE username = NEW.teacher_id) IS NULL;
END;

-- Foreign Key Preventing update on studentUsers
CREATE TRIGGER update_teacher BEFORE UPDATE ON studentUsers
BEGIN
	SELECT RAISE(ROLLBACK, 'update on table studentUsers violates foreign key constraint')
	WHERE new.teacher_id IS NOT NULL AND (SELECT username FROM teacherUsers WHERE username = NEW.teacher_id) IS NULL;
END;

-- newsItems check foreign key.
CREATE TRIGGER check_news INSERT ON newsItems
BEGIN
	SELECT RAISE(ROLLBACK, 'insert on table newsItems violates foreign key constraint.') WHERE new.author_id IS NOT NULL AND (SELECT username FROM teacherUsers WHERE username = NEW.author_id) IS NULL;
END;

-- Foreign Key Preventing update on studentUsers
CREATE TRIGGER update_news BEFORE UPDATE ON newsItems
BEGIN
	SELECT RAISE(ROLLBACK, 'update on table newsItems violates foreign key constraint')
	WHERE new.author_id IS NOT NULL AND (SELECT username FROM teacherUsers WHERE username = NEW.author_id) IS NULL;
END;

-- Some Initial Data
INSERT INTO userRecords (username, password, role) VALUES ('matt','b244383da8e1b93814430dd9a77db079',1);
INSERT INTO teacherUsers (username,first_name,middle_name,last_name,email,website) VALUES ('matt','Matthew','G.','Katsenes','psalakanthos@gmail.com','http://www.tiro-interactive.org');
INSERT INTO textItems (title,author_id,status) VALUES ('worker','matt',0);
INSERT INTO userRecords (username, password, role) VALUES ('student','b244383da8e1b93814430dd9a77db079',2);
INSERT INTO studentUsers (username,teacher_id) VALUES ('student','matt');
-- ** Test case for fk constraint.
-- INSERT INTO textItems (title,author_id,status) VALUES ('failer','nobody',0);