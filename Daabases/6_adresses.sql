drop table adresses;
create table adresses(
    id int auto_increment,
    userId int not null,
    name varchar(100) not null,
    phone varchar(30) not null,
    country varchar(30) not null,
    state varchar(30) not null,
    city varchar(30) not null,
    street varchar(30) not null,
    adress varchar(255),
    jointdate date default (current_date()),
    jointime time default (current_time()),
    primary key (id),
    foreign key (userId) references accounts(id)
);

insert into adresses(
    userId, name, phone, country, state, city, street, adress
)values(
    100000, 'Ahmed Salah', '01016015810',
    'egypt', 'dakahlia', 'mit ghamr', 'santimay',
    'Santimay - Mit Ghamr - Dakahlia, eg'
);

insert into adresses(
    userId, name, phone, country, state, city, street, adress
)values(
    100000, 'Ahmed Salah', '01016015810',
    'Egypt', 'Dakahlia', 'Mit Ghamr', 'Santimay',
    'سنتماى - ميت غمر - الدقهلية'
);

select * from adresses;