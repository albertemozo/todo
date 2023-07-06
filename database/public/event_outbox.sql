create table event_outbox
(
    id   uuid    not null,
    type varchar not null,
    data json    not null
);

alter table event_outbox
    owner to username;

