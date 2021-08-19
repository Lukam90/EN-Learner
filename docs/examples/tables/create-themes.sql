CREATE TABLE themes (
	id INTEGER PRIMARY KEY AUTO_INCREMENT,
    title VARCHAR(50) UNIQUE NOT NULL,
    user_id INTEGER NOT NULL,
    FOREIGN KEY (user_id) REFERENCES users (id)
    ON DELETE CASCADE
);