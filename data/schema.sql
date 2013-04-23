CREATE TABLE pages (
  id INT AUTO_INCREMENT NOT NULL,
  updater_id INT DEFAULT NULL,
  title VARCHAR(255) NOT NULL,
  route VARCHAR(255) NOT NULL,
  content LONGTEXT NOT NULL,
  status VARCHAR(255) NOT NULL,
  created DATETIME NOT NULL,
  updated DATETIME NOT NULL,
  INDEX IDX_2074E575E37ECFB0 (updater_id),
  PRIMARY KEY(id)
) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB;

-- Not that this references a user table called "users"
-- If your user table is called something else, make that change below
ALTER TABLE pages ADD CONSTRAINT FK_2074E575E37ECFB0 FOREIGN KEY (updater_id)
REFERENCES users (id);
