create table logs
(
    ip_address  bigint       not null,
    user_agent  varchar(255) not null,
    view_date   datetime     not null,
    image_id    int          not null,
    views_count int          not null,
    constraint idx_unique_visit
        unique (ip_address, image_id, user_agent)
);

INSERT INTO infusemedia.logs (ip_address, user_agent, view_date, image_id, views_count) VALUES (2887581697, 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/113.0.0.0 Safari/537.36', '2023-05-23 06:35:15', 1, 41);
INSERT INTO infusemedia.logs (ip_address, user_agent, view_date, image_id, views_count) VALUES (2887581697, 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/113.0.0.0 Safari/537.36', '2023-05-23 06:35:16', 2, 40);
