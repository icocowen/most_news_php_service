create database t;

use t;

create table a(
    id int primary key,
    ido int
);


create trigger at after insert on a for each row
begin
     new
end;

