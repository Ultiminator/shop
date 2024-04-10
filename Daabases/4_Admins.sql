drop table admins;
create table admins(
    id int auto_increment,
    name varchar(30) not null,
    email varchar(255) not null,
    pass varchar(30) not null,
    type int default 2,
    joindate date default (current_date()),
    jointime time default (current_time()),
    unique (name),
    primary key (id)
);

alter table admins auto_increment = 100000;

insert into admins(name, email, pass, type)
values(
    'Ahmed Salah',
    'UltimateAlienForce@Outlook.com',
    '12345678', 0
);

insert into admins(name, email, pass)
values(
    'Abdo Salah',
    'UltimateAlienForce@Outlook.com',
    '12345678'
);

insert into admins(name, email, pass, type)
values(
    'Omar Salah',
    'UltimateAlienForce@Outlook.com',
    '12345678', 1
);

select * from admins;