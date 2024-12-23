-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 23, 2024 at 10:23 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `jdc warehouse`
--

DELIMITER $$
--
-- Procedures
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `InsertAccount` (IN `p_FirstName` VARCHAR(50), IN `p_LastName` VARCHAR(50), IN `p_Age` INT, IN `p_Email` VARCHAR(100), IN `p_ContactNo` VARCHAR(20), IN `p_Status` ENUM('Active','Inactive'))   BEGIN
    INSERT INTO Account (FirstName, LastName, Age, Email, ContactNo, Status)
    VALUES (p_FirstName, p_LastName, p_Age, p_Email, p_ContactNo, p_Status);
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `InsertEmployee` (IN `p_EmployeeId` VARCHAR(255), IN `p_Firstname` VARCHAR(255), IN `p_Lastname` VARCHAR(255), IN `p_Birthday` VARCHAR(255), IN `p_Age` INT(20), IN `p_Gender` VARCHAR(255), IN `p_Role` VARCHAR(255), IN `p_Salary` VARCHAR(255), IN `p_EmployeeState` VARCHAR(255), IN `p_Schedule` TEXT, IN `p_Attendance` VARCHAR(255), IN `p_TaskComplete` INT(20), IN `p_AccountId` VARCHAR(255), IN `p_Status` VARCHAR(255))   BEGIN
    INSERT INTO employee (EmployeeId, FirstName, LastName, Birthday, Age, Gender, Role, Salary, EmployeeState, Schedule, Attendance, Task_Complete, AccountId, Status) VALUES (p_EmployeeId, p_Firstname, p_Lastname, p_Birthday,p_Age, p_Gender, p_Role, p_Salary, p_EmployeeState, p_Schedule, p_Attendance, p_TaskComplete, p_AccountId, p_Status);
    
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `InsertInventory` (IN `p_id` VARCHAR(255), IN `p_quantity` INT, IN `p_location` VARCHAR(255), IN `p_status` VARCHAR(255), IN `p_employeeId` VARCHAR(255))   BEGIN
    INSERT INTO inventory (ProductId, Quantity, Location, Status, accountId)
    VALUES (p_id, p_quantity, p_location, p_status, p_employeeId);
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `InsertMessage` (IN `p_AccountId` INT, IN `p_ReceiverId` VARCHAR(50), IN `p_Message` TEXT)   BEGIN
    INSERT INTO Message (AccountId, ReceiverId, Message)
    VALUES (p_AccountId, p_ReceiverId, p_Message);
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `InsertProcessOrder` (IN `order_id` VARCHAR(255), IN `process_identity` VARCHAR(255), IN `quantity` INT, IN `product_id` VARCHAR(255), IN `employee_id` VARCHAR(255), IN `account_id` VARCHAR(255), IN `created_at` DATETIME, IN `time_start` TIME, IN `time_end` TIME, IN `process_state` VARCHAR(255))   BEGIN
    -- Insert the process order data into the process_orders table
    INSERT INTO process (`OrderId`, `Process_Identity`, `ProcessedQuantity`, `ProductId`, `EmployeeId`, `AccountId`, `DateTime`, `TimeStart`, `TimeEnd`, `ProcessState`)
    VALUES (
        order_id,
        process_identity,
        quantity,
        product_id,
        employee_id,
        account_id,
        created_at,
        time_start,
        time_end,
        process_state
    );
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `InsertProduct` (IN `p_ProductName` VARCHAR(100), IN `p_Description` TEXT)   BEGIN
    INSERT INTO Product (ProductName, Description) 
    VALUES (p_ProductName, p_Description);
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `updateaccount` (IN `accountId1` VARCHAR(255), IN `accountId2` VARCHAR(255), IN `p_Password` VARCHAR(255), IN `p_FirstName` VARCHAR(255), IN `p_LastName` VARCHAR(255), IN `p_Birthday` DATE, IN `p_Email` VARCHAR(255), IN `p_ContactNo` VARCHAR(255))   BEGIN
    UPDATE account
    SET 
        AccountId = accountId1,  
        Password = p_Password,
        FirstName = p_FirstName,
        LastName = p_LastName,
        Birthday = p_Birthday,
        Email = p_Email,
        ContactNo = p_ContactNo
    WHERE AccountId = accountId2; 
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `updateattendance` (IN `p_employeeId` VARCHAR(50), IN `p_attendance` VARCHAR(50))   BEGIN

    UPDATE manageremployeelist
    SET Attendance = p_attendance
    WHERE EmployeeId = p_employeeId;

END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `UpdateInventory` (IN `p_InventoryId` VARCHAR(50), IN `p_Quantity` INT, IN `p_Status` ENUM('Available','Reserved','Out of Stock'), IN `p_Location` VARCHAR(50))   BEGIN
    UPDATE Inventory
    SET Quantity = p_Quantity,
        Status = p_Status,
        Location = p_Location
    WHERE InventoryId = p_InventoryId;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `UpdateProcessStatus` (IN `p_processId` INT, IN `p_processState` VARCHAR(255))   BEGIN
    UPDATE process
    SET ProcessState = p_processState
    WHERE ProcessId = p_processId;
    
    IF ROW_COUNT() = 0 THEN
        SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'ProcessId not found or update failed';
    END IF;
    
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `account`
--

