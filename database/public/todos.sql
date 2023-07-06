create table todos
(
    id          uuid    not null
        constraint todos_pk
            primary key,
    description varchar not null
);

alter table todos
    owner to username;

