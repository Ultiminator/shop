drop table returned;
create table returned(
    id int auto_increment,
    orderId int not null,
    orderedItemId int not null,
    quantity int default 1,
    stat int default 0,
    joindate date default (current_date()),
    jointime time default (current_time()),
    primary key (id),
    foreign Key (orderId) references orders(id),
    foreign key (orderedItemId) references orderedItems(id)
);

insert into returned (orderId, orderedItemId) values(1,2);

select * from returned;