CREATE TABLE `account` (
  `AccountId` varchar(20) NOT NULL,
  `Password` varchar(50) NOT NULL,
  `FirstName` varchar(50) NOT NULL,
  `LastName` varchar(50) NOT NULL,
  `Birthday` date DEFAULT NULL,
  `Age` int(11) DEFAULT NULL CHECK (`Age` >= 0),
  `Email` varchar(100) NOT NULL,
  `ContactNo` varchar(15) DEFAULT NULL,
  `DateCreated` datetime DEFAULT current_timestamp(),
  `DateUpdated` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `LastLogin` datetime DEFAULT NULL,
  `Status` enum('Active','Inactive','Suspended','Temporary') DEFAULT 'Active'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `account`
--

INSERT INTO `account` (`AccountId`, `Password`, `FirstName`, `LastName`, `Birthday`, `Age`, `Email`, `ContactNo`, `DateCreated`, `DateUpdated`, `LastLogin`, `Status`) VALUES
('JL-20241124', 'Jimboy', 'Jimmy', 'Liao', '2002-09-08', 22, 'jimmymontanoliao@gmail.com', '09281477199	', '2024-12-15 19:40:56', '2024-12-23 16:33:00', '2024-12-15 19:37:21', 'Active'),
('ZY-2024102', 'Moliwas', 'Zoe', 'Yap', '2002-07-02', 22, 'zoeadmin@gmail.com', '09462478994', '2024-12-13 01:55:00', '2024-12-23 16:29:12', NULL, 'Active');

--
-- Triggers `account`
--
DELIMITER $$
CREATE TRIGGER `AccountBeforeUpdate` BEFORE UPDATE ON `account` FOR EACH ROW BEGIN
    SET NEW.DateUpdated = CURRENT_TIMESTAMP;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Stand-in structure for view `accountcategory`
-- (See below for the actual view)
--
CREATE TABLE `accountcategory` (
`AccountId` varchar(20)
,`Password` varchar(50)
,`FirstName` varchar(50)
,`LastName` varchar(50)
,`Birthday` date
,`Age` int(11)
,`Email` varchar(100)
,`ContactNo` varchar(15)
,`DateCreated` datetime
,`DateUpdated` datetime
,`LastLogin` datetime
,`Status` enum('Active','Inactive','Suspended','Temporary')
,`AccountRole` varchar(7)
);

-- --------------------------------------------------------

--
-- Table structure for table `dailyactivitysummary`
--

CREATE TABLE `dailyactivitysummary` (
  `SummaryId` int(11) NOT NULL,
  `ReportDate` date NOT NULL,
  `TotalProcesses` int(11) DEFAULT 0,
  `CompletedProcesses` int(11) DEFAULT 0,
  `PendingProcesses` int(11) DEFAULT 0,
  `InventoryUpdates` int(11) DEFAULT 0,
  `ReportGeneratedAt` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `employee`
--

CREATE TABLE `employee` (
  `EmployeeId` varchar(50) NOT NULL,
  `FirstName` varchar(50) NOT NULL,
  `LastName` varchar(50) NOT NULL,
  `Birthday` date DEFAULT NULL,
  `Age` int(11) DEFAULT NULL CHECK (`Age` > 0),
  `Gender` enum('Male','Female','Other') NOT NULL,
  `Role` varchar(50) NOT NULL,
  `Salary` decimal(10,2) DEFAULT NULL CHECK (`Salary` >= 0),
  `EmployeeState` enum('Active','Inactive','On Leave','Terminated') DEFAULT 'Active',
  `Schedule` text DEFAULT NULL,
  `Attendance` text DEFAULT NULL,
  `Task_Complete` int(20) NOT NULL,
  `AccountId` varchar(20) NOT NULL,
  `Status` enum('Application on process','Application approved','Application denied') NOT NULL,
  `DateCreated` datetime DEFAULT current_timestamp(),
  `DateUpdated` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `employee`
--

INSERT INTO `employee` (`EmployeeId`, `FirstName`, `LastName`, `Birthday`, `Age`, `Gender`, `Role`, `Salary`, `EmployeeState`, `Schedule`, `Attendance`, `Task_Complete`, `AccountId`, `Status`, `DateCreated`, `DateUpdated`) VALUES
('JM-20240825', 'Jimmy', 'Montoya', '2002-07-02', 22, 'Male', 'General Labourer ', 4000.00, 'Active', 'Monday, tueday, wednesday', 'absent', 11, 'JL-20241124', 'Application on process', '2024-12-15 12:13:09', '2024-12-23 17:20:23');

--
-- Triggers `employee`
--
DELIMITER $$
CREATE TRIGGER `UpdateEmployeeState` BEFORE UPDATE ON `employee` FOR EACH ROW BEGIN
    SET NEW.DateUpdated = CURRENT_TIMESTAMP;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Stand-in structure for view `employeeaccountsummary`
-- (See below for the actual view)
--
CREATE TABLE `employeeaccountsummary` (
`EmployeeId` varchar(50)
,`EmployeeFirstName` varchar(50)
,`EmployeeLastName` varchar(50)
,`Role` varchar(50)
,`Salary` decimal(10,2)
,`EmployeeState` enum('Active','Inactive','On Leave','Terminated')
,`AccountId` varchar(20)
,`Status` enum('Application on process','Application approved','Application denied')
);

-- --------------------------------------------------------

--
-- Table structure for table `inventory`
--

CREATE TABLE `inventory` (
  `InventoryId` int(50) NOT NULL,
  `ProductId` varchar(20) NOT NULL,
  `Quantity` int(11) NOT NULL CHECK (`Quantity` >= 0),
  `Location` text NOT NULL,
  `Status` enum('Available','Reserved','Out of Stock') DEFAULT 'Available',
  `AccountId` varchar(20) NOT NULL,
  `DateUpdated` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `inventory`
--

INSERT INTO `inventory` (`InventoryId`, `ProductId`, `Quantity`, `Location`, `Status`, `AccountId`, `DateUpdated`) VALUES
(1, 'ST-20242245', 110, 'Television Zone, T1-B1-01', 'Available', 'JL-20241124', '2024-12-23 13:41:51');

--
-- Triggers `inventory`
--
DELIMITER $$
CREATE TRIGGER `CheckCriticalSupplyLevel` BEFORE INSERT ON `inventory` FOR EACH ROW BEGIN
    DECLARE critical_level INT DEFAULT 10;
   
    IF NEW.Quantity < critical_level THEN
        SIGNAL SQLSTATE '45000'
        SET MESSAGE_TEXT = 'Inventory quantity is below critical supply level!';
    END IF;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `UpdateInventoryStatus` BEFORE UPDATE ON `inventory` FOR EACH ROW BEGIN
    IF NEW.Quantity > 0 THEN
        SET NEW.Status = 'Available';
    ELSEIF NEW.Quantity = 0 THEN
        SET NEW.Status = 'Out of Stock';
    END IF;

    SET NEW.DateUpdated = CURRENT_TIMESTAMP;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Stand-in structure for view `inventorysummary`
-- (See below for the actual view)
--
CREATE TABLE `inventorysummary` (
`ProductId` varchar(20)
,`ProductName` varchar(100)
,`Description` text
,`Quantity` int(11)
,`Status` enum('Available','Reserved','Out of Stock')
,`AccountId` varchar(20)
,`DateUpdated` datetime
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `manageremployeelist`
-- (See below for the actual view)
--
CREATE TABLE `manageremployeelist` (
`ManagerFirstName` varchar(50)
,`ManagerLastName` varchar(50)
,`EmployeeId` varchar(50)
,`FirstName` varchar(50)
,`LastName` varchar(50)
,`Birthday` date
,`Age` int(11)
,`Gender` enum('Male','Female','Other')
,`Role` varchar(50)
,`Salary` decimal(10,2)
,`EmployeeState` enum('Active','Inactive','On Leave','Terminated')
,`Attendance` text
,`Task_Complete` int(20)
,`AccountId` varchar(20)
,`DateCreated` datetime
,`DateUpdated` datetime
);

-- --------------------------------------------------------

--
-- Table structure for table `message`
--

CREATE TABLE `message` (
  `MessageId` int(11) NOT NULL,
  `AccountId` varchar(20) NOT NULL,
  `ReceiverId` varchar(50) NOT NULL,
  `Message` text NOT NULL,
  `DateTime` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `message`
--

INSERT INTO `message` (`MessageId`, `AccountId`, `ReceiverId`, `Message`, `DateTime`) VALUES
(1, 'JL-20241124', 'ZY-2024101', 'Hello World!', '2024-12-20 11:11:44'),
(2, 'JL-20241124', 'ZY-2024101', 'Good day Admin, Merong akong kailangan ipasok na product, Pwede pa add nun sa data ng warehouse ko?\r\n', '2024-12-20 16:42:06');

--
-- Triggers `message`
--
DELIMITER $$
CREATE TRIGGER `SetMessageTime` BEFORE INSERT ON `message` FOR EACH ROW BEGIN
    IF NEW.DateTime IS NULL THEN
        SET NEW.DateTime = CURRENT_TIMESTAMP;
    END IF;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Stand-in structure for view `messagesummary`
-- (See below for the actual view)
--
CREATE TABLE `messagesummary` (
`MessageId` int(11)
,`Message` text
,`DateTime` datetime
,`SenderAccountId` varchar(20)
,`SenderFirstName` varchar(50)
,`SenderLastName` varchar(50)
,`ReceiverAccountId` varchar(20)
,`ReceiverFirstName` varchar(50)
,`ReceiverLastName` varchar(50)
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `orderlist`
-- (See below for the actual view)
--
CREATE TABLE `orderlist` (
`FirstName` varchar(50)
,`LastName` varchar(50)
,`ProductId` varchar(20)
,`ProductName` varchar(100)
,`ProcessId` int(11)
,`OrderId` varchar(20)
,`Process_Identity` enum('Resupply','Release')
,`ProcessedQuantity` int(20)
,`ProcessProductId` varchar(50)
,`EmployeeId` varchar(50)
,`AccountId` varchar(20)
,`ProcessState` enum('In Progress','Completed','Canceled','Late')
,`DateTime` datetime
,`TimeStart` time
,`TimeEnd` time
);

-- --------------------------------------------------------

--
-- Table structure for table `process`
--

CREATE TABLE `process` (
  `ProcessId` int(11) NOT NULL,
  `OrderId` varchar(20) NOT NULL,
  `Process_Identity` enum('Resupply','Release') NOT NULL,
  `ProcessedQuantity` int(20) NOT NULL,
  `ProductId` varchar(50) NOT NULL,
  `EmployeeId` varchar(50) NOT NULL,
  `AccountId` varchar(20) NOT NULL,
  `ProcessState` enum('In Progress','Completed','Canceled','Late') DEFAULT 'In Progress',
  `DateTime` datetime NOT NULL DEFAULT current_timestamp(),
  `TimeStart` time NOT NULL,
  `TimeEnd` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `process`
--

INSERT INTO `process` (`ProcessId`, `OrderId`, `Process_Identity`, `ProcessedQuantity`, `ProductId`, `EmployeeId`, `AccountId`, `ProcessState`, `DateTime`, `TimeStart`, `TimeEnd`) VALUES
(1, 'RLJLST-20242245', 'Release', 20, 'ST-20242245', 'JM-20240825', 'JL-20241124', 'Completed', '2024-12-23 06:41:39', '14:00:00', '04:00:00');

--
-- Triggers `process`
--
DELIMITER $$
CREATE TRIGGER `ArchiveAndUpdateInventoryOnProcess` AFTER UPDATE ON `process` FOR EACH ROW BEGIN
    DECLARE Number1 INT;  
    DECLARE Number2 INT; 
    DECLARE Number3 INT; 

    IF NEW.ProcessState = 'Completed' THEN
        INSERT INTO processtaskcomplete (ProcessId, Process_Identity, ProductId, Process_State, DateTime, ProcessedQuantity)
        VALUES (OLD.ProcessId, OLD.Process_Identity, OLD.ProductId, OLD.ProcessState, OLD.DateTime, OLD.ProcessedQuantity);

        IF NEW.Process_Identity = 'Release' THEN
            SELECT Quantity INTO Number1
            FROM Inventory
            WHERE ProductId = NEW.ProductId;
            SET Number2 = NEW.ProcessedQuantity;
            SET Number3 = Number1 - Number2;
            IF Number3 >= 0 THEN
                UPDATE Inventory
                SET Quantity = Number3
                WHERE ProductId = NEW.ProductId;
            END IF;

        ELSEIF NEW.Process_Identity = 'Resupply' THEN
            SELECT Quantity INTO Number1
            FROM Inventory
            WHERE ProductId = NEW.ProductId;
            SET Number2 = NEW.ProcessedQuantity;
            SET Number3 = Number1 + Number2;
            UPDATE Inventory
            SET Quantity = Number3
            WHERE ProductId = NEW.ProductId;
        END IF;

    END IF;

END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `update_employee_salary` AFTER UPDATE ON `process` FOR EACH ROW BEGIN
    DECLARE CurrentSalary INT;  
    DECLARE TaskCount INT; 
    DECLARE UpdatedSalary INT;  

    IF NEW.ProcessState = 'Completed' THEN
        INSERT INTO task_table (Process_Id, Employee_Id, Salary, TaskCompletion)
        VALUES (
            OLD.ProcessId,
            OLD.EmployeeId, 
            (SELECT Salary FROM employee WHERE EmployeeId = OLD.EmployeeId LIMIT 1), 
            (SELECT Task_Complete FROM employee WHERE EmployeeId = OLD.EmployeeId LIMIT 1)
        );

        SELECT Salary INTO CurrentSalary
        FROM employee
        WHERE EmployeeId = OLD.EmployeeId;

        SELECT TaskCompletion INTO TaskCount
        FROM task_table
        WHERE Employee_Id = OLD.EmployeeId
        LIMIT 1;

        SET TaskCount = TaskCount + 1;
        SET UpdatedSalary = CurrentSalary + (500);

        IF UpdatedSalary >= CurrentSalary THEN
            UPDATE employee
            SET Salary = UpdatedSalary,
                Task_Complete = TaskCount
            WHERE EmployeeId = OLD.EmployeeId;
        END IF;
    END IF;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `processarchieve`
--

CREATE TABLE `processarchieve` (
  `ProcessId` int(11) NOT NULL,
  `OrderId` int(11) NOT NULL,
  `Process_Identity` varchar(255) NOT NULL,
  `ProcessedQuantity` int(11) NOT NULL,
  `ProductId` int(11) NOT NULL,
  `EmployeeId` int(11) NOT NULL,
  `AccountId` int(11) NOT NULL,
  `ProcessState` varchar(50) NOT NULL,
  `DateTime` timestamp NOT NULL DEFAULT current_timestamp(),
  `TimeStart` time NOT NULL,
  `TimeEnd` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `processtaskcomplete`
--

CREATE TABLE `processtaskcomplete` (
  `ProcessId` int(11) DEFAULT NULL,
  `Process_Identity` varchar(50) DEFAULT NULL,
  `ProductId` varchar(50) NOT NULL,
  `ProcessedQuantity` int(11) DEFAULT NULL,
  `Process_State` varchar(50) DEFAULT NULL,
  `DateTime` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `processtaskcomplete`
--

INSERT INTO `processtaskcomplete` (`ProcessId`, `Process_Identity`, `ProductId`, `ProcessedQuantity`, `Process_State`, `DateTime`) VALUES
(1, 'Resupply', 'ST-20242245', 10, 'In Progress', '2024-12-16 01:49:59'),
(1, 'Resupply', 'ST-20242245', 10, 'Completed', '2024-12-16 01:49:59'),
(1, 'Resupply', 'ST-20242245', 10, 'Completed', '2024-12-16 01:49:59'),
(1, 'Resupply', 'ST-20242245', 10, 'Completed', '2024-12-16 01:49:59'),
(2, 'Release', 'ST-20242245', 20, 'In Progress', '2024-12-22 09:45:53'),
(2, 'Release', 'ST-20242245', 20, 'Completed', '2024-12-22 09:45:53'),
(2, 'Release', 'ST-20242245', 20, 'Completed', '2024-12-22 09:45:53'),
(3, 'Resupply', 'ST-20242245', 20, 'In Progress', '2024-12-22 09:47:28'),
(3, 'Resupply', 'ST-20242245', 20, 'Completed', '2024-12-22 09:47:28'),
(4, 'Resupply', 'ST-20242245', 20, 'In Progress', '2024-12-22 09:49:05'),
(4, 'Resupply', 'ST-20242245', 20, 'Completed', '2024-12-22 09:49:05'),
(5, 'Release', 'ST-20242245', 20, 'In Progress', '2024-12-22 09:50:41'),
(5, 'Release', 'ST-20242245', 20, 'Completed', '2024-12-22 09:50:41'),
(1, 'Release', 'ST-20242245', 20, 'In Progress', '2024-12-22 22:41:39'),
(1, 'Release', 'ST-20242245', 20, 'Completed', '2024-12-22 22:41:39');

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

CREATE TABLE `product` (
  `ProductId` varchar(20) NOT NULL,
  `ProductName` varchar(100) NOT NULL,
  `Description` text DEFAULT NULL,
  `Date Entry` datetime NOT NULL DEFAULT current_timestamp(),
  `DateUpdated` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `product`
--

INSERT INTO `product` (`ProductId`, `ProductName`, `Description`, `Date Entry`, `DateUpdated`) VALUES
('ST-20242245', 'Samsung Smart TV', 'Television', '2024-12-15 19:57:51', '2024-12-15 19:57:51');

--
-- Triggers `product`
--
DELIMITER $$
CREATE TRIGGER `UpdateProductDateEntry` BEFORE UPDATE ON `product` FOR EACH ROW BEGIN
    SET NEW.DateUpdated = CURRENT_TIMESTAMP;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `task_table`
--

CREATE TABLE `task_table` (
  `Process_Id` varchar(50) DEFAULT NULL,
  `Employee_Id` varchar(50) DEFAULT NULL,
  `Salary` decimal(10,0) DEFAULT NULL,
  `TaskCompletion` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `task_table`
--

INSERT INTO `task_table` (`Process_Id`, `Employee_Id`, `Salary`, `TaskCompletion`) VALUES
('3', 'JM-20240825', 35500, 10),
('3', 'JM-20240825', 36000, 11),
('4', 'JM-20240825', 36500, 12),
('4', 'JM-20240825', 37000, 13),
('5', 'JM-20240825', 37500, 14),
('5', 'JM-20240825', 38000, 11),
('1', 'JM-20240825', 3000, 0),
('1', 'JM-20240825', 3500, 11);

-- --------------------------------------------------------

--
-- Structure for view `accountcategory`
--
DROP TABLE IF EXISTS `accountcategory`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `accountcategory`  AS SELECT `account`.`AccountId` AS `AccountId`, `account`.`Password` AS `Password`, `account`.`FirstName` AS `FirstName`, `account`.`LastName` AS `LastName`, `account`.`Birthday` AS `Birthday`, `account`.`Age` AS `Age`, `account`.`Email` AS `Email`, `account`.`ContactNo` AS `ContactNo`, `account`.`DateCreated` AS `DateCreated`, `account`.`DateUpdated` AS `DateUpdated`, `account`.`LastLogin` AS `LastLogin`, `account`.`Status` AS `Status`, CASE WHEN octet_length(substr(`account`.`AccountId`,3)) = 8 THEN 'Admin' WHEN octet_length(substr(`account`.`AccountId`,3)) > 8 THEN 'Manager' ELSE 'Invalid' END AS `AccountRole` FROM `account` ;

-- --------------------------------------------------------

--
-- Structure for view `employeeaccountsummary`
--
DROP TABLE IF EXISTS `employeeaccountsummary`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `employeeaccountsummary`  AS SELECT `e`.`EmployeeId` AS `EmployeeId`, `e`.`FirstName` AS `EmployeeFirstName`, `e`.`LastName` AS `EmployeeLastName`, `e`.`Role` AS `Role`, `e`.`Salary` AS `Salary`, `e`.`EmployeeState` AS `EmployeeState`, `a`.`AccountId` AS `AccountId`, `e`.`Status` AS `Status` FROM (`employee` `e` join `account` `a` on(`e`.`AccountId` = `a`.`AccountId`)) ;

-- --------------------------------------------------------

--
-- Structure for view `inventorysummary`
--
DROP TABLE IF EXISTS `inventorysummary`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `inventorysummary`  AS SELECT `inventory`.`ProductId` AS `ProductId`, `product`.`ProductName` AS `ProductName`, `product`.`Description` AS `Description`, `inventory`.`Quantity` AS `Quantity`, `inventory`.`Status` AS `Status`, `inventory`.`AccountId` AS `AccountId`, `inventory`.`DateUpdated` AS `DateUpdated` FROM (`inventory` join `product` on(`inventory`.`ProductId` = `product`.`ProductId`)) ;

-- --------------------------------------------------------

--
-- Structure for view `manageremployeelist`
--
DROP TABLE IF EXISTS `manageremployeelist`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `manageremployeelist`  AS SELECT `account`.`FirstName` AS `ManagerFirstName`, `account`.`LastName` AS `ManagerLastName`, `employee`.`EmployeeId` AS `EmployeeId`, `employee`.`FirstName` AS `FirstName`, `employee`.`LastName` AS `LastName`, `employee`.`Birthday` AS `Birthday`, `employee`.`Age` AS `Age`, `employee`.`Gender` AS `Gender`, `employee`.`Role` AS `Role`, `employee`.`Salary` AS `Salary`, `employee`.`EmployeeState` AS `EmployeeState`, `employee`.`Attendance` AS `Attendance`, `employee`.`Task_Complete` AS `Task_Complete`, `employee`.`AccountId` AS `AccountId`, `employee`.`DateCreated` AS `DateCreated`, `employee`.`DateUpdated` AS `DateUpdated` FROM (`employee` join `account` on(`employee`.`AccountId` = `account`.`AccountId`)) ;

-- --------------------------------------------------------

--
-- Structure for view `messagesummary`
--
DROP TABLE IF EXISTS `messagesummary`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `messagesummary`  AS SELECT `m`.`MessageId` AS `MessageId`, `m`.`Message` AS `Message`, `m`.`DateTime` AS `DateTime`, `a1`.`AccountId` AS `SenderAccountId`, `a1`.`FirstName` AS `SenderFirstName`, `a1`.`LastName` AS `SenderLastName`, `a2`.`AccountId` AS `ReceiverAccountId`, `a2`.`FirstName` AS `ReceiverFirstName`, `a2`.`LastName` AS `ReceiverLastName` FROM ((`message` `m` join `account` `a1` on(`m`.`AccountId` = `a1`.`AccountId`)) join `account` `a2` on(`m`.`ReceiverId` = `a2`.`AccountId`)) ;

-- --------------------------------------------------------

--
-- Structure for view `orderlist`
--
DROP TABLE IF EXISTS `orderlist`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `orderlist`  AS SELECT `a`.`FirstName` AS `FirstName`, `a`.`LastName` AS `LastName`, `p`.`ProductId` AS `ProductId`, `p`.`ProductName` AS `ProductName`, `pr`.`ProcessId` AS `ProcessId`, `pr`.`OrderId` AS `OrderId`, `pr`.`Process_Identity` AS `Process_Identity`, `pr`.`ProcessedQuantity` AS `ProcessedQuantity`, `pr`.`ProductId` AS `ProcessProductId`, `pr`.`EmployeeId` AS `EmployeeId`, `pr`.`AccountId` AS `AccountId`, `pr`.`ProcessState` AS `ProcessState`, `pr`.`DateTime` AS `DateTime`, `pr`.`TimeStart` AS `TimeStart`, `pr`.`TimeEnd` AS `TimeEnd` FROM ((`process` `pr` join `product` `p` on(`pr`.`ProductId` = `p`.`ProductId`)) join `account` `a` on(`pr`.`AccountId` = `a`.`AccountId`)) ;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `account`
--
ALTER TABLE `account`
  ADD PRIMARY KEY (`AccountId`),
  ADD UNIQUE KEY `Email` (`Email`);

--
-- Indexes for table `dailyactivitysummary`
--
ALTER TABLE `dailyactivitysummary`
  ADD PRIMARY KEY (`SummaryId`);

--
-- Indexes for table `employee`
--
ALTER TABLE `employee`
  ADD PRIMARY KEY (`EmployeeId`),
  ADD KEY `AccountId` (`AccountId`);

--
-- Indexes for table `inventory`
--
ALTER TABLE `inventory`
  ADD PRIMARY KEY (`InventoryId`),
  ADD KEY `ProductId` (`ProductId`),
  ADD KEY `LocationId` (`Location`(768)),
  ADD KEY `AccountId` (`AccountId`);

--
-- Indexes for table `message`
--
ALTER TABLE `message`
  ADD PRIMARY KEY (`MessageId`),
  ADD KEY `AccountId` (`AccountId`);

--
-- Indexes for table `process`
--
ALTER TABLE `process`
  ADD PRIMARY KEY (`ProcessId`),
  ADD KEY `InventoryId` (`ProductId`),
  ADD KEY `EmployeeId` (`EmployeeId`),
  ADD KEY `AccountId` (`AccountId`);

--
-- Indexes for table `processarchieve`
--
ALTER TABLE `processarchieve`
  ADD PRIMARY KEY (`ProcessId`);

--
-- Indexes for table `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`ProductId`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `dailyactivitysummary`
--
ALTER TABLE `dailyactivitysummary`
  MODIFY `SummaryId` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `inventory`
--
ALTER TABLE `inventory`
  MODIFY `InventoryId` int(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `message`
--
ALTER TABLE `message`
  MODIFY `MessageId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `process`
--
ALTER TABLE `process`
  MODIFY `ProcessId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `inventory`
--
ALTER TABLE `inventory`
  ADD CONSTRAINT `inventory_ibfk_1` FOREIGN KEY (`ProductId`) REFERENCES `product` (`ProductId`),
  ADD CONSTRAINT `inventory_ibfk_3` FOREIGN KEY (`AccountId`) REFERENCES `account` (`AccountId`);

--
-- Constraints for table `message`
--
ALTER TABLE `message`
  ADD CONSTRAINT `message_ibfk_1` FOREIGN KEY (`AccountId`) REFERENCES `account` (`AccountId`) ON DELETE CASCADE;

--
-- Constraints for table `process`
--
ALTER TABLE `process`
  ADD CONSTRAINT `process_ibfk_2` FOREIGN KEY (`EmployeeId`) REFERENCES `employee` (`EmployeeId`) ON DELETE CASCADE,
  ADD CONSTRAINT `process_ibfk_3` FOREIGN KEY (`AccountId`) REFERENCES `account` (`AccountId`) ON DELETE CASCADE;

DELIMITER $$
--
-- Events
--
CREATE DEFINER=`root`@`localhost` EVENT `UpdateInventoryStatus` ON SCHEDULE EVERY 1 DAY STARTS '2024-12-14 00:00:00' ON COMPLETION NOT PRESERVE ENABLE DO BEGIN
   
    UPDATE Inventory
    SET Status = CASE
                    WHEN Quantity > 0 THEN 'In Stock'
                    ELSE 'Out of Stock'
                 END;
END$$

CREATE DEFINER=`root`@`localhost` EVENT `capitalize_account_ids` ON SCHEDULE EVERY 5 SECOND STARTS '2024-12-15 11:30:39' ON COMPLETION NOT PRESERVE ENABLE DO BEGIN
    -- Update AccountIds in the table
    UPDATE account
    SET AccountId = CONCAT(
        UPPER(SUBSTRING(AccountId, 1, 1)),
        UPPER(SUBSTRING(AccountId, 2, 1)),
        SUBSTRING(AccountId, 3)
    )
    WHERE AccountId REGEXP '^[a-z]{2}.*'; -- Only update rows where the first two chars are lowercase
 UPDATE employee
    SET AccountId = CONCAT(
        UPPER(SUBSTRING(AccountId, 1, 1)),
        UPPER(SUBSTRING(AccountId, 2, 1)),
        SUBSTRING(AccountId, 3)
    )
    WHERE AccountId REGEXP '^[a-z]{2}.*';
 UPDATE employee
    SET EmployeeId = CONCAT(
        UPPER(SUBSTRING(EmployeeId, 1, 1)),
        UPPER(SUBSTRING(EmployeeId, 2, 1)),
        SUBSTRING(EmployeeId, 3)
    )
    WHERE EmployeeId REGEXP '^[a-z]{2}.*';
END$$

CREATE DEFINER=`root`@`localhost` EVENT `capitalize_first_name` ON SCHEDULE EVERY 5 SECOND STARTS '2024-12-15 11:39:06' ON COMPLETION NOT PRESERVE ENABLE DO BEGIN
    UPDATE employee
    SET FirstName = CONCAT(
        UPPER(SUBSTRING(FirstName, 1, 1)), -- Capitalize the first character
        SUBSTRING(FirstName, 2) -- Preserve the rest of the string starting from the second character
    )
    WHERE FirstName REGEXP '^[a-z].*'; -- Match rows where the first character is lowercase
UPDATE account
    SET FirstName = CONCAT(
        UPPER(SUBSTRING(FirstName, 1, 1)), -- Capitalize the first character
        SUBSTRING(FirstName, 2) -- Preserve the rest of the string starting from the second character
    )
    WHERE FirstName REGEXP '^[a-z].*'; --
END$$

CREATE DEFINER=`root`@`localhost` EVENT `capitalize_last_name` ON SCHEDULE EVERY 5 SECOND STARTS '2024-12-15 11:59:53' ON COMPLETION NOT PRESERVE ENABLE DO BEGIN
    UPDATE account
    SET LastName = CONCAT(
        UPPER(SUBSTRING(LastName, 1, 1)),
        SUBSTRING(LastName, 2)
    )
    WHERE LastName REGEXP BINARY '^[a-z].*';
 UPDATE employee
    SET LastName = CONCAT(
        UPPER(SUBSTRING(LastName, 1, 1)),
        SUBSTRING(LastName, 2)
    )
    WHERE LastName REGEXP BINARY '^[a-z].*';
END$$

CREATE DEFINER=`root`@`localhost` EVENT `delete_temporary_accounts` ON SCHEDULE EVERY 5 SECOND STARTS '2024-12-15 12:30:11' ENDS '2025-01-12 11:10:26' ON COMPLETION NOT PRESERVE ENABLE DO BEGIN
    DELETE FROM account
    WHERE status = 'temporary';
END$$

CREATE DEFINER=`root`@`localhost` EVENT `archive_completed_processes` ON SCHEDULE EVERY 1 DAY STARTS '2024-12-15 12:52:48' ON COMPLETION NOT PRESERVE ENABLE DO BEGIN
    -- Insert completed or old processes into the archive table
    INSERT INTO process_archive
    SELECT *
    FROM process
    WHERE ProcessState = 'Completed' AND `Date&Time` < NOW() - INTERVAL 30 DAY;

    -- Delete archived records from the original table
    DELETE FROM process
    WHERE ProcessState = 'Completed' AND `Date&Time` < NOW() - INTERVAL 30 DAY;
END$$

CREATE DEFINER=`root`@`localhost` EVENT `delete_expired_messages` ON SCHEDULE EVERY 1 DAY STARTS '2024-12-15 13:01:28' ON COMPLETION NOT PRESERVE ENABLE DO BEGIN
    DELETE FROM message
    WHERE DateTime < NOW() - INTERVAL 30 DAY; -- Delete messages older than 30 days
END$$

CREATE DEFINER=`root`@`localhost` EVENT `reset_employee_attendance` ON SCHEDULE EVERY 1 DAY STARTS '2024-12-15 13:07:41' ON COMPLETION NOT PRESERVE ENABLE DO BEGIN
    -- Reset Attendance for all employees
    UPDATE Employee
    SET Attendance = NULL
    WHERE EmployeeState = 'Active'; -- Reset only for active employees
END$$

CREATE DEFINER=`root`@`localhost` EVENT `inactive_account_cleanup` ON SCHEDULE EVERY 1 DAY STARTS '2024-12-15 13:10:24' ON COMPLETION NOT PRESERVE ENABLE DO BEGIN
    -- Mark accounts as Inactive if LastLogin is older than 1 week
    UPDATE Account
    SET Status = 'Inactive'
    WHERE LastLogin < NOW() - INTERVAL 7 DAY
      AND Status = 'Active'; -- Only update currently active accounts
END$$

CREATE DEFINER=`root`@`localhost` EVENT `daily_activity_summary` ON SCHEDULE EVERY 1 DAY STARTS '2024-12-15 13:23:29' ON COMPLETION NOT PRESERVE ENABLE DO BEGIN
    DECLARE total_processes INT;
    DECLARE completed_processes INT;
    DECLARE pending_processes INT;
    DECLARE inventory_updates INT;

    -- Summarize daily processes
    SELECT COUNT(*) INTO total_processes
    FROM Process
    WHERE DATE(Date&Time) = CURRENT_DATE;

    SELECT COUNT(*) INTO completed_processes
    FROM Process
    WHERE ProcessState = 'Completed' AND DATE(Date&Time) = CURRENT_DATE;

    SELECT COUNT(*) INTO pending_processes
    FROM Process
    WHERE ProcessState = 'Pending' AND DATE(Date&Time) = CURRENT_DATE;

    -- Summarize daily inventory updates
    SELECT COUNT(*) INTO inventory_updates
    FROM Inventory
    WHERE DATE(DateUpdated) = CURRENT_DATE;

    -- Insert the summary into the DailyActivitySummary table
    INSERT INTO DailyActivitySummary (ReportDate, TotalProcesses, CompletedProcesses, PendingProcesses, InventoryUpdates)
    VALUES (CURRENT_DATE, total_processes, completed_processes, pending_processes, inventory_updates);
END$$

DELIMITER ;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
