<?php 

require_once("constants.php");

$DB["connection"]=mysqli_connect($DB["host"],$DB["username"],$DB["password"]);
if(mysqli_connect_errno())
    die(mysqli_connect_error());

if(!mysqli_query($DB['connection'],"CREATE DATABASE IF NOT EXISTS ".$DB["database"]))
    die(mysqli_errno($DB["connection"]));
if(!mysqli_query($DB['connection'],"use ".$DB["database"]))
    die(mysqli_error($DB["connection"]));


if(!mysqli_query($DB['connection'],"CREATE TABLE IF NOT EXISTS Suppliers(
  supplier_id int PRIMARY KEY AUTO_INCREMENT,
  supplier_name varchar(20) unique
);"))
    die(mysqli_error($DB["connection"]));

if(!mysqli_query($DB['connection'],"CREATE TABLE IF NOT EXISTS Items(
    item_id int PRIMARY KEY AUTO_INCREMENT,
    item_name varchar(40),
    item_cost_price double(8,2),
    item_selling_price double(8,2),
    item_mrp double(8,2),
    item_quantity int,
    supplier_id int references Suppliers ON DELETE CASCADE
    );"))
        die(mysqli_error($DB["connection"]));

if(!mysqli_query($DB['connection'],"CREATE TABLE IF NOT EXISTS QuotationsMaster(
    quotation_id int PRIMARY KEY AUTO_INCREMENT,
    supplier_id int references Suppliers  ON DELETE CASCADE,
    date date
    );"))
        die(mysqli_error($DB["connection"]));
          
if(!mysqli_query($DB['connection'],"CREATE TABLE IF NOT EXISTS QuotationsSlave(
    quotation_id int references QuotationsMaster  ON DELETE CASCADE,
    item_id int references Items  ON DELETE CASCADE,
    quantity int,
    PRIMARY KEY(quotation_id, item_id)
    );"))
        die(mysqli_error($DB["connection"]));

if(!mysqli_query($DB['connection'],"CREATE TABLE IF NOT EXISTS Employees(
   emp_id   int PRIMARY KEY AUTO_INCREMENT,
   emp_name varchar(20),
   date_of_join date,
   designation varchar(10),
   salary double(8,2),
   username varchar(20) UNIQUE,
   password varchar(20)
    );"))
        die(mysqli_error($DB["connection"]));

if(!mysqli_query($DB['connection'],"CREATE TABLE IF NOT EXISTS BillingMaster(
            bill_id   int PRIMARY KEY AUTO_INCREMENT,
            customer_name varchar(20),
            contact varchar(10),
            date date,
            type varchar(20),
            amount double(8,2)
             );"))
                 die(mysqli_error($DB["connection"]));

if(!mysqli_query($DB['connection'],"CREATE TABLE IF NOT EXISTS BillingSlave(
    bill_id   int references BillingMaster  ON DELETE CASCADE,
    item_id int references Items  ON DELETE CASCADE,
    quantity int,
    primary key(bill_id,item_id)
    );"))
        die(mysqli_error($DB["connection"]));

if(!mysqli_query($DB['connection'],"CREATE TABLE IF NOT EXISTS settings(
    gst double(5,2),
    id int
    );"))
        die(mysqli_error($DB["connection"]));

$result=mysqli_query($DB["connection"],"Select * from settings");
$row = mysqli_fetch_array($result);
$GLOBALS['gst'] = $row['gst'];

if(empty($row['gst'])){
    $GLOBALS['gst']=18;
    if(!mysqli_query($DB["connection"],"Insert into settings(id,gst) values(1,18)"))
        die(mysqli_error($DB["connection"]));
}

    

$result=mysqli_query($DB["connection"],"Select * from employees where username='admin' and password='admin'");
$row = mysqli_fetch_array($result);
if($row['username']!='admin'){
    
    if(!mysqli_query($DB["connection"],"Insert into employees(username,password) values('admin','admin')"))
        die(mysqli_error($DB["connection"]));

}

function checkFail(){
    global $DB;
    if(!empty(mysqli_errno($DB['connection']))){
        include("failed.php");
        die();
    }
}
?>