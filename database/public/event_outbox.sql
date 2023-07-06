create table event_outbox
(
    id   uuid not null,
    body json not null
);

alter table event_outbox
    owner to username;

