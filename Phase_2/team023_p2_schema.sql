DROP DATABASE IF EXISTS cs6400_su19_team023;
SET default_storage_engine =InnoDB;
SET NAMES utf8mb4 COLLATE utf8mb4_unicode_ci;

CREATE DATABASE IF NOT EXISTS cs6400_su19_team023
	DEFAULT CHARACTER SET utf8mb4
	DEFAULT COLLATE utf8mb4_unicode_ci;
USE cs6400_su19_team023;

CREATE USER IF NOT EXISTS 'gpburdell'@'localhost' IDENTIFIED BY 'cs6400';

GRANT ALL PRIVILEGES ON cs6400_su19_team023.* TO 'gpburdell'@'localhost';
FLUSH PRIVILEGES;

-- TABLES

CREATE TABLE Users (
	username  varchar(80) NOT NULL,
	passwords varchar(80) NOT NULL,
	first_name varchar(100) NOT NULL,
	last_name varchar(100) NOT NULL,
	PRIMARY KEY(username)
) ;

CREATE TABLE SalesPeople (
	username  varchar(80) NOT NULL,
	PRIMARY KEY(username)
) ;

CREATE TABLE InventoryClerk (
	username  varchar(80) NOT NULL,
	PRIMARY KEY(username)
) ;

CREATE TABLE Manager (
	username  varchar(80) NOT NULL,
	PRIMARY KEY(username)
) ;

CREATE TABLE Business (
	TIN  varchar(100) NOT NULL,
	b_name varchar(200) NOT NULL,
	c_name varchar(200) NOT NULL,
	title varchar(100)  NOT NULL,
	customerID  int(16) unsigned NOT NULL,
	PRIMARY KEY(TIN),
	KEY customerID (customerID)
) ;

CREATE TABLE Individual (
	driver_license  varchar(100) NOT NULL,
	first_name varchar(100) NOT NULL,
	last_name varchar(100) NOT NULL,
	customerID  int(16) unsigned  NOT NULL,
	PRIMARY KEY(driver_license),
	KEY customerID (customerID)
) ;

CREATE TABLE Customer (
	customerID  int(16) unsigned  NOT NULL AUTO_INCREMENT,
	phone varchar(100) NOT NULL,
	email varchar(250)  NULL,
	street varchar(100) NOT NULL,
	city varchar(100) NOT NULL,
	state varchar(100) NOT NULL,
	postal_code varchar(100) NOT NULL,
	PRIMARY KEY(customerID)
) ;

CREATE TABLE SalesTransaction(
	sales_date datetime NOT NULL,
	VIN varchar(100) NOT NULL,
	customerID  int(16) unsigned NOT NULL,
	salespeople_username varchar(100) NOT NULL,
	PRIMARY KEY (sales_date , VIN, customerID),
	KEY customerID (customerID),
	KEY salespeople_username (salespeople_username),
   	KEY VIN (VIN)
);

CREATE TABLE P_transaction(
	purchase_date datetime NOT NULL,
	VIN varchar(100) NOT NULL,
	customerID  int(16) unsigned NOT NULL,
	vehicle_condition varchar(100) NOT NULL,
	kbb_price float(254,4) unsigned NOT NULL,
	inventory_clerk_username varchar(100) NOT NULL,
	PRIMARY KEY(purchase_date, VIN, customerID),
	KEY customerID (customerID),
	KEY inventory_clerk_username (inventory_clerk_username),
	KEY VIN(VIN)
);

CREATE TABLE Vehicle(
	VIN varchar(100) NOT NULL,
	model_name varchar(100) NOT NULL,
	model_year  int(11) unsigned NOT NULL,
	mileage int(16) unsigned NOT NULL,
	optional_desc varchar(300) NULL,
	type_name varchar(100) NOT NULL,
	manu_name varchar(100) NOT NULL,
	PRIMARY KEY (VIN)
);

CREATE TABLE RepairVehicle(
	VIN varchar(100) NOT NULL,
	PRIMARY KEY (VIN),
    	KEY VIN(VIN)
);

CREATE TABLE Vehicle_Color(
	VIN varchar(100) NOT NULL,
	color varchar(100) NOT NULL,
	PRIMARY KEY (VIN, color)
);

CREATE TABLE VehicleType(
	type_name varchar(100) NOT NULL,
	PRIMARY KEY(type_name)
);

CREATE TABLE Manufacturer(
	manu_name varchar(100) NOT NULL,
	PRIMARY KEY(manu_name)
);

CREATE TABLE InventoryVehicle(
	VIN varchar(100) NOT NULL,
	repair_vehicle_VIN varchar(100) NOT NULL,
	sales_price float(254,4) unsigned NOT NULL,
	inventory_clerk_username varchar(100) NOT NULL,
	PRIMARY KEY(VIN),
	KEY inventory_clerk_username (inventory_clerk_username),
	KEY repair_vehicle_VIN(repair_vehicle_VIN)
);

CREATE TABLE Repairs(
	repairID  int(16) unsigned  NOT NULL,
	start_date datetime NOT NULL,
	end_date datetime NOT NULL,
	repair_status varchar(100) NOT NULL,
	total_cost float(254,4) unsigned  NOT NULL,
	repair_description varchar(300) NOT NULL,
   	vendor_name varchar(100) NOT NULL,
    	NHTSA_recall_number varchar(100) NOT NULL,
	PRIMARY KEY (repairID),
	KEY repairID (repairID),
	KEY NHTSA_recall_number(NHTSA_recall_number),
	KEY vendor_name(vendor_name)
);

