#DROP ALL TABLES IF THEY EXIST ALREADY.
DROP DATABASE IF EXISTS website_db;
CREATE DATABASE website_db;
use website_db;


CREATE TABLE artists(artist_id int(3) NOT NULL AUTO_INCREMENT,
	first_name VARCHAR(32) NOT NULL,
	middle_name VARCHAR(32) NOT NULL,
	last_name VARCHAR(32) NOT NULL,
	PRIMARY KEY(artist_id));

INSERT INTO artists(first_name,middle_name,last_name) Values("Prajwol",
"","Lamichhane");


CREATE TABLE contactus(
	contact_id int(8) UNSIGNED PRIMARY KEY NOT NULL AUTO_INCREMENT,
	first_name VARCHAR(30),
	last_name VARCHAR(30),
	email VARCHAR(50),
	message VARCHAR(360),
  	date_created datetime NOT NULL

);


CREATE TABLE  customers(
	customer_id int(5) UNSIGNED PRIMARY KEY NOT NULL AUTO_INCREMENT,
	email VARCHAR(50),
	pass VARCHAR(30)
);

CREATE TABLE employees(
	employee_id int(8) UNSIGNED PRIMARY KEY NOT NULL AUTO_INCREMENT,
	first_name VARCHAR(30),
	last_name VARCHAR(30),
	email VARCHAR(50),
	pass char(40),
	title VARCHAR(40),
	admin VARCHAR(30),
    date_created datetime NOT NULL

);


CREATE TABLE food(
	food_id int(3) UNSIGNED PRIMARY KEY NOT NULL AUTO_INCREMENT,
	food_name VARCHAR(30),
	food_type VARCHAR(30),
	food_description VARCHAR(50),
  	food_price int(255) NOT NULL

);

CREATE TABLE menu(
	menu_id int(4) UNSIGNED PRIMARY KEY NOT NULL AUTO_INCREMENT,
	food_id int(3) UNSIGNED,
	menu_name VARCHAR(30),
	price decimal(6,2),
	size VARCHAR(60),
	description VARCHAR(255),
	FOREIGN KEY (food_id) REFERENCES food(food_id)
	ON DELETE CASCADE
);

CREATE TABLE orders(
	order_id int(10) UNSIGNED PRIMARY KEY NOT NULL AUTO_INCREMENT,
	customer_id int(5) UNSIGNED,
	total decimal(10,2),
  	order_date timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
	FOREIGN KEY (customer_id) REFERENCES customers(customer_id)

);

CREATE TABLE order_contentS(
	oc_id int(10) UNSIGNED PRIMARY key NOT NULL AUTO_INCREMENT,
	order_id int(10) UNSIGNED,
	quantity tinyint(3) UNSIGNED,
	price decimal(6,2) UNSIGNED,
  	ship_date datetime DEFAULT NULL,
	FOREIGN KEY (order_id) REFERENCES orders(order_id)

	);

CREATE TABLE salary(
first_name VARCHAR(20) NOT NULL,
last_name VARCHAR(20) NOT null,
amount numeric(8,2),
employee_id int(8) UNSIGNED PRIMARY KEY NOT NULL AUTO_INCREMENT,
FOREIGN key (employee_id) REFERENCES employees(employee_id)
);

create table branch(
employee_id int(8) UNSIGNED PRIMARY KEY NOT NULL AUTO_INCREMENT,
branch VARCHAR(30) not null
);


