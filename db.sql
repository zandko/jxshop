drop table if exists jxshop.category;

create table jxshop.category
(
    id int unsigned not noll auto_increment comment 'ID',
    cat_name varchar(255) not null comment '分类名称',
    parent_id int unsigned not null default 0 comment '上级ID',
    path varchar(255) not null default '-' comment '所有上级分类',
    primary key (id)
)engine=InnoDB comment='分类表';

TRUNCATE jxshop.category;
INSERT INTO jxshop.category VALUES
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

drop table if exists jxshop.brand;
create table jxshop.brand
(
    id int unsigned not null auto_increment comment 'ID',
    brand_name varchar(255) not null comment '品牌名称',
    logo varchar(255) not null comment 'LOGO',
    primary key (id)
)engine=InnoDB comment='品牌表';

drop table if exists jxshop.goods;
create table jxshop.goods
(
    id int unsigned not null auto_increment comment 'ID',
    goods_name varchar(255) not null comment '商品名称',
    logo varchar(255) not null comment 'LOGO',
    is_on_sale enum('y','n') not null default 'y' comment '是否上架',
    description longtext not null comment '商品描述',
    cat1_id int unsigned not null comment '一级分类ID',
    cat2_id int unsigned not null comment '二级分类ID',
    cat3_id int unsigned not null comment '三级分类ID',
    brand_id int unsigned not null comment '品牌ID',
    created_at datetime not null default current_timestamp comment '添加时间',
    primary key (id)
)engine=InnoDB comment='商品表';

drop table if exists jxshop.goods_attribute;
create table jxshop.goods_attribute
(
    id int unsigned not null auto_increment comment 'ID',
    attr_name varchar(255) not null comment '属性名称',
    attr_value varchar(255) not null comment '属性值',
    goods_id int unsigned not null comment '所属的商品ID',
    primary key (id)
)engine=InnoDB comment='商品属性表';

drop table if exists jxshop.goods_image;
create table jxshop.goods_image
(
    id int unsigned not null auto_increment comment 'ID',
    goods_id int unsigned not null comment '所属的商品ID',
    path varchar(255) not null comment '图片的路径',
    primary key (id)
)engine=InnoDB comment='商品图片表';

drop table if exists jxshop.goods_sku;
create table jxshop.goods_sku
(
    id int unsigned not null auto_increment comment 'ID',
    goods_id int unsigned not null comment '所属的商品ID',
    sku_name varchar(255) not null comment 'SKU名称',
    stock int unsigned not null comment '库存量',
    price decimal(10,2) not null comment '价格',
    primary key (id)
)engine=InnoDB comment='商品SKU表';
