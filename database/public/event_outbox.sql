create table event_outbox
(
    id           uuid    not null,
    data         json    not null,
    type         varchar not null,
    aggregate_id varchar not null,
    occurred_on  timestamp
);

alter table event_outbox
    owner to username;
