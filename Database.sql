drop database shop;
create database shop;
use shop;

-- create a table for items in the shop
create table items(
    id int auto_increment,
    name varchar(100) not null,
    rating int default 0,
    brand varchar(50) not null,
    tag varchar(50) not null,
    price int not null,
    discount int default 0,
    amount int not null,
    joindate date default (current_date()),
    jointime time default (current_time()),
    unique (name),
    primary key (id)
);
-- start incrementing from 100,000
alter table items auto_increment = 100000;

-- creat a table that stores images
create table images(
    id int auto_increment,
    extension varchar(10),
    itemId int not null,
    primary key (id),
    foreign key (itemId) references items(id)
);

-- a table for admins accounts
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
-- insert a default admin
insert into admins(name, email, pass, type)
values(
    'Admin',
    'admin@shop.com',
    '12345678', 0
);

-- a table for user accounts
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

-- adresses of users
create table adresses(
    id int auto_increment,
    userId int not null,
    name varchar(100) not null,
    phone varchar(30) not null,
    adress varchar(255),
    jointdate date default (current_date()),
    jointime time default (current_time()),
    primary key (id),
    foreign key (userId) references accounts(id)
);

-- orders
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

-- a table to store ordered items with reference to orders
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

-- returned items with references to orders and ordered items
create table returned(
    id int auto_increment,
    orderId int not null,
    orderedItemId int not null,
    quantity int default 1,
    stat int default 0,
    cause text not null,
    joindate date default (current_date()),
    jointime time default (current_time()),
    primary key (id),
    foreign Key (orderId) references orders(id),
    foreign key (orderedItemId) references orderedItems(id)
);

-- table to stor items in the cart of users
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

-- table to store customer support tickets or chats
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

-- table to store messages of the chats with each reply
create table chats(
    id int auto_increment,
    caseId int not null,
    msge text not null,
    imge varchar(100),
    joindate date default (current_date()),
    jointime time default (current_time()),
    reply text,
    adminId int,
    replyDate date,
    replyTime time,
    primary key (id),
    foreign key (caseId) references cases(id),
    foreign key (adminId) references admins(id)
);