create table users
(
    id                integer not null
        constraint users_pk
            primary key autoincrement,
    first_name        text    not null,
    last_name         text,
    email_address     text    not null,
    linkedin_urn      text,
    password          text    not null,
    reset_password_id text(32)
);

create unique index users_email_first_last_index
    on users (email_address, first_name, last_name);

create unique index users_reset_password_id_uindex
    on users (reset_password_id);