-- Create database 
CREATE DATABASE IF NOT EXISTS Nicee;
USE Nicee;

-- Create Colors table
CREATE TABLE Colors (
    ColorID INT PRIMARY KEY AUTO_INCREMENT,
    ColorName VARCHAR(50)
);

-- Create Contacts table
CREATE TABLE Contacts (
    ContactID INT PRIMARY KEY AUTO_INCREMENT,
    Name VARCHAR(100),
    Email VARCHAR(100),
    Phone VARCHAR(20),
    Message TEXT
);

-- Create Sizes table
CREATE TABLE Sizes (
    SizeID INT PRIMARY KEY AUTO_INCREMENT,
    Name VARCHAR(50)
);

-- Create Users table
CREATE TABLE Users (
    UserID INT PRIMARY KEY AUTO_INCREMENT,
    FirstName VARCHAR(50),
    LastName VARCHAR(50),
    Email VARCHAR(100),
    Address VARCHAR(255),
    Password VARCHAR(100)
);

-- Create Products table
CREATE TABLE Products (
    ProductID INT PRIMARY KEY AUTO_INCREMENT,
    Price DECIMAL(10, 2),
    Name VARCHAR(255),
    Review VARCHAR(255),
    Description TEXT,
    Category VARCHAR(255)
);

-- Create ProductVariants table
CREATE TABLE ProductVariants (
    VariantID INT PRIMARY KEY AUTO_INCREMENT,
    ProductID INT,
    ColorID INT,
    SizeID INT,
    StockQuantity INT,
    Image MEDIUMBLOB,
    FOREIGN KEY (ProductID) REFERENCES Products(ProductID),
    FOREIGN KEY (ColorID) REFERENCES Colors(ColorID),
    FOREIGN KEY (SizeID) REFERENCES Sizes(SizeID)
);

-- Create Carts table
CREATE TABLE Carts (
    CartID INT PRIMARY KEY AUTO_INCREMENT,
    UserID INT,
    FOREIGN KEY (UserID) REFERENCES Users(UserID)
);

-- Create CartItems table
CREATE TABLE CartItems (
    CartItemID INT PRIMARY KEY AUTO_INCREMENT,
    CartID INT,
    VariantID INT,
    Quantity INT,
    FOREIGN KEY (CartID) REFERENCES Carts(CartID),
    FOREIGN KEY (VariantID) REFERENCES ProductVariants(VariantID)
);

-- Create Orders table
CREATE TABLE Orders (
    OrderID INT PRIMARY KEY AUTO_INCREMENT,
    UserID INT,
    OrderDate DATETIME,
    FOREIGN KEY (UserID) REFERENCES Users(UserID)
);

-- Create OrderItems table
CREATE TABLE OrderItems (
    OrderItemID INT PRIMARY KEY AUTO_INCREMENT,
    OrderID INT,
    VariantID INT,
    Quantity INT,
    FOREIGN KEY (OrderID) REFERENCES Orders(OrderID),
    FOREIGN KEY (VariantID) REFERENCES ProductVariants(VariantID)
);

-- Create Coupons table
CREATE TABLE Coupons (
    CouponID INT PRIMARY KEY AUTO_INCREMENT,
    CouponCode VARCHAR(50) UNIQUE,
    DiscountPercentage DECIMAL(5,2) 
);

--
--
--

-- Insert into Colors table
INSERT INTO Colors (ColorName) VALUES 
('Red'),
('Blue'),
('Green'),
('Yellow'),
('Black');

-- Insert into Sizes table
INSERT INTO Sizes (Name) VALUES 
('7'),
('8'),
('9'),
('10'),
('11');

-- Insert into Products table 
INSERT INTO Products (Price, Name, Review, Description, Category) VALUES
(99.99, 'Nicee Air Max 1', 'Comfortable and stylish', 'Versatile sneakers for everyday wear', 'Running Shoes'),
(129.99, 'Dunk Low Jordan', 'Great for workouts', 'Lightweight running shoes for enhanced performance', 'Boots'),
(79.99, 'Pegasus', 'Sturdy and durable', 'Fashionable boots suitable for all occasions', 'Boots'),
(59.99, 'Nicee Air Jordan 1', 'Perfect for summer', 'Casual sandals with adjustable straps', 'Sandals'),
(149.99, 'Nicee Gamma Force', 'Elegant design', 'Classic dress shoes for formal events', 'Dress Shoes');

-- Insert into ProductVariants table
-- Assuming ProductIDs, ColorIDs, and SizeIDs are valid
INSERT INTO ProductVariants (ProductID, ColorID, SizeID, StockQuantity) VALUES
(1, 1, 1, 50),
(2, 2, 2, 30),
(3, 3, 3, 40),
(4, 4, 4, 100),
(5, 5, 5, 20);

-- Insert into Users table (assuming these are registered users)
INSERT INTO Users (FirstName, LastName, Email, Address, Password) VALUES
('Emily', 'Davis', 'emily@example.com', '123 Main St, City, Country', 'password123'),
('David', 'Wilson', 'david@example.com', '456 Elm St, Town, Country', 'pass123word'),
('Sophia', 'Miller', 'sophia@example.com', '789 Oak St, Village, Country', 'securepass'),
('James', 'Taylor', 'james@example.com', '101 Pine St, Hamlet, Country', 'password456'),
('Olivia', 'Anderson', 'olivia@example.com', '202 Maple St, Suburb, Country', 'userpass');

-- Insert into Carts table (assuming each user has a cart)
INSERT INTO Carts (UserID) VALUES
(1),
(2),
(3),
(4),
(5);

-- Insert into Orders table (assuming users placed orders)
INSERT INTO Orders (UserID, OrderDate) VALUES
(1, NOW()),
(2, NOW()),
(3, NOW()),
(4, NOW()),
(5, NOW());

-- Insert into Contacts table
INSERT INTO Contacts (Name, Email, Phone, Message) VALUES
('John Doe', 'john@example.com', '123-456-7890', 'Query about shoes'),
('Alice Smith', 'alice@example.com', '987-654-3210', 'Feedback on order'),
('Bob Johnson', 'bob@example.com', '555-123-4567', 'Request for return'),
('Emma Brown', 'emma@example.com', '444-555-6666', 'Question about shipping'),
('Michael Lee', 'michael@example.com', '777-888-9999', 'General inquiry');

-- Insert into CartItems table
INSERT INTO CartItems (CartID, VariantID, Quantity) VALUES
(1, 1, 1),
(2, 3, 2),
(3, 5, 1),
(4, 2, 3),
(5, 4, 2);

-- Insert into OrderItems table
INSERT INTO OrderItems (OrderID, VariantID, Quantity) VALUES
(1, 1, 1),
(2, 3, 2),
(3, 5, 1),
(4, 2, 3),
(5, 4, 2);

-- Insert into Coupons table
INSERT INTO Coupons (CouponCode, DiscountPercentage) VALUES
('SAVE10', 10.00),
('FLASH20', 20.00),
('DEAL30', 30.00),
('SPECIAL50', 50.00),
('SALE25', 25.00);