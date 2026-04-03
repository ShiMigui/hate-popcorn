CREATE TABLE roles (
  id SMALLSERIAL,
  name VARCHAR(20) NOT NULL,

  PRIMARY KEY (id),
  UNIQUE (name)
);

CREATE TABLE users (
  id SERIAL,
  role_id SMALLINT NOT NULL DEFAULT 2,
  email VARCHAR(320) NOT NULL,
  name VARCHAR(100) NOT NULL,
  password VARCHAR(200) NOT NULL,
  image_hash VARCHAR(200),
  bio VARCHAR(500),
  visible BOOLEAN DEFAULT TRUE,
  created_at TIMESTAMPTZ DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMPTZ DEFAULT CURRENT_TIMESTAMP,

  PRIMARY KEY (id),
  UNIQUE (email),
  FOREIGN KEY (role_id) REFERENCES roles(id)
);

CREATE TABLE users_tokens (
  hash VARCHAR(80),
  user_id INTEGER NOT NULL,
  created_at TIMESTAMPTZ DEFAULT CURRENT_TIMESTAMP,
  expires_at TIMESTAMPTZ,

  PRIMARY KEY (hash),
  FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

CREATE INDEX idx_tokens_user_expires 
ON users_tokens (user_id, expires_at);

CREATE TABLE categories (
  id SMALLSERIAL,
  name VARCHAR(30) NOT NULL,

  PRIMARY KEY (id),
  UNIQUE (name)
);

CREATE TABLE movies (
  id SERIAL,
  title VARCHAR(200) NOT NULL,
  image_hash VARCHAR(200),
  trailer VARCHAR(200),
  description VARCHAR(500),
  user_id INTEGER,
  created_at TIMESTAMPTZ DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMPTZ DEFAULT CURRENT_TIMESTAMP,

  PRIMARY KEY (id),
  FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE SET NULL
);

CREATE TABLE movies_categories (
  movie_id INTEGER,
  category_id SMALLINT,

  PRIMARY KEY (movie_id, category_id),
  FOREIGN KEY (movie_id) REFERENCES movies(id) ON DELETE CASCADE,
  FOREIGN KEY (category_id) REFERENCES categories(id) ON DELETE CASCADE
);

CREATE TABLE movies_reviews (
  movie_id INTEGER,
  user_id INTEGER,
  rate SMALLINT NOT NULL,
  message VARCHAR(1000),
  created_at TIMESTAMPTZ DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMPTZ DEFAULT CURRENT_TIMESTAMP,

  PRIMARY KEY (movie_id, user_id),
  CHECK (rate BETWEEN 1 AND 5),
  FOREIGN KEY (movie_id) REFERENCES movies(id) ON DELETE CASCADE,
  FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);
