START TRANSACTION;

CREATE TABLE Posts (
  id CHAR(36) NOT NULL, -- UUID as string
  title VARCHAR(255) NOT NULL,
  body TEXT NOT NULL,
  created_at DATETIME NOT NULL,
  modified_at DATETIME NOT NULL,
  author CHAR(36) NOT NULL,
  PRIMARY KEY (id),
  CONSTRAINT fk_author FOREIGN KEY (author)
      REFERENCES Authors(id)
      ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

commit;
