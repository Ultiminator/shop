drop table accounts;
create table accounts(
    id int auto_increment,
    email varchar(250) not null,
    pass varchar(30) not null,
    points int default 0,
    joindate date default (current_date()),
    jointime time default (current_time()),
    unique (email),
    primary key (id)
    
);

alter table accounts auto_increment = 100000;

insert into accounts(email, pass) values(
    'UltimateAlienForce@Outlook.com',
    '12345678'
);

insert into accounts(email, pass) values(
    'UltimateAlienForce@yahoo.com',
    '12345678'
);

insert into accounts(email, pass) values(
    'ahmed.salah.mehana@gmail.com',
    '12345678'
);

insert into accounts(email, pass) values(
    'omar.salah.mehana@gmail.com',
    '12345678'
);

select * from accounts;