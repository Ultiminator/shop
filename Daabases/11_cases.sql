drop table cases;
create table cases(
    id int auto_increment,
    userId int not null,
    orderId int,
    orderedItemId int,
    about varchar(255),
    joindate date default (current_date()),
    jointime time default (current_time()),
    closed int default 0,
    cloeddate date,
    closedtime time,
    rate int default 0,
    review varchar(255),
    primary key (id),
    foreign key (userId) references accounts(id),
    foreign key (orderId) references orders(id),
    foreign key (orderedItemId) references orderedItems(id)
);

insert into cases(userId,orderId, orderedItemId, about) values(
    100000, 1, 2, 'note about the item'
);

select * from cases;