CREATE TABLE users (
    id serial PRIMARY KEY,
    role_id smallint NOT NULL DEFAULT 1,
    email varchar(320) NOT NULL,
    name varchar(100) NOT NULL,
    password VARCHAR(255) NOT NULL,
    image_hash varchar(64),
    bio varchar(500),
    updated_at timestamptz DEFAULT CURRENT_TIMESTAMP,
    created_at timestamptz DEFAULT CURRENT_TIMESTAMP,
    deleted_at timestamptz DEFAULT NULL,
    CONSTRAINT users_email_unique UNIQUE (email)
);

CREATE TABLE users_tokens (
    hash VARCHAR(80) PRIMARY KEY,
    user_id integer NOT NULL,
    created_at timestamptz DEFAULT CURRENT_TIMESTAMP,
    expires_at timestamptz NOT NULL,
    CONSTRAINT fk_tokens_user FOREIGN KEY (user_id) REFERENCES users (id) ON DELETE CASCADE
);

CREATE INDEX idx_tokens_user_expires ON users_tokens (user_id, expires_at);

CREATE TABLE categories (
    id smallserial PRIMARY KEY,
    name varchar(50) NOT NULL,
    CONSTRAINT categories_name_unique UNIQUE (name)
);

CREATE TABLE movies (
    id serial PRIMARY KEY,
    title varchar(200) NOT NULL,
    image_hash varchar(64),
    trailer varchar(200),
    description varchar(500),
    user_id integer NOT NULL,
    created_at timestamptz DEFAULT CURRENT_TIMESTAMP,
    updated_at timestamptz DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT fk_movies_user FOREIGN KEY (user_id) REFERENCES users (id)
);

CREATE INDEX idx_movies_title ON movies (title, user_id);

CREATE TABLE movies_categories (
    movie_id integer NOT NULL,
    category_id smallint NOT NULL,
    PRIMARY KEY (movie_id, category_id),
    CONSTRAINT fk_mc_movie FOREIGN KEY (movie_id) REFERENCES movies (id) ON DELETE CASCADE,
    CONSTRAINT fk_mc_category FOREIGN KEY (category_id) REFERENCES categories (id) ON DELETE CASCADE
);

CREATE TABLE movies_reviews (
    movie_id integer NOT NULL,
    user_id integer NOT NULL,
    rate smallint NOT NULL,
    message varchar(1000),
    created_at timestamptz DEFAULT CURRENT_TIMESTAMP,
    updated_at timestamptz DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (movie_id, user_id),
    CONSTRAINT chk_rate CHECK (rate BETWEEN 1 AND 5),
    CONSTRAINT fk_reviews_movie FOREIGN KEY (movie_id) REFERENCES movies (id) ON DELETE CASCADE,
    CONSTRAINT fk_reviews_user FOREIGN KEY (user_id) REFERENCES users (id) ON DELETE CASCADE
);

CREATE INDEX idx_reviews_movie ON movies_reviews (movie_id);

CREATE INDEX idx_reviews_user ON movies_reviews (user_id);

