create table messages
(
    id           int unsigned auto_increment
        primary key,
    username     varchar(20)                         not null,
    message      varchar(200)                        not null,
    created_time timestamp default CURRENT_TIMESTAMP null
);