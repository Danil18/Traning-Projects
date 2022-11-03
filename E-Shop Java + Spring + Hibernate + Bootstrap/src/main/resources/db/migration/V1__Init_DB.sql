create table category (
    id bigint not null auto_increment,
    name varchar(255),
    sort_order bigint,
    status bit not null,
    primary key (id)
) engine=InnoDB;

create table product (
    id bigint not null auto_increment,
    brand varchar(255),
    characteristics varchar(3072),
    code bigint,
    description varchar(3072),
    main_img varchar(255),
    name varchar(255),
    price integer,
    quantity integer,
    status bit not null,
    category_id bigint,
    primary key (id)
) engine=InnoDB;

create table product_order (
    id bigint not null auto_increment,
    date datetime(6),
    product_in_order varchar(255) not null,
    status varchar(255),
    user_comment varchar(2048),
    user_id bigint,
    primary key (id)
) engine=InnoDB;

create table user_role (
    user_id bigint not null,
    roles varchar(255)
) engine=InnoDB;

create table usr (
    id bigint not null auto_increment,
    activation_code varchar(255),
    active bit not null,
    email varchar(255) not null,
    password varchar(255) not null,
    phone varchar(255) not null,
    username varchar(255) not null,
    primary key (id)
) engine=InnoDB;

alter table product
    add constraint product_category_fk
    foreign key (category_id) references category (id);

alter table product_order
    add constraint order_user_fk
    foreign key (user_id) references usr (id);

alter table user_role
    add constraint user_role_user_fk
    foreign key (user_id) references usr (id);