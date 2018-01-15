CREATE TABLE articles(
    id int NOT NULL,
    title varchar(255) NOT NULL,
    alias varchar(255) NOT NULL,
    preview varchar(255) NOT NULL,
    month int(2),
    year int(4),
    publishing_date datetime NULL,
    allowed int(1) DEFAULT 0,
    PRIMARY KEY (id)
);

CREATE TABLE admin(
    id int NOT NULL,
    nickname varchar(255) NOT NULL,
    email varchar(255) NOT NULL,
    password varchar(255) NOT NULL,
    PRIMARY KEY (id)
);

CREATE TABLE admin_sessions(
    admin_id int(12) NOT NULL,
    session_id int(12) NOT NULL,
    start datetime NULL,
    ip varchar(16) NOT NULL,
    token varchar(255) NOT NULL
    PRIMARY KEY (id)
);