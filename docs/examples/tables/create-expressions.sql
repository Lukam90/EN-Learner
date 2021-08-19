CREATE TABLE expressions (
	id INTEGER PRIMARY KEY AUTO_INCREMENT,
	french VARCHAR(255) UNIQUE NOT NULL,
	english VARCHAR(255) UNIQUE NOT NULL,
	phonetics VARCHAR(255) UNIQUE NOT NULL,
	user_id INTEGER NOT NULL,
	theme_id INTEGER NOT NULL,
	FOREIGN KEY (user_id) REFERENCES users (id),
	FOREIGN KEY (theme_id) REFERENCES themes (id)
	ON DELETE CASCADE
);