CREATE TABLE Recall(
	NHTSA_recall_number varchar(100) NOT NULL,
	manu_name varchar(100) NOT NULL,
	recall_description varchar(100) NOT NULL,
	PRIMARY KEY(NHTSA_recall_number),
	KEY manu_name(manu_name)
);

CREATE TABLE Vendor(
	vendor_name varchar(100) NOT NULL,
	vendor_phone varchar(100) NOT NULL,
	street varchar(100) NOT NULL,
	city varchar(100) NOT NULL,
	state varchar(100) NOT NULL,
	postal_code varchar(100) NOT NULL,
	PRIMARY KEY(vendor_name)
);

CREATE TABLE Determine(
	repairID int(16) unsigned NOT NULL AUTO_INCREMENT,
	VIN varchar(100) NOT NULL,
	inventory_clerk_username varchar(100) NOT NULL,
	PRIMARY KEY(repairID),
	KEY VIN(VIN),
	KEY inventory_clerk_username(inventory_clerk_username)
);

CREATE TABLE Quotes(
	vendor_name varchar(100) NOT NULL,
	repairID  int(16) unsigned NOT NULL,
	inventory_clerk_username varchar(100) NOT NULL,
	PRIMARY KEY(vendor_name, repairID),
	KEY vendor_name (vendor_name),
	KEY repairID(repairID),
	KEY inventory_clerk_username(inventory_clerk_username)
);

 -- Constraints   Foreign Keys: FK_ChildTable_childColumn_ParentTable_parentColumn

ALTER TABLE SalesPeople
  ADD CONSTRAINT fk_SalesPeople_username_Users_username FOREIGN KEY (username) REFERENCES Users (username);

ALTER TABLE InventoryClerk
  ADD CONSTRAINT fk_InventoryClerk_username_Users_username FOREIGN KEY (username) REFERENCES Users (username);

ALTER TABLE Manager
  ADD CONSTRAINT fk_Manager_username_Users_username FOREIGN KEY (username) REFERENCES Users (username);

ALTER TABLE Business
  ADD CONSTRAINT fk_Business_customerID_Customer_customerID FOREIGN KEY (customerID) REFERENCES Customer (customerID);


ALTER TABLE Individual
  ADD CONSTRAINT fk_Individual_customerID_Customer_customerID FOREIGN KEY  (customerID) REFERENCES Customer (customerID);


ALTER TABLE SalesTransaction
  ADD CONSTRAINT fk_SalesTransaction_VIN_InventoryVehicle_VIN FOREIGN KEY  (VIN) REFERENCES InventoryVehicle (VIN) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT fk_SalesTransaction_salespeople_username_SalesPeople_username FOREIGN KEY (salespeople_username) REFERENCES   SalesPeople (username) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT fk_SalesTransaction_customerID_Customer_customerID FOREIGN KEY (customerID) REFERENCES Customer (customerID) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE P_Transaction
  ADD CONSTRAINT fk_P_Transaction_VIN_Vehicle_VIN FOREIGN KEY (VIN) REFERENCES Vehicle (VIN) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT fk_P_Transaction_username_InventoryClerk_username FOREIGN KEY (inventory_clerk_username) REFERENCES InventoryClerk (username) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT fk_P_Transaction_customerID_Customer_customerID FOREIGN KEY (customerID) REFERENCES Customer (customerID) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE RepairVehicle
  ADD CONSTRAINT fk_RepairVehicle_VIN_Vehicle_VIN FOREIGN KEY (VIN) REFERENCES Vehicle (VIN); 


ALTER TABLE Vehicle_Color
  ADD CONSTRAINT fk_Vehicle_Color_VIN_Vehicle_VIN FOREIGN KEY (VIN) REFERENCES Vehicle (VIN); 


ALTER TABLE InventoryVehicle
  ADD CONSTRAINT fk_InventoryVehicle_VIN_RepairVehicle_VIN FOREIGN KEY (repair_vehicle_VIN) REFERENCES RepairVehicle (VIN),
  ADD CONSTRAINT fk_InventoryVehicle_username_InventoryClerk_username FOREIGN KEY (inventory_clerk_username) REFERENCES InventoryClerk (username);


ALTER TABLE Repairs
  ADD CONSTRAINT fk_Repairs_vendor_name_Vendor_vendor_name FOREIGN KEY (vendor_name) REFERENCES Vendor (vendor_name) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT fk_Repairs_NHTSA_recall_number_Recall_NHTSA_recall_number FOREIGN KEY (NHTSA_recall_number) REFERENCES Recall (NHTSA_recall_number) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT fk_Repairs_repairID_Determine_repairID FOREIGN KEY (repairID) REFERENCES Determine (repairID) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE Recall
  ADD CONSTRAINT fk_Recall_manu_name_Manufacturer_manu_name FOREIGN KEY (manu_name) REFERENCES Manufacturer (manu_name);

ALTER TABLE Determine
  ADD CONSTRAINT fk_Determine_VIN_RepairVehicle_VIN FOREIGN KEY (VIN) REFERENCES RepairVehicle (VIN) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT fk_Determine_inventory_clerk_username_InventoryClerk_username FOREIGN KEY (inventory_clerk_username) REFERENCES InventoryClerk (username) ON DELETE CASCADE ON UPDATE CASCADE;


ALTER TABLE Quotes
  ADD CONSTRAINT fk_Quote_vendor_name_Vendor_vendor_name FOREIGN KEY (vendor_name) REFERENCES Vendor (vendor_name),
  ADD CONSTRAINT fk_Quote_repairID_Determine_repairID FOREIGN KEY (repairID) REFERENCES Determine (repairID),
  ADD CONSTRAINT fk_Quote_inventory_clerk_username_InventoryClerk_username FOREIGN KEY (inventory_clerk_username) REFERENCES InventoryClerk (username);
