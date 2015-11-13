
USE test;

CREATE TABLE `news` (
	`id` INT NOT NULL AUTO_INCREMENT,
	`title` VARCHAR(200) NOT NULL,
	`url` VARCHAR(500) NOT NULL,
	`description` text NOT NULL,
	PRIMARY KEY (`id`)
)

insert into news (id,title,url,description) 
values (null,'关于phpMyAdmin免输入用户名和密码,就可直接进入管理界面的设置','https://www.baidu.com/link?url=EV7zozXW9b32JBT5OqPhnp6Zb0kqT8qcNqtTP4n_SBN3x5piEJALUlYSifY2qjyK1XDxswB90SwTXUjEw1YNurxtLm4xd_WUe06CV5HgnG_&wd=&eqid=964f62f5000053860000000556454b91','descriptionnews');

insert into news (id,title,url,description) 
values (null,'Mysql数据库中设置root密码的命令及方法 - Mysql - 网页特效代码',
'https://www.baidu.com/link?url=j5j7LClL29hYhxNW3nrKatsQFUjnCwbQWOwS093T4-5MgFMYyr9PaYjgQrufPVF9K_7tNrdUjtL4mG4OKxY5Oa&wd=&eqid=964f62f5000053860000000556454b91','descriptionnews')

insert into news (id,title,url,description) 
values (null,'Mysql修改设置root密码的命令及方法_百度经验',
'https://www.baidu.com/link?url=MBNC5clCwpBNloCoICLKuj93MVKgUZ61NKM5vBeQjdND9rS7uqSoLmJMF102Z0ekEPhCnTBQ0o1eLgI5quyTG4CkKHDYJpYScXj02W5L0di&wd=&eqid=964f62f5000053860000000556454b91','descriptionnews')