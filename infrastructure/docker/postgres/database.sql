create table public.event_store
(
    id           serial
        constraint event_store_pk
            primary key,
    uuid         char(36)     not null,
    name         varchar(100) not null,
    aggregate_id char(36)     not null,
    occurred_on  timestamp    not null,
    payload      jsonb        not null
);

alter table public.event_store
    owner to postgres;

create table public.users
(
    id       char(36)     not null
        constraint users_pk
            primary key,
    name     varchar(40)  not null,
    email    varchar(200) not null,
    password varchar(32)  not null
);

alter table public.users
    owner to postgres;

