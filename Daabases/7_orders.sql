drop table orders;
create table orders(
    id int auto_increment,
    userId int not null,
    userName varchar(100) not null,
    adress varchar(255) not null,
    phone varchar(30),
    price int not null,
    code varchar(30),
    stat int default 0,
    joindate date default (current_date()),
    jointime time default (current_time()),
    primary key (id),
    foreign key (userId) references accounts(id)
);

insert into orders(userId, userName, adress, phone, price) values(
    100000, 'ahmed salah', 'santimay - mitghamr - dakahlia',
    '01016915810', 500
);

select * from orders;