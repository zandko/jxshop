drop table if exists category;

create table category
(
    id int unsigned not noll auto_increment comment 'ID',
    cat_name varchar(255) not null comment '分类名称',
    parent_id int unsigned not null default 0 comment '上级ID',
    path varchar(255) not null default '-' comment '所有上级分类',
    primary key (id)
)engine=InnoDB comment='分类表';

TRUNCATE category;
INSERT INTO category VALUES
(1,'家用电器',0,'-'),
(2,'电视',1,'-1-'),
(3,'空调',1,'-1-'),
(4,'曲面电视',2,'-1-2-'),
(5,'超薄电视',2,'-1-2-'),
(6,'柜式空调',3,'-1-3-'),
(7,'中央空调',3,'-1-3-'),
(8,'电脑',0,'-'),
(9,'电脑整机',8,'-8-'),
(10,'电脑配件',8,'-8-'),
(11,'笔记本',9,'-8-9-'),
(12,'游戏本',9,'-8-9-'),
(13,'显示器',10,'-8-10-'),
(14,'CPU',10,'-8-10-');