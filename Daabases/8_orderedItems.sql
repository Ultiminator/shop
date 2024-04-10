drop table orderedItems;
create table orderedItems(
    id int auto_increment,
    orderId int not null,
    itemId int not null,
    quantity int default 1,
    price int not null,
    primary key (id),
    foreign key (orderId) references orders(id),
    foreign key (itemId) references items(id)
);

insert into orderedItems(orderId, itemId, price) values(1, 100000, 3500);
insert into orderedItems(orderId, itemId, price) values(1, 100003, 2490);

select * from orderedItems;