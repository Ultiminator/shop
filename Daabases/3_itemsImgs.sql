drop table images;
create table images(
    id int auto_increment,
    extension varchar(10) not null,
    itemId int not null,
    primary key (id),
    foreign key (itemId) references items(id)
);

insert into images(itemId) values(100000);
insert into images(itemId) values(100000);
insert into images(itemId) values(100000);
insert into images(itemId) values(100000);
insert into images(itemId) values(100001);
insert into images(itemId) values(100001);
insert into images(itemId) values(100002);
insert into images(itemId) values(100002);
insert into images(itemId) values(100002);
insert into images(itemId) values(100002);
insert into images(itemId) values(100003);
insert into images(itemId) values(100003);
insert into images(itemId) values(100004);
insert into images(itemId) values(100005);