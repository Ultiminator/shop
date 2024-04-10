drop table items;
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
alter table items auto_increment = 100000;

insert into items(name, rating, brand, tag, price, discount, amount) 
values ("intel core i5 11400",
       5, "intel", "processor",
       7000, 0, 100);
       
insert into items(name, rating, brand, tag, price, discount, amount) 
values ("intel core i7 11700K",
       5, "intel", "processor",
       9000, 5, 50);
       
insert into items(name, rating, brand, tag, price, discount, amount) 
values ("intel core i5 10400F",
       4, "intel", "processor",
       6000, 10, 67);
       
insert into items(name, rating, brand, tag, price, discount, amount) 
values ("MSI Z590 Torpedo",
       5, "MSI", "MotherBoard",
       7000, 40, 40);

insert into items(name, rating, brand, tag, price, discount, amount) 
values ("Crucial P2 1TB",
       4, "Crucial", "M.2 SSD",
       2500, 0, 55);
