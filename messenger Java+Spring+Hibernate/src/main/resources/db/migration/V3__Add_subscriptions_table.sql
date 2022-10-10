create table user_subscriptions (
    channel_id bigint not null references user (id),
    subscriber_id bigint not null references user (id),
    primary key (channel_id, subscriber_id)
) engine=InnoDB;