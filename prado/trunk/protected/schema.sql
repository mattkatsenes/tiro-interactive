/* create users table */
CREATE TABLE adminUsers (
	username	VARCHAR(128) NOT NULL PRIMARY KEY,
	password	VARCHAR(128) NOT NULL,
	email		VARCHAR(256)
);

/* create teacherUsers table */
CREATE TABLE teacherUsers (
	username	VARCHAR(128) NOT NULL PRIMARY KEY,
	password	VARCHAR(128) NOT NULL,
	email		VARCHAR(256)
);

/* create studentUsers table */
CREATE TABLE studentUsers (
	username	VARCHAR(128) NOT NULL PRIMARY KEY,
	password	VARCHAR(128) NOT NULL,
	teacher_id	VARCHAR(128) NOT NULL
		CONSTRAINT fk_teacher REFERENCES teacherUsers(username) ON DELETE CASCADE,
	email		VARCHAR(256)
);

/* create textItems table */
CREATE TABLE textItems (
  text_id       INTEGER NOT NULL PRIMARY KEY,
  author_id     VARCHAR(128) NOT NULL
    CONSTRAINT fk_author REFERENCES teacherUsers(username) ON DELETE CASCADE,
  title         VARCHAR(256) NOT NULL,  /* title of the text */
  status        TINYINT NOT NULL        /* 0: not_shared; 1: limited_access; 2: shared  */
);

/* create news table */
CREATE TABLE newsItems (
	item_id		INTEGER NOT NULL PRIMARY KEY,
	author_id 	VARCHAR(128) NOT NULL
		CONSTRAINT fk_author REFERENCES adminUsers(username) ON DELETE CASCADE,
	slug		TEXT,
	full_text	TEXT
);

/* insert testing users */
INSERT INTO adminUsers VALUES('admin','21232f297a57a5a743894a0e4a801fc3','psalakanthos@gmail.com');
INSERT INTO teacherUsers VALUES('teacher','8d788385431273d11e8b43bb78f3aa41','');
INSERT INTO studentUsers VALUES('student','cd73502828457d15655bbd7a63fb0bc8','teacher','');
INSERT INTO textItems VALUES(1,'teacher','Example1',0);
INSERT INTO newsItems VALUES(1,'admin','slug!','full text of news item 1.');