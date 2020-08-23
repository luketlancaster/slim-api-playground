create table boards (
  id text not null primary key,
  description text not null,
  fa_class_name text,
  name text not null,
  uid text not null,
  created_at timestamp with time zone default now(),
  updated_at timestamp with time zone default now()
);

create index boards_uid_idx on boards (uid);

create table pins (
  id text not null,
  board_id text not null,
  image_url text not null,
  title text not null,
  uid text not null,
  constraint fk_board_id foreign key (board_id) references boards(id)
);

create index pins_board_id_idx on pins (board_id);

insert into boards values ('board1', 'the cutest creature on earth', 'fas fa-dog', 'puppies', '1j2msbzHx5Qh9SjA7MKItx8biVg1');
insert into boards values ('board2', 'i dunno whatever', 'fas fa-dog', 'things', '12345');

insert into pins values ('pin1', 'board1', 'https://luketlancaster.com/luna/luna1.jpeg', 'Baby Luna!', '1j2msbzHx5Qh9SjA7MKItx8biVg1');
insert into pins values ('pin2', 'board1', 'https://luketlancaster.com/luna/luna2.jpeg', 'Happy Luna!', '1j2msbzHx5Qh9SjA7MKItx8biVg1');
insert into pins values ('pin3', 'board1', 'https://luketlancaster.com/luna/luna3.jpeg', 'Luna wants to go aon a walk', '1j2msbzHx5Qh9SjA7MKItx8biVg1');
insert into pins values ('pin4', 'board1', 'https://luketlancaster.com/luna/luna4.jpeg', 'Luna sees a squirrel', '1j2msbzHx5Qh9SjA7MKItx8biVg1');
insert into pins values ('pin5', 'board1', 'https://luketlancaster.com/luna/luna5.jpeg', 'AHHHH', '1j2msbzHx5Qh9SjA7MKItx8biVg1');
insert into pins values ('pin6', 'board2', 'https://luketlancaster.com/luna/luna5.jpeg', 'board2Test', '12345');
insert into pins values ('pin7', 'board2', 'https://luketlancaster.com/luna/luna5.jpeg', 'board2Test', '12345');
insert into pins values ('pin8', 'board2', 'https://luketlancaster.com/luna/luna5.jpeg', 'board2Test', '1j2msbzHx5Qh9SjA7MKItx8biVg1');
