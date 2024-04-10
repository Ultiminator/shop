drop table chats;
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

insert into chats(caseId, msge) values(
    1, 'I want to test this massage, there is nothing wrong'
);

select * from chats;