# SimpleShare
A very simple code sharing application written in PHP. I created this while I was learning PHP a few years ago. 
This application uses Procedural PHP and has a lot of bugs. I was noob that days ;-P
Will convert it to OOP soon.

How to use
---
1. Edit includes/constants.php with database constants
2. Database Schema used :
```SQL
Users (id 	int(11) PRIMARY KEY	auto_increment, 
	fullname 	varchar(100),
	username 	varchar(100),
	password 	varchar(40),
	email 	varchar(100)
);

Codes (id 	int(11) PRIMARY KEY auto_increment,
	user_id 	int(11),
	title 	varchar(255),
	name 	varchar(100),
	code 	text,
	lang 	varchar(10),
	privacy 	tinyint(1)
);
```
