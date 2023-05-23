create table logs
(
    ip_address          bigint       not null,
    user_agent  varchar(255) not null,
    view_date   datetime     not null,
    image_id    int          not null,
    views_count int          not null,
    constraint idx_unique_visit
        unique (ip_address, image_id, user_agent)
);
