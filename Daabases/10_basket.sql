drop table basket;
create table basket(
    id int  auto_increment,
    userId int not null,
    itemId int not null,
    quantity int default 1,
    joindate date default (current_date()),
    jointime time default (current_time()),
    primary key (id),
    foreign key (userId) references accounts(id),
    foreign key (itemId) references items(id)
);

insert into basket(userId, itemId, quantity) values(100000, 100004,2);

select * from basket;