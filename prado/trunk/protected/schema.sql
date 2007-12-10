/* create users table */
CREATE TABLE users (
  username      VARCHAR(128) NOT NULL PRIMARY KEY,
  password      VARCHAR(128) NOT NULL
)

/* create posts table */
CREATE TABLE texts (
  text_id       INTEGER NOT NULL PRIMARY KEY,
  author_id     VARCHAR(128) NOT NULL
    CONSTRAINT fk_author REFERENCES users(username) ON DELETE CASCADE,
  title         VARCHAR(256) NOT NULL,  /* title of the text */
  status        INTEGER NOT NULL        /* 0: not_shared; 1: limited_access; 2: shared  */
);