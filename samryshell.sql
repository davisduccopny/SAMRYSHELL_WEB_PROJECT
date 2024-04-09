-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th4 09, 2024 lúc 06:11 PM
-- Phiên bản máy phục vụ: 10.4.28-MariaDB
-- Phiên bản PHP: 8.1.17

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Cơ sở dữ liệu: `samryshell`
--

DELIMITER $$
--
-- Thủ tục
--
CREATE  PROCEDURE `createSaleAndSaleDetail_cart` (IN `email` VARCHAR(255), IN `status` VARCHAR(255), IN `payment` VARCHAR(255))   BEGIN
    DECLARE product_id_val INT;
    DECLARE quantity_val INT;
    
    -- Tạo bản ghi trong bảng sale
    INSERT INTO sale (email, status, payment) VALUES (email, status, payment);
    
    -- Lấy sale_id mới được tạo
    SET @sale_id = LAST_INSERT_ID();
    
    -- Lấy tất cả các dòng từ bảng cart với email nhất định
    CREATE TEMPORARY TABLE cart_temp AS SELECT product_id, quantity FROM cart WHERE email = email;
    
    -- Lặp qua các dòng kết quả từ bảng tạm thời và thêm chúng vào bảng sale_detail
    WHILE (SELECT COUNT(*) FROM cart_temp) > 0 DO
        -- Lấy dòng đầu tiên từ bảng tạm thời
        SELECT product_id, quantity INTO product_id_val, quantity_val FROM cart_temp LIMIT 1;
        
        -- Thêm dòng kết quả vào bảng sale_detail
        INSERT INTO sale_detail (sale_id, product_id, quantity) VALUES (@sale_id, product_id_val, quantity_val);
        
        -- Xóa dòng đã thêm từ bảng tạm thời
        DELETE FROM cart_temp LIMIT 1;
    END WHILE;
    
    -- Xóa bảng tạm thời
    DROP TABLE cart_temp;
    DELETE FROM cart WHERE email = email;
END$$

CREATE  PROCEDURE `create_quotation` (IN `email` VARCHAR(255), IN `status` VARCHAR(50), IN `created_at` DATETIME, IN `tax` DECIMAL(10,2), IN `discount` DECIMAL(10,2), IN `description` TEXT, IN `items` JSON)   BEGIN
    DECLARE total DECIMAL(10, 2);
    DECLARE orderrand DECIMAL(10, 2);
    DECLARE grandtotal DECIMAL(10, 2);
    DECLARE alltotalproduct DECIMAL(10, 2);
    DECLARE success_flag BOOLEAN DEFAULT TRUE;
    DECLARE error_message VARCHAR(255) DEFAULT '';
    DECLARE grandtotalall DECIMAL(10, 2);
    -- Insert into quotation table
    INSERT INTO quotation(email, status, created_at, tax, discount, description)
    VALUES (email, status, created_at, IFNULL(tax, 0), IFNULL(discount, 0), description);

    IF ROW_COUNT() = 0 THEN
        SET success_flag = FALSE;
        SET error_message = 'Failed to insert into quotation table';
    ELSE
        SET success_flag = TRUE;
    END IF;

    -- Get the newly inserted sale_id
    SET @quotation_id = LAST_INSERT_ID();
    -- Insert into sale_detail table
    SET @items_count = JSON_LENGTH(items);
    SET @alltotalproduct = 0;
    WHILE @items_count > 0 DO
    BEGIN
        SET @item = JSON_UNQUOTE(JSON_EXTRACT(items, CONCAT('$[', @items_count - 1, ']')));
        SET @product_id = JSON_UNQUOTE(JSON_EXTRACT(@item, '$.product_id'));
        SET @quantity = JSON_UNQUOTE(JSON_EXTRACT(@item, '$.quantity'));

        -- Get product details
        SELECT product.price, product.minium_quantity, product.discount, product.tax
        INTO @price, @minium_quantity, @discount, @product_tax
        FROM product
        WHERE product.id = @product_id;

        -- Calculate total for sale_detail
        IF @quantity >= @minium_quantity THEN
            SET @orderrand = @price * @quantity * @discount;
        ELSE
            SET @orderrand = 0;
        END IF;

        SET @total = (@price * @quantity) + IFNULL((@product_tax * @quantity * @price), 0) - @orderrand;
        SET @alltotalproduct = @alltotalproduct + @total;
        -- Insert into sale_detail
        INSERT INTO quotation_detail(quotation_id, product_id, quantity, total,price,discount,tax,minium_quantity)
        VALUES (@quotation_id, @product_id, @quantity, @total,@price,@discount,@product_tax,@minium_quantity);

        SET @items_count = @items_count - 1;
        END;
    END WHILE;

        UPDATE quotation
        SET total = @alltotalproduct
        WHERE quotation_id = @quotation_id;

    SET @grandtotalall = @alltotalproduct + @alltotalproduct * IFNULL(tax, 0) - @alltotalproduct * IFNULL(discount, 0);
    UPDATE quotation
    SET quotation.grand_total = @grandtotalall
    WHERE quotation.quotation_id = @quotation_id;



    -- Set the final result
    IF success_flag THEN
        SET error_message = 'Success';
    END IF;

    SELECT success_flag AS success, error_message;
END$$

CREATE  PROCEDURE `create_sale` (IN `email` VARCHAR(255), IN `status` VARCHAR(50), IN `payment_type` VARCHAR(50), IN `created_at` DATETIME, IN `ship` DECIMAL(10,2), IN `tax` DECIMAL(10,2), IN `discount_id` BIGINT, IN `description` TEXT, IN `items` JSON)   BEGIN
    DECLARE total DECIMAL(10, 2);
    DECLARE orderrand DECIMAL(10, 2);
    DECLARE grandtotal DECIMAL(10, 2);
    DECLARE alltotalproduct DECIMAL(10, 2);
    DECLARE success_flag BOOLEAN DEFAULT TRUE;
    DECLARE error_message VARCHAR(255) DEFAULT '';
    DECLARE grandtotalall DECIMAL(10, 2);
    -- Insert into sale table
    INSERT INTO sale(email, status, created_at, ship, tax, discount_id, description)
    VALUES (email, status, created_at, IFNULL(ship, 0), IFNULL(tax, 0), discount_id, description);

    IF ROW_COUNT() = 0 THEN
        SET success_flag = FALSE;
        SET error_message = 'Failed to insert into sale table';
    ELSE
        SET success_flag = TRUE;
    END IF;

    -- Get the newly inserted sale_id
    SET @sale_id = LAST_INSERT_ID();
    -- Insert into sale_detail table
    SET @items_count = JSON_LENGTH(items);
    SET @alltotalproduct = 0;
    WHILE @items_count > 0 DO
    BEGIN
        
        SET @item = JSON_UNQUOTE(JSON_EXTRACT(items, CONCAT('$[', @items_count - 1, ']')));
        SET @product_id = JSON_UNQUOTE(JSON_EXTRACT(@item, '$.product_id'));
        SET @quantity = JSON_UNQUOTE(JSON_EXTRACT(@item, '$.quantity'));

        -- Get product details
        SELECT product.price, product.minium_quantity, product.discount, product.tax
        INTO @price, @minium_quantity, @discount, @product_tax
        FROM product
        WHERE product.id = @product_id;

        -- Calculate total for sale_detail
        IF @quantity >= @minium_quantity THEN
            SET @orderrand = @price * @quantity * @discount;
        ELSE
            SET @orderrand = 0;
        END IF;

        SET @total = (@price * @quantity) + IFNULL((@product_tax * @quantity * @price), 0) - @orderrand;
        SET @alltotalproduct = @alltotalproduct + @total;
        -- Insert into sale_detail
        INSERT INTO sale_detail(sale_id, product_id, quantity, total,price,discount,tax,minium_quantity)
        VALUES (@sale_id, @product_id, @quantity, @total,@price,@discount,@product_tax,@minium_quantity);
        
        UPDATE product
        SET quantity = quantity - @quantity
        WHERE id = @product_id;

        SET @items_count = @items_count - 1;
        END;
    END WHILE;

        UPDATE sale
        SET total = @alltotalproduct
        WHERE sale_id = @sale_id;

    -- Update other sale fields based on discount and status
        SELECT discount.discount_amount, discount.status, discount.minium_value, discount.max_discount
        INTO @discount_amount, @discount_status, @minium_value, @max_discount
        FROM discount
        WHERE discount.discount_id = discount_id
        LIMIT 1;

    
    IF @discount_status = 1 AND @alltotalproduct >= @minium_value THEN
        SET @orderrand = @alltotalproduct * @discount_amount;
        IF @orderrand >= @max_discount THEN
            SET @orderrand = @max_discount;
        END IF;
        UPDATE discount 
        SET discount.quantity = discount.quantity -1 
        WHERE discount.discount_id = discount_id;

      
    ELSE
    
        SET @orderrand = 0;
         UPDATE sale
         SET sale.discount_id = 0
         WHERE sale.sale_id = @sale_id;
    END IF;

    SET @grandtotalall = @alltotalproduct + @alltotalproduct * IFNULL(tax, 0) + IFNULL(ship, 0) -  @orderrand;
    UPDATE sale
    SET sale.grand_total = @grandtotalall
    WHERE sale.sale_id = @sale_id;

    IF status = 'Complete' THEN
        UPDATE sale
        SET sale.paid = @grandtotalall, sale.payment = 'Paid', sale.due = 0
        WHERE sale.sale_id = @sale_id;
    ELSE
        UPDATE sale
        SET sale.paid = 0, sale.payment = 'Due', sale.due = @grandtotalall
        WHERE sale.sale_id = @sale_id;
    END IF;

    -- update cart 
SELECT COUNT(*) INTO @cart_count FROM cart WHERE cart.email = email;
IF FOUND_ROWS() > 0 THEN
    DELETE FROM cart WHERE cart.email = email;
END IF;



    -- Set the final result
    IF success_flag THEN
        SET error_message = 'Success';
    END IF;

    SELECT success_flag AS success, error_message;
END$$

CREATE  PROCEDURE `create_salereturn` (IN `reference` VARCHAR(255), IN `status` VARCHAR(50), IN `paymentstatus` VARCHAR(50), IN `paymentname` VARCHAR(50), IN `reason` TEXT, IN `product_id` BIGINT, IN `returndate` DATETIME)   BEGIN
    DECLARE orderrand DECIMAL(10, 2);
    DECLARE alltotalproduct DECIMAL(10, 2);
    DECLARE success_flag BOOLEAN DEFAULT TRUE;
    DECLARE error_message VARCHAR(255) DEFAULT '';

    DECLARE return_id BIGINT;
    DECLARE statuspayment VARCHAR(50);
    DECLARE paid_return DECIMAL(10, 2);
    DECLARE due_return DECIMAL(10, 2);

    -- SEARCH FOR SALE ID
    SELECT sale.sale_id, IFNULL(sale.discount_id,0), IFNULL(sale.tax,0), IFNULL(sale.ship,0), sale.email  
    INTO @sale_id, @discount_id, @tax_sale, @ship_sale, @email_sale 
    FROM sale WHERE sale.reference = reference LIMIT 1;

    SELECT sale_detail.total, sale_detail.quantity 
    INTO @totalproduct, @quantitydetail 
    FROM sale_detail WHERE sale_detail.sale_id = @sale_id AND sale_detail.product_id = product_id LIMIT 1;


    IF @discount_id != 0 THEN
        SELECT discount.discount_amount INTO @discount_amount 
        FROM discount WHERE discount.discount_id = @discount_id LIMIT 1;
        SET @orderrand = @totalproduct * @discount_amount;
    ELSE
        SET @orderrand = 0;
    END IF;

    IF status = 'Complete' THEN
        SET @paid_return = @totalproduct + @totalproduct * @tax_sale - @orderrand;
        SET @due_return = 0;
    ELSE
        SET @due_return = @totalproduct + @totalproduct * @tax_sale - @orderrand;
        SET @paid_return = 0;
    END IF;

    SET @alltotalproduct = @totalproduct + @totalproduct * @tax_sale - @orderrand;

    -- INSERT INTO RETURN TABLE
    INSERT INTO sale_return (sale_id, email, product_id, quantity, status, payment, total, tax, discount, grand_total, paid, due, reason, created_at) 
    VALUES (@sale_id, @email_sale, product_id, @quantitydetail, status,paymentstatus , 
    @totalproduct, @tax_sale, @orderrand, @alltotalproduct, @paid_return, @due_return, reason, returndate);

    IF ROW_COUNT() = 0 THEN
        SET success_flag = FALSE;
        SET error_message = 'Failed to insert into sale table';
    ELSE
        SET success_flag = TRUE;
    END IF;

    -- UPDATE PRODUCT QUANTITY
    UPDATE product SET product.quantity = product.quantity + @quantitydetail WHERE product.id = product_id;

    -- GET RETURN ID
    SET @return_id = LAST_INSERT_ID();

    -- CHECK PAYMENT STATUS
    IF paymentstatus = 'Paid' THEN
        SET @statuspayment = 'Complete';
        INSERT INTO payment_return_detail (return_id, payment_name, valueplus, status)
        VALUES (@return_id, paymentname, @paid_return, @statuspayment);
    END IF;
    
    -- SET RESULT
    IF success_flag THEN
        SET error_message = 'Success';
    END IF;

    SELECT success_flag AS success, error_message;
END$$

CREATE  PROCEDURE `update_quotation` (IN `quotation_id` BIGINT, IN `email` VARCHAR(255), IN `status` VARCHAR(50), IN `created_at` DATETIME, IN `tax` DECIMAL(10,2), IN `discount` DECIMAL(10,2), IN `description` TEXT, IN `items` JSON)   BEGIN
    DECLARE total DECIMAL(10, 2);
    DECLARE orderrand DECIMAL(10, 2);
    DECLARE grandtotal DECIMAL(10, 2);
    DECLARE alltotalproduct DECIMAL(10, 2);
    DECLARE success_flag BOOLEAN DEFAULT TRUE;
    DECLARE error_message VARCHAR(255) DEFAULT '';
    DECLARE grandtotalall DECIMAL(10, 2);


    DELETE FROM quotation_detail WHERE quotation_detail.quotation_id = quotation_id;
    -- updateto quotation table
    UPDATE quotation
    SET quotation.email = email,
    quotation.status = status,
    quotation.created_at = created_at,
    quotation.tax = IFNULL(tax, 0),
    quotation.discount = IFNULL(discount, 0),
    quotation.description = description
    WHERE quotation.quotation_id = quotation_id;

    IF ROW_COUNT() = 0 THEN
        SET success_flag = FALSE;
        SET error_message = 'Failed to insert into quotation table';
    ELSE
        SET success_flag = TRUE;
    END IF;

    -- Insert into sale_detail table
    SET @items_count = JSON_LENGTH(items);
    SET @alltotalproduct = 0;
    WHILE @items_count > 0 DO
    BEGIN
        SET @item = JSON_UNQUOTE(JSON_EXTRACT(items, CONCAT('$[', @items_count - 1, ']')));
        SET @product_id = JSON_UNQUOTE(JSON_EXTRACT(@item, '$.product_id'));
        SET @quantity = JSON_UNQUOTE(JSON_EXTRACT(@item, '$.quantity'));

        -- Get product details
        SELECT product.price, product.minium_quantity, product.discount, product.tax
        INTO @price, @minium_quantity, @discount, @product_tax
        FROM product
        WHERE product.id = @product_id;

        -- Calculate total for sale_detail
        IF @quantity >= @minium_quantity THEN
            SET @orderrand = @price * @quantity * @discount;
        ELSE
            SET @orderrand = 0;
        END IF;

        SET @total = (@price * @quantity) + IFNULL((@product_tax * @quantity * @price), 0) - @orderrand;
        SET @alltotalproduct = @alltotalproduct + @total;
        -- Insert into sale_detail
        INSERT INTO quotation_detail(quotation_id, product_id, quantity, total,price,discount,tax,minium_quantity)
        VALUES (quotation_id, @product_id, @quantity, @total,@price,@discount,@product_tax,@minium_quantity);

        SET @items_count = @items_count - 1;
        END;
    END WHILE;

        UPDATE quotation
        SET quotation.total = @alltotalproduct
        WHERE quotation.quotation_id = quotation_id;

    SET @grandtotalall = @alltotalproduct + @alltotalproduct * IFNULL(tax, 0) - @alltotalproduct * IFNULL(discount, 0);
    UPDATE quotation
    SET quotation.grand_total = @grandtotalall
    WHERE quotation.quotation_id = quotation_id;



    -- Set the final result
    IF success_flag THEN
        SET error_message = 'Success';
    END IF;

    SELECT success_flag AS success, error_message;
END$$

CREATE  PROCEDURE `update_sale` (IN `email` VARCHAR(255), IN `status` VARCHAR(50), IN `ship` DECIMAL(10,2), IN `tax` DECIMAL(10,2), IN `discount_id` BIGINT, IN `description` TEXT, IN `items` JSON, IN `sale_id` BIGINT)   BEGIN
    DECLARE total DECIMAL(10, 2);
    DECLARE orderrand DECIMAL(10, 2);
    DECLARE orderrand2 DECIMAL(10, 2);
    DECLARE grandtotal DECIMAL(10, 2);
    DECLARE alltotalproduct DECIMAL(10, 2);
    DECLARE success_flag BOOLEAN DEFAULT TRUE;
    DECLARE error_message VARCHAR(255) DEFAULT '';
    DECLARE grandtotalall DECIMAL(10, 2);
    DECLARE discount_id_old BIGINT;
    DECLARE temp_product_id BIGINT;
    DECLARE temp_quantity DECIMAL(10, 2);



    -- SEARCH FOR SALE ID
    SELECT sale.discount_id INTO @discount_id_old FROM sale WHERE sale.sale_id = sale_id LIMIT 1;
    IF (@discount_id_old != 0) THEN
        UPDATE discount SET discount.quantity = discount.quantity + 1 WHERE discount.discount_id = @discount_id_old;
    END IF;
    

    -- ROLLBACK PRODUCT QUANTITY
  -- CREATE A TEMPORARY TABLE TO STORE PRODUCT ID AND QUANTITY
CREATE TEMPORARY TABLE temp_sale_products (
    product_id BIGINT,
    quantity DECIMAL(10, 2)
);

-- INSERT PRODUCT ID AND QUANTITY FROM SALE DETAILS INTO TEMPORARY TABLE
INSERT INTO temp_sale_products (product_id, quantity)
SELECT product_id, quantity
FROM sale_detail
WHERE sale_detail.sale_id =sale_id;

-- LOOP THROUGH EACH PRODUCT IN TEMPORARY TABLE AND UPDATE PRODUCT QUANTITY
WHILE (SELECT COUNT(*) FROM temp_sale_products) > 0 DO
    -- GET PRODUCT ID AND QUANTITY FOR THE FIRST ROW
    SELECT product_id, quantity
    INTO @temp_product_id, @temp_quantity
    FROM temp_sale_products
    LIMIT 1;

    -- UPDATE PRODUCT QUANTITY
    UPDATE product
    SET product.quantity = product.quantity+ @temp_quantity
    WHERE product.id = @temp_product_id;

    -- DELETE THE FIRST ROW FROM TEMPORARY TABLE
    DELETE FROM temp_sale_products
    WHERE product_id = @temp_product_id;
END WHILE;

-- DROP THE TEMPORARY TABLE
DROP TEMPORARY TABLE temp_sale_products;

    -- END ROLLBACK PRODUCT QUANTITY
    -- DELETE SALE DETAIL
    DELETE FROM sale_detail WHERE sale_detail.sale_id = sale_id;
    -- UPDATE SALE
    UPDATE sale
    SET
        email = email,
        status = status,
        ship = IFNULL(ship, 0),
        tax = IFNULL(tax, 0),
        discount_id = discount_id,
        description = description
    WHERE sale.sale_id = sale_id;

    IF ROW_COUNT() = 0 THEN
        SET success_flag = FALSE;
        SET error_message = 'Failed to update sale table';
    ELSE
        SET success_flag = TRUE;
    END IF;

    -- Get the newly updated sale_id
    SET @sale_id = sale_id;

    -- Insert into sale_detail table
    SET @items_count = JSON_LENGTH(items);
    SET @alltotalproduct = 0;

    WHILE @items_count > 0 DO
        SET @item = JSON_UNQUOTE(JSON_EXTRACT(items, CONCAT('$[', @items_count - 1, ']')));
        SET @product_id = JSON_UNQUOTE(JSON_EXTRACT(@item, '$.product_id'));
        SET @quantity = JSON_UNQUOTE(JSON_EXTRACT(@item, '$.quantity'));

        -- Get product details
        SELECT product.price, product.minium_quantity, product.discount, product.tax
        INTO @price, @minium_quantity, @discount, @product_tax
        FROM product
        WHERE product.id = @product_id;

        -- Calculate total for sale_detail
        IF @quantity >= @minium_quantity THEN
            SET @orderrand = @price * @quantity * @discount;
        ELSE
            SET @orderrand = 0;
        END IF;

        SET @total = (@price * @quantity) + IFNULL((@product_tax * @quantity * @price), 0) - @orderrand;
        SET @alltotalproduct = @alltotalproduct + @total;

        -- Insert into sale_detail
        INSERT INTO sale_detail(sale_id, product_id, quantity, total,price,discount,tax,minium_quantity)
        VALUES (@sale_id, @product_id, @quantity, @total,@price,@discount,@product_tax,@minium_quantity);

        -- Update product quantity
        UPDATE product
        SET product.quantity = product.quantity - @quantity
        WHERE product.id = @product_id;

        SET @items_count = @items_count - 1;
    END WHILE;

    -- Update sale total
    UPDATE sale
    SET total = @alltotalproduct
    WHERE sale.sale_id = @sale_id;

    -- Update other sale fields based on discount and status
    SELECT discount.discount_amount, discount.status, discount.minium_value, discount.max_discount
    INTO @discount_amount, @discount_status, @minium_value, @max_discount
    FROM discount
    WHERE discount.discount_id = discount_id
    LIMIT 1;

    IF @discount_status = 1 AND @alltotalproduct >= @minium_value  THEN
        SET @orderrand2 = @alltotalproduct * @discount_amount;
        
        IF @orderrand2 >= @max_discount THEN
            SET @orderrand2 = @max_discount;
        END IF;
        UPDATE discount
        SET discount.quantity = discount.quantity - 1
        WHERE discount.discount_id = discount_id;
    ELSE
        SET @orderrand2 = 0;
        UPDATE sale
        SET sale.discount_id = 0
        WHERE sale.sale_id = sale_id;
       
        
    END IF;

    SET @grandtotalall = @alltotalproduct + (@alltotalproduct * IFNULL(tax, 0)) + IFNULL(ship, 0) - @orderrand2;
    UPDATE sale
    SET grand_total = @grandtotalall
    WHERE sale.sale_id = @sale_id;
    -- Update sale grand_total, paid, and due
    IF status = 'Complete' THEN
        UPDATE sale
        SET paid = @grandtotalall, payment = 'Paid', due = 0
        WHERE sale.sale_id = @sale_id;
    ELSE
        UPDATE sale
        SET paid = 0, payment = 'Due', due = @grandtotalall
        WHERE sale.sale_id = @sale_id;
    END IF;


    -- Update cart
    DELETE FROM cart WHERE cart.email = email;

    -- Set the final result
    IF success_flag THEN
        SET error_message = 'Success';
    END IF;
	
     
END$$

CREATE  PROCEDURE `update_salereturn` (IN `status` VARCHAR(50), IN `paymentstatus` VARCHAR(50), IN `paymentname` VARCHAR(50), IN `reason` TEXT, IN `returndate` DATETIME, IN `return_id` BIGINT)   BEGIN
    DECLARE success_flag BOOLEAN DEFAULT TRUE;
    DECLARE error_message VARCHAR(255) DEFAULT '';

    -- SEARCH FOR SALE ID
    SELECT sale_return.grand_total, sale_return.paid INTO @grand_totalupdate, @paid_return FROM sale_return WHERE sale_return.id = return_id LIMIT 1;

    IF paymentstatus = 'Paid' AND @paid_return <= 0 AND status != 'Complete' THEN
        UPDATE sale_return
        SET sale_return.paid = @grand_totalupdate, sale_return.due = 0, sale_return.status = status, sale_return.reason = reason, sale_return.created_at = returndate, sale_return.payment = 'Paid'
        WHERE sale_return.id = return_id;
    ELSEIF status = 'Complete' AND paymentstatus != 'Paid' THEN
        UPDATE sale_return
        SET sale_return.paid = @grand_totalupdate, sale_return.due = 0, sale_return.status = status, sale_return.reason = reason, sale_return.created_at = returndate, sale_return.payment = 'Paid'
        WHERE sale_return.id = return_id;
    ELSEIF status = 'Complete' AND paymentstatus = 'Paid' THEN
        UPDATE sale_return
        SET sale_return.paid = @grand_totalupdate, sale_return.due = 0, sale_return.status = status, sale_return.reason = reason, sale_return.created_at = returndate, sale_return.payment = 'Paid'
        WHERE sale_return.id = return_id;
    ELSE
        UPDATE sale_return
        SET sale_return.status = status, sale_return.reason = reason, sale_return.created_at = returndate, sale_return.payment = paymentstatus
        WHERE sale_return.id = return_id;
    END IF;

    SELECT payment_return_detail.return_id INTO @return_id_payment FROM payment_return_detail WHERE payment_return_detail.return_id = return_id LIMIT 1;
    IF (@return_id_payment IS NULL OR ROW_COUNT()=0) AND status ='Complete' THEN
        INSERT INTO payment_return_detail (return_id, payment_name, valueplus, status)
        VALUES (return_id, paymentname, @grand_totalupdate, status);
    ELSE
        UPDATE payment_return_detail
        SET payment_return_detail.payment_name = paymentname
        WHERE payment_return_detail.return_id = return_id;
    END IF;

    IF ROW_COUNT() = 0 THEN
        SET success_flag = FALSE;
        SET error_message = 'Failed to update sale_return table';
    ELSE
        SET success_flag = TRUE;
    END IF;

    IF success_flag THEN
        SET error_message = 'Success';
    END IF;

    SELECT success_flag AS success, error_message;
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `blog`
--

CREATE TABLE `blog` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp(),
  `description` text DEFAULT NULL,
  `category_id` int(11) DEFAULT NULL,
  `content` text DEFAULT NULL,
  `created_by` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `blog`
--

INSERT INTO `blog` (`id`, `title`, `image`, `date`, `description`, `category_id`, `content`, `created_by`) VALUES
(1, 'Bai viet thu 2', '../upload/blog116 - Copy.png', '2024-04-08 11:17:28', 'Blog được biết đến một nền tảng mà mọi người có thể chia sẻ mọi thứ về cuộc sống thường ngày, công việc hoặc cập nhật những điều đang diễn ra xung quanh một cách trực tuyến. Tuy nhiên, nhiều bạn vẫn chưa thực sự hiểu rõ về khái niệm Blog là gì. Vì vậy, trong bài viết dưới đây Mona Media sẽ giúp bạn hiểu rõ từ A – Z về nền tảng Blog và cách xây dựng trang blog cá nhân chuyên nghiệp.', 2, '<h2>&nbsp;</h2>\r\n\r\n<h3>Blog l&agrave; g&igrave;?</h3>\r\n\r\n<p>Blog được xem như l&agrave; một cuốn nhật k&yacute; online hay website c&aacute; nh&acirc;n. Ở đ&acirc;y c&aacute;c c&aacute; nh&acirc;n hoặc một nh&oacute;m n&agrave;o đ&oacute; c&oacute; thể chia sẻ mọi th&ocirc;ng tin li&ecirc;n quan đến nhiều chủ đề kh&aacute;c nhau dưới g&oacute;c nh&igrave;n chủ quan. Đa phần c&aacute;c trang blog sẽ tr&igrave;nh b&agrave;y những b&agrave;i viết mới nhất ở vị tr&iacute; đầu trang.</p>\r\n\r\n<p>Đồng thời, Blog c&ograve;n l&agrave; từ viết tắt của weblog (nhật k&yacute; web) &ndash; dạng nhật k&yacute; trực tuyến bắt đầu phổ biến v&agrave;o thập ni&ecirc;n 90. Ng&agrave;y nay, blog ph&aacute;t triển rất mạnh v&agrave; bất kỳ ai cũng c&oacute; thể tạo cho m&igrave;nh một trang blog c&aacute; nh&acirc;n ri&ecirc;ng.</p>\r\n\r\n<p>Nội dung tr&ecirc;n blog c&oacute; thể l&agrave; văn bản,&nbsp;<strong><a href=\"https://mona.media/link-la-gi/\" rel=\"noopener\" target=\"_blank\">link</a></strong>, video, h&igrave;nh ảnh,&nbsp;<strong><a href=\"https://mona.media/infographic-la-gi/\" rel=\"noopener\" target=\"_blank\">infographic</a></strong>&hellip; thường thể hiện g&oacute;c nh&igrave;n chủ quan về một chủ đề y&ecirc;u th&iacute;ch n&agrave;o đ&oacute;. Tuy nhi&ecirc;n, hai định nghĩa về&nbsp;<strong>blog l&agrave; g&igrave;</strong>&nbsp;v&agrave;&nbsp;<strong>website l&agrave; g&igrave;</strong>&nbsp;đang bị nhiều người nhầm lẫn, nội dung b&ecirc;n dưới sẽ gi&uacute;p bạn hiểu r&otilde; hơn về mọi thứ của blog.</p>\r\n\r\n<p><img alt=\"Trang blog là như nào\" decoding=\"async\" sizes=\"(max-width: 1366px) 100vw, 1366px\" src=\"https://mona.media/wp-content/uploads/2019/02/bellevue-dichvu.jpg\" srcset=\"https://mona.media/wp-content/uploads/2019/02/bellevue-dichvu.jpg 1366w, https://mona.media/wp-content/uploads/2019/02/bellevue-dichvu-216x300.jpg 216w, https://mona.media/wp-content/uploads/2019/02/bellevue-dichvu-738x1024.jpg 738w, https://mona.media/wp-content/uploads/2019/02/bellevue-dichvu-768x1066.jpg 768w, https://mona.media/wp-content/uploads/2019/02/bellevue-dichvu-1107x1536.jpg 1107w, https://mona.media/wp-content/uploads/2019/02/bellevue-dichvu-569x790.jpg 569w, https://mona.media/wp-content/uploads/2019/02/bellevue-dichvu-400x555.jpg 400w, https://mona.media/wp-content/uploads/2019/02/bellevue-dichvu-72x100.jpg 72w, https://mona.media/wp-content/uploads/2019/02/bellevue-dichvu-432x600.jpg 432w, https://mona.media/wp-content/uploads/2019/02/bellevue-dichvu-508x705.jpg 508w\" style=\"height:1896px; width:1366px\" /></p>\r\n', 'hxqduccopny@gmail.com');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `cart`
--

CREATE TABLE `cart` (
  `cart_id` int(11) NOT NULL,
  `product_id` bigint(20) DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `email` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `categoryproduct`
--

CREATE TABLE `categoryproduct` (
  `categoryproduct_id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `category_link` varchar(255) DEFAULT NULL,
  `code` varchar(255) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `created_by` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `categoryproduct`
--

INSERT INTO `categoryproduct` (`categoryproduct_id`, `name`, `category_link`, `code`, `image`, `created_by`, `description`) VALUES
(16, 'Fruits', 'fruits', 'CT001', '../upload/category/fruits/product62.png', 'admin', 'CT001'),
(17, 'Headphones', 'headphones', 'CT002', '../upload/category/headphones/product63.png', 'admin', 'CT002'),
(18, 'Accessories', 'accessories', 'CT003', '../upload/category/accessories/product64.png', 'admin', 'CT003'),
(19, 'Shoes', 'shoes', 'CT004', '../upload/category/shoes/product65.png', 'admin', 'CT004'),
(20, 'Computer', 'computer', 'CT005', '../upload/category/computer/product66.png', 'admin', 'CT005'),
(21, 'Snacks', 'snacks', 'CT006', '../upload/category/snacks/product67.png', 'admin', 'CT006'),
(22, 'Watches', 'watches', 'CT007', '../upload/category/watches/product68.png', 'admin', 'CT007'),
(23, 'Cycles', 'cycles', 'CT008', '../upload/category/cycles/product61.png', 'admin', 'CT008'),
(24, 'Fruits2', 'fruits2', 'CT009', '../upload/category/fruits2/product62.png', 'admin', 'CT009'),
(25, 'Headphones2', 'headphones2', 'CT0010', '../upload/category/headphones2/product63.png', 'admin', 'CT0010');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `category_blog`
--

CREATE TABLE `category_blog` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `category_blog`
--

INSERT INTO `category_blog` (`id`, `name`, `created_at`) VALUES
(1, 'Tin tức mới nhất', '2024-04-08 09:20:03'),
(2, 'Trang trí nhà cửa', '2024-04-08 09:20:03'),
(3, 'Vẻ đẹp cuộc sống', '2024-04-08 09:20:57'),
(4, 'Sản xuất và giá cả', '2024-04-08 09:20:57');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `category_expense`
--

CREATE TABLE `category_expense` (
  `id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `code` varchar(255) DEFAULT NULL,
  `status` varchar(50) NOT NULL,
  `amount` decimal(10,2) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `category_expense`
--

INSERT INTO `category_expense` (`id`, `name`, `code`, `status`, `amount`, `description`, `created_at`) VALUES
(1, 'mua nguyen lieu', 'EX001', 'Active', 12000.00, 'aaa', '2023-09-05 17:03:19'),
(3, 'chi phi cong trinh', 'EX003', 'In Active', 13000.00, 'sdsd', '2023-09-05 17:08:47'),
(4, 'nguyen lieu 2', 'EX002', 'Active', 13000.00, '23444', '2023-09-05 19:32:01');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `category_sub`
--

CREATE TABLE `category_sub` (
  `category_sub_id` int(11) NOT NULL,
  `categoryproduct_id` int(11) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `code` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `category_link` varchar(255) DEFAULT NULL,
  `created_by` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `category_sub`
--

INSERT INTO `category_sub` (`category_sub_id`, `categoryproduct_id`, `name`, `code`, `description`, `category_link`, `created_by`) VALUES
(7, 17, 'camdfr', 'FHT', '', 'camdfr', 'admin');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `customer`
--

CREATE TABLE `customer` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `type` varchar(50) DEFAULT NULL,
  `country` varchar(100) DEFAULT NULL,
  `city` varchar(100) DEFAULT NULL,
  `district` varchar(100) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `zipcode` varchar(20) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `code` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `customer`
--

INSERT INTO `customer` (`id`, `name`, `phone`, `image`, `email`, `type`, `country`, `city`, `district`, `address`, `zipcode`, `description`, `code`, `created_at`, `updated_at`) VALUES
(19, 'Hoàng Xuân Quốc', '84865625135', '../upload/customer/avatar-03.jpg', '2156210125@gmail.com', 'Customer normal', 'Vietnam', 'Đồng Tháp', 'Cao Lãnh', 'Sau phòng giáo dục gio linh, khu phố 2, thị trấn gio linh', '1233232', '', 'CTM001', NULL, '2023-08-25 03:13:20'),
(20, 'Hoàng Xuân Quốca2', '84865625135', '../upload/customer/avatar-17.jpg', '21562101253@gmail.com', 'Customer normal', 'Vietnam', 'Bà Rịa-Vũng Tàu', 'Huyện Đất Đỏ', 'Sau phòng giáo dục gio linh, khu phố 2, thị trấn gio linh', '76767', '34343', 'CTM002', NULL, '2023-08-25 03:19:22'),
(21, 'Nguyễn Nhân', '0547288132', '../upload/customer/avatar-13.jpg', 'hoangnhan@gmail.com', 'Customer Pro', 'France', 'Nouvelle-Aquitaine', 'Agonac', 'france dejong la', '123', 'dsdsds', 'CTM003', NULL, '2023-08-28 18:02:46'),
(35, 'Nguyenhanhoang', '84865625135', '../upload/customer/profile4.jpg', '215621045445@gmail.com', 'Choose Type', 'Vietnam', 'Select State', 'Choose District', 'KTX KHU B', '23232', '23232', 'CTM004', NULL, '2023-09-02 14:23:28'),
(36, 'Nguyen hoang', '0358423356', '../upload/customer/avt-tvs-1641547808814523708345.jpg', '1907htng@gmail.com', 'Customer normal', 'Vietnam', 'Select State', 'Select City', '343, cmt8', '125423', 'sedrwewe', 'CTM005', NULL, '2023-09-06 01:48:23'),
(37, 'Aris', '0874423356', '../upload/customer/', '2156210177@gmail.com', 'Choose Type', 'Select Country', 'Choose state/city', 'Choose District', '', '', '', 'CTM006', NULL, '2024-04-06 05:29:13'),
(38, 'hanhanthanh', '', '../upload/customer/', 'hoangnhangmj@gmail.com', 'Choose Type', 'Select Country', 'Choose state/city', 'Choose District', '', '', '', 'CTM007', NULL, '2024-04-06 05:40:39'),
(41, 'Hoàng Xuân Thành', '', '../upload/customer/', '2156210166@gmail.com', '', '', '', '', '', '', '', 'CTM008', NULL, '2024-04-06 08:29:52'),
(42, 'Hoàng Xuân Thành nhân', '', '../upload/customer/', '2156210167@gmail.com', '', '', '', '', '', '', '', 'CTM009', NULL, '2024-04-06 08:32:17'),
(43, 'Nguyễn THành Tân', '', '../upload/customer/', '2156210100@gmail.com', '', '', '', '', '', '', '', 'CTM010', NULL, '2024-04-08 08:31:45');

--
-- Bẫy `customer`
--
DELIMITER $$
CREATE TRIGGER `trg_before_insert_customer` BEFORE INSERT ON `customer` FOR EACH ROW BEGIN
    DECLARE new_code VARCHAR(10);
    SET new_code = CONCAT('CTM', LPAD((SELECT COUNT(*) + 1 FROM customer), 3, '0'));
    SET NEW.code = new_code;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `discount`
--

CREATE TABLE `discount` (
  `discount_id` bigint(20) NOT NULL,
  `discount_amount` decimal(10,2) DEFAULT NULL,
  `start_date` datetime DEFAULT NULL,
  `end_date` datetime DEFAULT NULL,
  `content` text DEFAULT NULL,
  `status` tinyint(1) DEFAULT 0,
  `created_at` datetime DEFAULT NULL,
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `type` varchar(30) DEFAULT NULL,
  `quantity` decimal(10,2) NOT NULL,
  `minium_value` decimal(10,2) DEFAULT NULL,
  `max_discount` decimal(10,2) DEFAULT NULL,
  `reference` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `discount`
--

INSERT INTO `discount` (`discount_id`, `discount_amount`, `start_date`, `end_date`, `content`, `status`, `created_at`, `updated_at`, `type`, `quantity`, `minium_value`, `max_discount`, `reference`) VALUES
(3, 0.60, '2023-08-19 00:00:00', '2023-08-31 00:00:00', 'Discount t92', 0, NULL, '2023-09-02 18:18:42', 'customer', -104.00, 1000.00, 100000.00, 'GG001'),
(4, 0.20, '2023-08-19 00:00:00', '2023-08-31 00:00:00', 'Discount t82', 0, NULL, '2023-09-02 18:18:42', 'customer', -228.00, 100.00, 100000.00, 'GG003'),
(6, 0.20, '2023-08-19 00:00:00', '2023-09-21 00:00:00', 'Discount t83', 0, NULL, '2024-04-06 14:53:08', 'customer', 68.00, 100.00, 100000.00, 'GG004');

--
-- Bẫy `discount`
--
DELIMITER $$
CREATE TRIGGER `before_discount_update_status` BEFORE UPDATE ON `discount` FOR EACH ROW BEGIN
    IF NEW.start_date IS NOT NULL AND NEW.end_date IS NOT NULL THEN
        IF CURDATE() < NEW.start_date OR CURDATE() > NEW.end_date THEN
            SET NEW.status = 0;
        END IF;
    END IF;

    IF NEW.quantity <= 0 THEN
        SET NEW.status = 0;
    END IF;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `before_insert_discount_status` BEFORE INSERT ON `discount` FOR EACH ROW BEGIN
    IF NEW.start_date IS NOT NULL AND NEW.end_date IS NOT NULL THEN
        IF CURDATE() < NEW.start_date OR CURDATE() > NEW.end_date THEN
            SET NEW.status = 0;
        END IF;
    END IF;

    IF NEW.quantity <= 0 THEN
        SET NEW.status = 0;
    END IF;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `discount_reference_beforeinsert` BEFORE INSERT ON `discount` FOR EACH ROW BEGIN
    DECLARE next_id INT;
    
    -- Lấy ra số thứ tự tiếp theo
    SELECT IFNULL(MAX(CAST(SUBSTRING_INDEX(reference, 'GG', -1) AS UNSIGNED)), 0) + 1 INTO next_id FROM discount;
    
    -- Nếu không tìm thấy hàng nào hoặc trường reference là NULL, giá trị tiếp theo bắt đầu từ SLL001
    IF next_id = 0 OR NEW.reference IS NULL THEN
        SET NEW.reference = 'GG001';
    ELSE
        -- Tạo giá trị mới cho reference
        SET NEW.reference = CONCAT('GG', LPAD(next_id, 3, '0'));
    END IF;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `email_setting`
--

CREATE TABLE `email_setting` (
  `id` int(11) NOT NULL,
  `host` varchar(255) NOT NULL,
  `port` varchar(255) NOT NULL,
  `address_server` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `business_name` varchar(255) NOT NULL,
  `subject_forgot` text DEFAULT NULL,
  `subject_advertse` text DEFAULT NULL,
  `content_forgot` text DEFAULT NULL,
  `content_advertse` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `email_setting`
--

INSERT INTO `email_setting` (`id`, `host`, `port`, `address_server`, `password`, `business_name`, `subject_forgot`, `subject_advertse`, `content_forgot`, `content_advertse`) VALUES
(1, 'smtp.gmail.com', '587', 'cskhhoanghaigroup@gmail.com', 'wxbazgsjxcxlcjgn', 'First Last', 'PHPMailer GMail SMTP test', 'PHPMailer GMail SMTP test', '<table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" id=\"u_content_text_2\" style=\"font-family:\'Rubik\',sans-serif; width:100%\">\r\n	<tbody>\r\n		<tr>\r\n			<td>\r\n			<div class=\"v-font-size v-text-align\" style=\"color:#5c5c5c; font-size:14px; line-height:170%; text-align:left; word-wrap:break-word\">\r\n			<p><span style=\"font-size:16px\"><strong>Hi [Candidate&rsquo;s Name], </strong></span></p>\r\n\r\n			<p>&nbsp;</p>\r\n\r\n			<p><span style=\"font-size:16px\">Received your mail and hope this mail reads you well. Talent acquisition often requires a huge investment of time and resources, so it is always safe and secure to do your due diligence before onboarding a new hire.&nbsp;</span></p>\r\n\r\n			<p>&nbsp;</p>\r\n\r\n			<p><span style=\"font-size:16px\">To go ahead with your data verification, we would require these documents from you:</span></p>\r\n\r\n			<p><strong><span style=\"font-size:16px\">[document names]</span></strong></p>\r\n\r\n			<p>&nbsp;</p>\r\n\r\n			<p><span style=\"font-size:16px\">This will ensure the authenticity of your data and information with the verification process is pretty simple and short. The information you provide is confidential and safe with us.&nbsp;</span></p>\r\n\r\n			<p>&nbsp;</p>\r\n\r\n			<p><span style=\"font-size:16px\">If you have any questions/issues regarding the process, feel free to contact us.&nbsp;</span></p>\r\n\r\n			<p>&nbsp;</p>\r\n\r\n			<p><span style=\"font-size:16px\">With Regards,</span></p>\r\n\r\n			<p><span style=\"font-size:16px\"><strong>[Your name]</strong></span></p>\r\n			</div>\r\n			</td>\r\n		</tr>\r\n	</tbody>\r\n</table>\r\n', '<p>PHPMailer G1232</p>\r\n');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `expense`
--

CREATE TABLE `expense` (
  `id` bigint(20) NOT NULL,
  `categoryex_id` int(20) NOT NULL,
  `code` varchar(255) DEFAULT NULL,
  `expense_for` text DEFAULT NULL,
  `status` varchar(50) NOT NULL,
  `amount` decimal(10,2) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `expense`
--

INSERT INTO `expense` (`id`, `categoryex_id`, `code`, `expense_for`, `status`, `amount`, `description`, `created_at`) VALUES
(8, 4, 'EXE001', 'category2', 'Active', 13000.00, 'sdss', '2023-09-04 17:00:00'),
(10, 1, 'EXE002', 'category', 'In Active', 12000.00, '666', '2023-09-06 17:00:00'),
(11, 1, 'EXE003', 'category3', 'Active', 12000.00, 'category3', '0000-00-00 00:00:00'),
(12, 1, 'EXE004', 'category', 'Active', 12000.00, '', '2023-09-05 17:00:00');

--
-- Bẫy `expense`
--
DELIMITER $$
CREATE TRIGGER `before_insert_code__expense` BEFORE INSERT ON `expense` FOR EACH ROW BEGIN
    DECLARE next_id INT;

    -- Lấy phần số thứ tự tiếp theo từ chuỗi code
    SELECT IFNULL(MAX(CAST(SUBSTRING_INDEX(code, 'EXE', -1) AS UNSIGNED)), 0) INTO next_id FROM expense;

    -- Tính toán giá trị tiếp theo
    SET next_id = next_id + 1;

    -- Đảm bảo next_id không vượt quá giá trị tối đa (ví dụ: 999)
    IF next_id > 10000000 THEN
        SET next_id = 10000000;
    END IF;

    -- Tạo giá trị mới cho code với định dạng 'EXExxx'
    SET NEW.code = CONCAT('EXE', LPAD(next_id, 3, '0'));
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `general_setting`
--

CREATE TABLE `general_setting` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `time_zone` varchar(255) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp(),
  `date_format` text DEFAULT NULL,
  `phone` text DEFAULT NULL,
  `email` text DEFAULT NULL,
  `address` text DEFAULT NULL,
  `fax` text DEFAULT NULL,
  `currency` varchar(255) DEFAULT NULL,
  `facebook` varchar(255) DEFAULT NULL,
  `youtube` varchar(255) DEFAULT NULL,
  `linkedin` varchar(255) DEFAULT NULL,
  `instagram` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `general_setting`
--

INSERT INTO `general_setting` (`id`, `title`, `time_zone`, `image`, `date`, `date_format`, `phone`, `email`, `address`, `fax`, `currency`, `facebook`, `youtube`, `linkedin`, `instagram`) VALUES
(1, 'ABCS', 'GMT+7', '../upload/general/660fd460e8a32_Screenshot 2023-0.png', '2024-04-05 10:20:22', 'DD/MM/YYYY', '0865625135', '2156210125@hcmussh.edu.vn', 'df', 'df', 'VND', NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `image_product`
--

CREATE TABLE `image_product` (
  `id` int(11) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `product_id` bigint(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `image_product`
--

INSERT INTO `image_product` (`id`, `image`, `product_id`) VALUES
(82, '../upload/64e8155535cbb.jpg', 65),
(83, '../upload/64e81591b9332.jpg', 66),
(84, '../upload/64e815c7eadca.jpg', 67),
(85, '../upload/64e815fe50bbe.jpg', 68),
(86, '../upload/64e8162c5863e.jpg', 69),
(87, '../upload/64e816607c807.jpg', 70),
(88, '../upload/64e8169373f90.jpg', 71),
(89, '../upload/64e816bc9e484.jpg', 72),
(90, '../upload/64e816dfcc3a3.jpg', 73),
(91, '../upload/64e817054eaac.jpg', 74),
(92, '../upload/64e8172c78db2.jpg', 75),
(93, '../upload/64e81757d1c1f.jpg', 76),
(94, '../upload/64e81783107cc.png', 77),
(95, '../upload/64e817ab0d928.jpg', 78),
(96, '../upload/64e817dd42162.jpg', 79),
(97, '../upload/64e81805769c4.jpg', 80),
(98, '../upload/64e818277fa91.jpg', 81),
(99, '../upload/64e81854102a3.jpg', 82),
(100, '../upload/64e81875d517a.jpg', 83),
(101, '../upload/64e81967cd3bd.jpg', 91),
(102, '../upload/64e8199d07b52.jpg', 92),
(103, '../upload/64e819c24eadf.jpg', 93),
(104, '../upload/64e819e80e685.jpg', 94),
(105, '../upload/64e81a0ac57fb.jpg', 95),
(107, '../upload/64e81a65a7cdd.jpg', 97),
(108, '../upload/660ec28878454.png', 64),
(109, '../upload/660ec28878af1.png', 64),
(110, '../upload/660ec288790f0.png', 64),
(111, '../upload/660f56d71e65e.png', 63),
(112, '../upload/660f56d71eb43.png', 63),
(114, '../upload/661423436bd1a.png', 101);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `notification`
--

CREATE TABLE `notification` (
  `id` int(11) NOT NULL,
  `customer_id` bigint(20) NOT NULL,
  `content` text DEFAULT NULL,
  `action_notification` text DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `payment_detail`
--

CREATE TABLE `payment_detail` (
  `id` bigint(20) NOT NULL,
  `payment_name` varchar(20) NOT NULL,
  `sale_id` bigint(20) NOT NULL,
  `valueplus` decimal(10,2) DEFAULT NULL,
  `status` varchar(100) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `note` text DEFAULT NULL,
  `paymentconst` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `payment_detail`
--

INSERT INTO `payment_detail` (`id`, `payment_name`, `sale_id`, `valueplus`, `status`, `created_at`, `updated_at`, `note`, `paymentconst`) VALUES
(72, 'Cash', 125, 1000.00, 'pending', '2023-09-03 01:48:56', '2023-09-02 18:48:56', '', 'salepayment'),
(73, 'Cash', 139, 180.00, 'success', '2024-04-06 08:44:10', '2024-04-06 01:44:10', '', 'salepayment'),
(74, 'Cash', 136, 2030.00, 'success', '2024-04-09 00:32:01', '2024-04-08 17:32:01', '', 'salepayment');

--
-- Bẫy `payment_detail`
--
DELIMITER $$
CREATE TRIGGER `after_insert_paid_due` AFTER INSERT ON `payment_detail` FOR EACH ROW BEGIN
    DECLARE total_paid DECIMAL(10, 2);
    DECLARE total_due DECIMAL(10, 2);
    DECLARE payment_status VARCHAR(255);

    -- Get current Paid and Due values for the sale
    SELECT Paid, Due,payment INTO total_paid, total_due,payment_status
    FROM sale
    WHERE sale_id = NEW.sale_id;
	IF payment_status != 'Paid' THEN
    
    -- Update Paid and Due with the new values
    SET total_paid = total_paid + NEW.valueplus;
    SET total_due = total_due - NEW.valueplus;
    
    -- Make sure valueplus is positive and status is 'access'
     IF NEW.valueplus > 0 AND NEW.status = 'success' THEN
        -- Check if total_due is negative and reset it to 0
        IF total_due <= 0 THEN
      
            SET total_due = 0;
            IF payment_status != 'Paid' THEN
            SET	payment_status = 'Paid';
            END IF;
          
        END IF;

        -- Update Paid and Due in the sale table
        UPDATE sale
        SET Paid = total_paid, Due = total_due,payment = 			payment_status
        WHERE sale_id = NEW.sale_id;
         
    END IF;
    END IF;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `before_createdat_insert` BEFORE INSERT ON `payment_detail` FOR EACH ROW BEGIN
    IF NEW.created_at IS NULL THEN
        SET NEW.created_at = NOW();
    END IF;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `update_paid_due` AFTER UPDATE ON `payment_detail` FOR EACH ROW BEGIN
    DECLARE total_paid DECIMAL(10, 2);
    DECLARE total_due DECIMAL(10, 2);
    DECLARE payment_status VARCHAR(255);

    -- Get current Paid and Due values for the sale
    SELECT Paid, Due,payment INTO total_paid, total_due,payment_status
    FROM sale
    WHERE sale_id = NEW.sale_id;
	IF payment_status != 'Paid' THEN
    
    -- Update Paid and Due with the new values
    SET total_paid = total_paid + NEW.valueplus;
    SET total_due = total_due - NEW.valueplus;
    
    -- Make sure valueplus is positive and status is 'access'
     IF NEW.valueplus > 0 AND NEW.status = 'success' THEN
        -- Check if total_due is negative and reset it to 0
        IF total_due <= 0 THEN
      
            SET total_due = 0;
            IF payment_status != 'Paid' THEN
            SET	payment_status = 'Paid';
            END IF;
          
        END IF;

        -- Update Paid and Due in the sale table
        UPDATE sale
        SET Paid = total_paid, Due = total_due,payment = 			payment_status
        WHERE sale_id = NEW.sale_id;
         
    END IF;
    END IF;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `payment_return_detail`
--

CREATE TABLE `payment_return_detail` (
  `id` bigint(20) NOT NULL,
  `payment_name` varchar(20) NOT NULL,
  `return_id` bigint(20) NOT NULL,
  `valueplus` decimal(10,2) DEFAULT NULL,
  `status` varchar(100) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `payment_return_detail`
--

INSERT INTO `payment_return_detail` (`id`, `payment_name`, `return_id`, `valueplus`, `status`, `created_at`, `updated_at`) VALUES
(10, 'Cash', 141, 108.00, 'Complete', '2023-09-05 16:05:43', '2023-09-05 16:05:43'),
(11, 'Cash', 142, 5400.00, 'Complete', '2023-09-05 16:06:37', '2023-09-05 16:06:37'),
(12, 'Cash', 143, 0.00, 'Complete', '2023-09-05 16:18:55', '2023-09-05 16:18:55');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `payment_type`
--

CREATE TABLE `payment_type` (
  `id` bigint(20) NOT NULL,
  `typepayment` varchar(50) NOT NULL,
  `no_id` int(20) DEFAULT NULL,
  `theface` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `payment_type`
--

INSERT INTO `payment_type` (`id`, `typepayment`, `no_id`, `theface`, `description`, `image`) VALUES
(1, 'Cash', NULL, 'Cash for image', NULL, NULL),
(2, 'Debit', 1015694586, 'Debit', NULL, NULL),
(3, 'MoMo', 393643357, 'MoMo ', NULL, NULL);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `product`
--

CREATE TABLE `product` (
  `id` bigint(20) NOT NULL,
  `sku` varchar(255) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  `minium_quantity` decimal(10,2) DEFAULT NULL,
  `quantity` decimal(10,2) DEFAULT NULL,
  `unit` varchar(50) DEFAULT NULL,
  `tax` decimal(10,2) DEFAULT NULL,
  `discount` decimal(10,2) DEFAULT NULL,
  `status` varchar(30) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `categoryproduct_id` int(11) DEFAULT NULL,
  `subcategoryproduct_id` int(11) DEFAULT NULL,
  `slug` varchar(1000) DEFAULT NULL,
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `created_at` datetime DEFAULT NULL,
  `created_by` varchar(20) DEFAULT NULL,
  `short_description` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `product`
--

INSERT INTO `product` (`id`, `sku`, `name`, `price`, `minium_quantity`, `quantity`, `unit`, `tax`, `discount`, `status`, `description`, `categoryproduct_id`, `subcategoryproduct_id`, `slug`, `updated_at`, `created_at`, `created_by`, `short_description`) VALUES
(63, 'QR123789', 'Orange', 150.00, 1.00, 938.00, 'USD', 0.00, 0.10, 'Open', '<p>Stay comfortable and stay in the race no matter what the weather&#39;s up to. The Bruno Compete Hoodie&#39;s water-repellent exterior shields you from the&nbsp;elements, while advanced fabric technology inside wicks moisture to keep you&nbsp;dry.Stay comfortable and stay in the race no matter what the weather&#39;s up&nbsp;&nbsp;to. The Bruno Compete Hoodie&#39;s water-repellent exterior shields you from the elements, while advanced fabric technology inside wicks moisture to keep you dry.Stay comfortable and stay in the race no matter what the weather&#39;s up to. The Bruno Compete Hoodie&#39;s water-repellent exterior shields you from the elements, while advanced fabric technology inside wicks moisture to keep you&nbsp;dry.</p>\r\n\r\n<p>&nbsp;</p>\r\n', 16, 0, 'orange', '2023-08-25 02:41:39', '2023-08-25 09:41:39', 'admin', 'Stay comfortable and stay in the race no matter what the weather\'s up to. The Bruno Compete Hoodie\'s water-repellent exterior shields you from the elements, while advanced fabric technology inside wicks moisture to keep you dry.'),
(64, 'QR1237891', 'Strawberry', 15.00, 1.00, 71.00, 'USD', 0.20, 0.10, 'Open', '', 16, 0, 'strawberry', '2023-08-25 02:42:46', '2023-08-25 09:42:46', 'admin', NULL),
(65, 'QR1237892', 'Banana', 150.00, 1.00, -12.00, 'USD', 0.00, 0.00, 'Open', '', 16, 0, 'banana', '2023-08-25 02:43:33', '2023-08-25 09:43:33', 'admin', NULL),
(66, 'QR1237893', 'Lemon', 1500.00, 1.00, 89.00, 'USD', 0.00, 0.10, 'Open', '', 16, 0, 'lemon', '2023-08-25 02:44:33', '2023-08-25 09:44:33', 'admin', NULL),
(67, 'QR1237894', 'Apple', 1500.00, 1.00, 57.00, 'USD', 0.00, 0.10, 'Open', '', 16, 0, 'apple', '2023-08-25 02:45:27', '2023-08-25 09:45:27', 'admin', NULL),
(68, 'QR1237895', 'Earphones', 150.00, 1.00, 85.00, 'USD', 0.00, 0.00, 'Open', '', 17, 0, 'earphones', '2023-08-25 02:46:22', '2023-08-25 09:46:22', 'admin', NULL),
(69, 'QR1237896', 'Earphones2', 150.00, 1.00, 100.00, 'USD', 0.00, 0.00, 'Open', '', 17, 0, 'earphones2', '2023-08-25 02:47:08', '2023-08-25 09:47:08', 'admin', NULL),
(70, 'QR1237897', 'Earphones3', 150.00, 1.00, 100.00, 'USD', 0.00, 0.00, 'Open', '', 17, 0, 'earphones3', '2023-08-25 02:48:00', '2023-08-25 09:48:00', 'admin', NULL),
(71, 'QR123345', 'Sunglasses', 15.00, 1.00, 95.00, 'USD', 0.00, 0.00, 'Closed', '', 18, 0, 'sunglasses', '2023-08-25 02:48:51', '2023-08-25 09:48:51', 'admin', NULL),
(72, 'QR1233434', 'Pendrive', 150.00, 1.00, 97.00, 'USD', 0.00, 0.10, 'Closed', '', 18, 0, 'pendrive', '2023-08-25 02:49:32', '2023-08-25 09:49:32', 'admin', NULL),
(73, 'QR123789233', 'Mouse', 50.00, 1.00, 100.00, 'USD', 0.00, 0.00, 'Open', '', 18, 0, 'mouse', '2023-08-25 02:50:07', '2023-08-25 09:50:07', 'admin', NULL),
(74, 'QR1237899', 'Red nike', 100.00, 1.00, 98.00, 'USD', 0.00, 0.10, 'Closed', '', 19, 0, 'red-nike', '2023-08-25 02:50:45', '2023-08-25 09:50:45', 'admin', NULL),
(75, 'QR12378910', 'Desktop', 1000.00, 1.00, 98.00, 'USD', 0.00, 0.00, 'Closed', '', 20, 0, 'desktop', '2023-08-25 02:51:24', '2023-08-25 09:51:24', 'admin', NULL),
(76, 'QR12378911', 'Duck Salad', 12.00, 1.00, 97.00, 'USD', 0.00, 0.00, 'Closed', '', 21, 0, 'duck-salad', '2023-08-25 02:52:07', '2023-08-25 09:52:07', 'admin', NULL),
(77, 'QR12378912', 'Breakfast board', 14.00, 1.00, 193.00, 'USD', 0.00, 0.00, 'Closed', '', 21, 0, 'breakfast-board', '2023-08-25 02:52:51', '2023-08-25 09:52:51', 'admin', NULL),
(78, 'QR12378913', 'California roll', 14.00, 1.00, 99.00, 'USD', 0.00, 0.00, 'Closed', '', 21, 0, 'california-roll', '2023-08-25 02:53:31', '2023-08-25 09:53:31', 'admin', NULL),
(79, 'QR12378914', 'Sashimi', 15.00, 1.00, 99.00, 'USD', 0.00, 0.10, 'Closed', '', 21, 0, 'sashimi', '2023-08-25 02:54:21', '2023-08-25 09:54:21', 'admin', NULL),
(80, 'QR12378916', 'Watch1', 1500.00, 1.00, 88.00, 'USD', 0.00, 0.00, 'Closed', '', 22, 0, 'watch1', '2023-08-25 02:55:01', '2023-08-25 09:55:01', 'admin', NULL),
(81, 'QR12378917', 'Watch2', 1600.00, 1.00, 100.00, 'USD', 0.00, 0.00, 'Closed', '', 22, 0, 'watch2', '2023-08-25 02:55:35', '2023-08-25 09:55:35', 'admin', NULL),
(82, 'QR12378918', 'Cycle1', 1500.00, 1.00, 100.00, 'USD', 0.00, 0.00, 'Closed', '', 23, 0, 'cycle1', '2023-08-25 02:56:20', '2023-08-25 09:56:20', 'admin', NULL),
(83, 'QR12378920', 'Cycle2', 1600.00, 1.00, 98.00, 'USD', 0.00, 0.00, 'Closed', '', 23, 0, 'cycle2', '2023-08-25 02:56:53', '2023-08-25 09:56:53', 'admin', NULL),
(91, 'QR12378921', 'Orange2', 100.00, 1.00, 100.00, 'USD', 0.00, 0.00, 'Closed', '', 24, 0, 'orange2', '2023-08-25 03:00:55', '2023-08-25 10:00:55', 'admin', NULL),
(92, 'QR12378922', 'Strawberry2', 12.00, 1.00, 100.00, 'USD', 0.00, 0.00, 'Closed', '', 24, 0, 'strawberry2', '2023-08-25 03:01:49', '2023-08-25 10:01:49', 'admin', NULL),
(93, 'QR12378923', 'Banana2', 14.00, 1.00, 100.00, 'USD', 0.00, 0.00, 'Open', '', 24, 0, 'banana2', '2023-08-25 03:02:26', '2023-08-25 10:02:26', 'admin', NULL),
(94, 'QR12378925', 'Limon', 15.00, 1.00, 100.00, 'USD', 0.00, 0.00, 'Closed', '', 24, 0, 'limon', '2023-08-25 03:03:04', '2023-08-25 10:03:04', 'admin', NULL),
(95, 'QR12378926', 'Earphones4', 1500.00, 1.00, 100.00, 'USD', 0.00, 0.00, 'Open', '', 25, 0, 'earphones4', '2023-08-25 03:03:38', '2023-08-25 10:03:38', 'admin', NULL),
(97, 'QR12378928', 'Earphones', 1400.00, 1.00, 100.00, 'USD', 0.00, 0.10, 'Closed', '', 25, 0, 'earphones', '2023-08-25 03:05:09', '2023-08-25 10:05:09', 'admin', NULL),
(101, 'QR12334347', 'cream_test', 150.00, 1.00, 100.00, 'USD', 0.20, 0.10, 'Open', '<p>sdsd</p>\r\n', 21, 0, 'cream-test', '2024-04-08 17:02:59', '2024-04-09 00:02:59', 'admin', 'Ideal for cold-weathered training worked lorem ipsum outdoors, the Chaz Hoodie promises superior warmth with every wear. Thick material blocks out the wind as ribbed cuffs and bottom band seal in body heat Lorem ipsum dolor sit amet, consectetur adipisicing elit. Enim, reprehenderit.');

--
-- Bẫy `product`
--
DELIMITER $$
CREATE TRIGGER `SetCreatedAt` BEFORE INSERT ON `product` FOR EACH ROW BEGIN
    IF NEW.created_at IS NULL THEN
        SET NEW.created_at = NOW();
    END IF;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `SetCreatedAt_customer` BEFORE INSERT ON `product` FOR EACH ROW BEGIN
    SET NEW.created_at = NOW();
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `SetCreatedAt_product` BEFORE INSERT ON `product` FOR EACH ROW BEGIN
    SET NEW.created_at = NOW();
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `SetCreatedAt_usercustomer` BEFORE INSERT ON `product` FOR EACH ROW BEGIN
    SET NEW.created_at = NOW();
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `after_product_delete` AFTER DELETE ON `product` FOR EACH ROW BEGIN
    DELETE FROM image_product WHERE product_id = OLD.id;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `quotation`
--

CREATE TABLE `quotation` (
  `quotation_id` bigint(20) NOT NULL,
  `reference` varchar(100) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `status` varchar(100) DEFAULT NULL,
  `total` decimal(10,2) NOT NULL,
  `tax` decimal(10,2) DEFAULT NULL,
  `discount` decimal(10,2) DEFAULT NULL,
  `grand_total` decimal(10,2) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `quotation`
--

INSERT INTO `quotation` (`quotation_id`, `reference`, `email`, `status`, `total`, `tax`, `discount`, `grand_total`, `description`, `created_at`, `updated_at`) VALUES
(8, 'IVO001', 'hoangnhan@gmail.com', 'Ordered', 1950.00, 0.30, 0.10, 2340.00, 'aaabbb', '2023-09-07 00:00:00', '2023-09-07 13:56:15'),
(9, 'IVO002', '2156210125@gmail.com', 'Send', 349.50, 0.10, 0.00, 384.45, 'bbb', '2023-09-07 00:00:00', '2023-09-07 14:04:06'),
(11, 'IVO003', 'hoangnhan@gmail.com', 'Send', 195.00, 0.10, 0.33, 150.15, 'sdssd', '2023-09-07 00:00:00', '2023-09-07 15:05:26'),
(12, 'IVO004', '2156210125@gmail.com', 'Ordered', 150.00, 0.10, 0.25, 127.50, '', '2024-04-19 00:00:00', '2024-04-04 02:55:27');

--
-- Bẫy `quotation`
--
DELIMITER $$
CREATE TRIGGER `SetCreatedAt_quotationfinal` BEFORE INSERT ON `quotation` FOR EACH ROW BEGIN
    IF NEW.created_at IS NULL THEN
        SET NEW.created_at = NOW();
    END IF;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `before_insert_quotation_reference` BEFORE INSERT ON `quotation` FOR EACH ROW BEGIN
    DECLARE next_id INT;

    -- Lấy phần số thứ tự tiếp theo từ chuỗi reference
    SELECT IFNULL(MAX(CAST(SUBSTRING_INDEX(reference, 'IVO', -1) AS UNSIGNED)), 0) INTO next_id FROM quotation;

    -- Tính toán giá trị tiếp theo
    SET next_id = next_id + 1;

    -- Nếu không có giá trị tiếp theo hoặc reference của bản ghi mới là NULL, bắt đầu từ SLO001
    IF next_id IS NULL AND NEW.reference IS NULL THEN
        SET NEW.reference = 'IVO001';
    ELSE
        -- Tạo giá trị mới cho reference với định dạng 'SLOxxx'
        SET NEW.reference = CONCAT('IVO', LPAD(next_id, 3, '0'));
    END IF;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `quotation_detail`
--

CREATE TABLE `quotation_detail` (
  `quotation_id` bigint(20) NOT NULL,
  `product_id` bigint(20) NOT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  `tax` decimal(10,2) DEFAULT NULL,
  `discount` decimal(10,2) DEFAULT NULL,
  `minium_quantity` decimal(10,2) DEFAULT NULL,
  `quantity` decimal(10,2) DEFAULT NULL,
  `total` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `quotation_detail`
--

INSERT INTO `quotation_detail` (`quotation_id`, `product_id`, `price`, `tax`, `discount`, `minium_quantity`, `quantity`, `total`) VALUES
(8, 68, 150.00, 0.00, 0.00, 1.00, 7.00, 1050.00),
(8, 69, 150.00, 0.00, 0.00, 1.00, 6.00, 900.00),
(9, 64, 15.00, 0.20, 0.10, 1.00, 3.00, 49.50),
(9, 71, 15.00, 0.00, 0.00, 1.00, 2.00, 30.00),
(9, 72, 150.00, 0.00, 0.10, 1.00, 2.00, 270.00),
(11, 69, 150.00, 0.00, 0.00, 1.00, 1.00, 150.00),
(11, 71, 15.00, 0.00, 0.00, 1.00, 3.00, 45.00),
(12, 69, 150.00, 0.00, 0.00, 1.00, 1.00, 150.00);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `sale`
--

CREATE TABLE `sale` (
  `sale_id` bigint(20) NOT NULL,
  `reference` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `status` varchar(255) DEFAULT NULL,
  `payment` varchar(255) DEFAULT NULL,
  `total` decimal(10,2) DEFAULT NULL,
  `tax` decimal(10,2) DEFAULT NULL,
  `ship` decimal(10,2) DEFAULT NULL,
  `grand_total` decimal(10,2) DEFAULT NULL,
  `paid` decimal(10,2) DEFAULT NULL,
  `due` decimal(10,2) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `biller` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `discount_id` bigint(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `sale`
--

INSERT INTO `sale` (`sale_id`, `reference`, `email`, `status`, `payment`, `total`, `tax`, `ship`, `grand_total`, `paid`, `due`, `description`, `biller`, `created_at`, `updated_at`, `discount_id`) VALUES
(123, 'SLO005', '2156210125@gmail.com', 'Pending', 'Due', 27.50, 0.00, 0.00, 27.50, 0.00, 27.50, '', 'admin', '2023-09-03 00:56:47', '2023-09-02 17:56:47', 0),
(125, 'SLO007', 'hoangnhan@gmail.com', 'Pending', 'Due', 1516.50, 0.00, 0.00, 1213.20, 1000.00, 213.20, '', NULL, '2023-09-03 01:11:44', '2023-09-02 18:11:44', 6),
(127, 'SLO009', 'hoangnhan@gmail.com', 'Pending', 'Due', 2838.00, 0.00, 0.00, 2270.40, 0.00, 2270.40, '', NULL, '2023-09-03 01:14:31', '2023-09-02 18:14:31', 6),
(128, 'SLO010', '21562101253@gmail.com', 'Complete', 'Paid', 1500.00, 0.00, 0.00, 1200.00, 1200.00, 0.00, '', NULL, '2023-09-03 01:15:59', '2023-09-02 18:15:59', 6),
(129, 'SLO011', '21562101253@gmail.com', 'Complete', 'Paid', 1516.50, 0.00, 0.00, 1213.20, 1213.20, 0.00, '', NULL, '2023-09-03 01:17:48', '2023-09-02 18:17:48', 6),
(130, 'SLO012', '21562101253@gmail.com', 'Complete', 'Paid', 1516.50, 0.00, 0.00, 1213.20, 1213.20, 0.00, '', NULL, '2023-09-03 01:18:42', '2023-09-02 18:18:42', 6),
(131, 'SLO013', '2156210125@gmail.com', 'Complete', 'Paid', 1654.50, 0.00, 0.00, 1323.60, 1323.60, 0.00, '', NULL, '2023-09-03 01:20:41', '2023-09-02 18:20:41', 6),
(133, 'SLO014', '21562101253@gmail.com', 'Pending', 'Due', 1500.00, 0.00, 0.00, 1500.00, 0.00, 1500.00, '', NULL, '2023-09-03 10:23:27', '2023-09-03 03:23:27', 0),
(134, 'SLO015', '21562101253@gmail.com', 'Pending', 'Due', 535.00, 0.00, 0.00, 428.00, 0.00, 428.00, '', NULL, '2023-09-09 00:00:00', '2023-09-03 07:52:19', 6),
(135, 'SLO016', 'hoangnhan@gmail.com', 'Pending', 'Due', 42.00, 0.00, 30.00, 72.00, 0.00, 72.00, 'sdsds', NULL, '2023-09-02 00:00:00', '2023-09-04 21:36:23', 0),
(136, 'SLO017', '2156210125@gmail.com', 'Pending', 'Paid', 2000.00, 0.00, 30.00, 2030.00, 2030.00, 0.00, '', NULL, '2023-09-05 23:20:58', '2023-09-05 16:20:58', 0),
(137, 'SLO018', '', '', 'Due', 150.00, 0.00, 0.00, 150.00, 0.00, 150.00, '', NULL, '2023-09-14 10:09:31', '2023-09-14 03:09:31', 0),
(138, 'SLO019', 'hoangnhan@gmail.com', 'Complete', 'Paid', 166.50, 0.20, 30.00, 229.80, 229.80, 0.00, '', NULL, '2024-04-03 00:00:00', '2024-04-04 14:58:36', 0),
(139, 'SLO020', '21562101253@gmail.com', 'Complete', 'Paid', 150.00, 0.00, 30.00, 180.00, 180.00, 0.00, '', NULL, '2024-04-10 00:00:00', '2024-04-06 01:43:15', 0),
(140, 'SLO021', '21562101253@gmail.com', '', 'Due', 135.00, 0.00, 0.00, 135.00, 0.00, 135.00, '', NULL, '2024-04-06 08:59:11', '2024-04-06 01:59:11', 0),
(162, 'SLO022', '2156210167@gmail.com', 'Complete', 'Paid', 166.50, 0.00, 0.00, 166.50, 166.50, 0.00, '', NULL, '2024-04-06 20:59:25', '2024-04-06 13:59:25', 0),
(171, 'SLO023', '2156210100@gmail.com', 'Pending', 'Due', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-04-08 16:07:24', '2024-04-08 09:07:24', NULL),
(172, 'SLO024', '2156210100@gmail.com', 'Pending', 'Due', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-04-08 22:00:26', '2024-04-08 15:00:26', NULL),
(173, 'SLO025', '2156210100@gmail.com', 'Pending', 'Due', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-04-08 22:19:08', '2024-04-08 15:19:08', NULL),
(174, 'SLO026', '2156210100@gmail.com', 'Pending', 'Due', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-04-09 00:15:00', '2024-04-08 17:15:00', NULL),
(175, 'SLO027', '2156210100@gmail.com', 'Pending', 'Due', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-04-09 00:15:11', '2024-04-08 17:15:11', NULL),
(176, 'SLO028', '2156210100@gmail.com', 'Pending', 'Due', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-04-09 00:16:18', '2024-04-08 17:16:18', NULL),
(177, 'SLO029', '2156210100@gmail.com', 'Pending', 'Due', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-04-09 00:18:58', '2024-04-08 17:18:58', NULL),
(178, 'SLO030', '2156210100@gmail.com', 'Pending', 'Due', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-04-09 00:19:34', '2024-04-08 17:19:34', NULL),
(179, 'SLO031', '2156210100@gmail.com', 'Pending', 'Due', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-04-09 00:26:09', '2024-04-08 17:26:09', NULL);

--
-- Bẫy `sale`
--
DELIMITER $$
CREATE TRIGGER `SetCreatedAt_sale` BEFORE INSERT ON `sale` FOR EACH ROW BEGIN
    IF NEW.created_at IS NULL THEN
        SET NEW.created_at = NOW();
    END IF;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `before_insert_sale_reference` BEFORE INSERT ON `sale` FOR EACH ROW BEGIN
    DECLARE next_id INT;

    -- Lấy phần số thứ tự tiếp theo từ chuỗi reference
    SELECT IFNULL(MAX(CAST(SUBSTRING_INDEX(reference, 'SLO', -1) AS UNSIGNED)), 0) INTO next_id FROM sale;

    -- Tính toán giá trị tiếp theo
    SET next_id = next_id + 1;

    -- Nếu không có giá trị tiếp theo hoặc reference của bản ghi mới là NULL, bắt đầu từ SLO001
    IF next_id IS NULL AND NEW.reference IS NULL THEN
        SET NEW.reference = 'SLO001';
    ELSE
        -- Tạo giá trị mới cho reference với định dạng 'SLOxxx'
        SET NEW.reference = CONCAT('SLO', LPAD(next_id, 3, '0'));
    END IF;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `inserttrigger_status_payment` BEFORE INSERT ON `sale` FOR EACH ROW BEGIN
    IF NEW.status = 'Complete' THEN
        SET NEW.payment = 'Paid';
    END IF;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `update_payment_status` BEFORE UPDATE ON `sale` FOR EACH ROW BEGIN
    IF NEW.status = 'Complete' THEN
        SET NEW.payment = 'Paid';
    END IF;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `sale_detail`
--

CREATE TABLE `sale_detail` (
  `sale_id` bigint(20) NOT NULL,
  `product_id` bigint(20) NOT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  `tax` decimal(10,2) DEFAULT NULL,
  `discount` decimal(10,2) DEFAULT NULL,
  `minium_quantity` decimal(10,2) DEFAULT NULL,
  `quantity` decimal(10,2) DEFAULT NULL,
  `total` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `sale_detail`
--

INSERT INTO `sale_detail` (`sale_id`, `product_id`, `price`, `tax`, `discount`, `minium_quantity`, `quantity`, `total`) VALUES
(127, 63, 0.00, 0.00, 0.00, 0.00, 1.00, 138.00),
(131, 63, 0.00, 0.00, 0.00, 0.00, 1.00, 138.00),
(140, 63, 150.00, 0.00, 0.10, 1.00, 1.00, 135.00),
(163, 63, NULL, NULL, NULL, NULL, 1.00, NULL),
(168, 63, NULL, NULL, NULL, NULL, 1.00, NULL),
(170, 63, NULL, NULL, NULL, NULL, 1.00, NULL),
(171, 63, NULL, NULL, NULL, NULL, 1.00, NULL),
(173, 63, NULL, NULL, NULL, NULL, 1.00, NULL),
(177, 63, NULL, NULL, NULL, NULL, 2.00, NULL),
(179, 63, NULL, NULL, NULL, NULL, 1.00, NULL),
(125, 64, 0.00, 0.00, 0.00, 0.00, 1.00, 16.50),
(129, 64, 0.00, 0.00, 0.00, 0.00, 1.00, 16.50),
(130, 64, 0.00, 0.00, 0.00, 0.00, 1.00, 16.50),
(131, 64, 0.00, 0.00, 0.00, 0.00, 1.00, 16.50),
(138, 64, 15.00, 0.20, 0.10, 1.00, 1.00, 16.50),
(162, 64, 15.00, 0.20, 0.10, 1.00, 1.00, 16.50),
(125, 65, 0.00, 0.00, 0.00, 0.00, 1.00, 150.00),
(128, 65, 0.00, 0.00, 0.00, 0.00, 1.00, 150.00),
(129, 65, 0.00, 0.00, 0.00, 0.00, 1.00, 150.00),
(130, 65, 0.00, 0.00, 0.00, 0.00, 1.00, 150.00),
(131, 65, 0.00, 0.00, 0.00, 0.00, 1.00, 150.00),
(133, 65, 0.00, 0.00, 0.00, 0.00, 1.00, 150.00),
(137, 65, 150.00, 0.00, 0.00, 1.00, 1.00, 150.00),
(138, 65, 150.00, 0.00, 0.00, 1.00, 1.00, 150.00),
(139, 65, 150.00, 0.00, 0.00, 1.00, 1.00, 150.00),
(162, 65, 150.00, 0.00, 0.00, 1.00, 1.00, 150.00),
(177, 65, NULL, NULL, NULL, NULL, 1.00, NULL),
(125, 66, 0.00, 0.00, 0.00, 0.00, 1.00, 1350.00),
(127, 66, 0.00, 0.00, 0.00, 0.00, 1.00, 1350.00),
(128, 66, 0.00, 0.00, 0.00, 0.00, 1.00, 1350.00),
(129, 66, 0.00, 0.00, 0.00, 0.00, 1.00, 1350.00),
(130, 66, 0.00, 0.00, 0.00, 0.00, 1.00, 1350.00),
(131, 66, 0.00, 0.00, 0.00, 0.00, 1.00, 1350.00),
(133, 66, 0.00, 0.00, 0.00, 0.00, 1.00, 1350.00),
(178, 66, NULL, NULL, NULL, NULL, 1.00, NULL),
(127, 67, 0.00, 0.00, 0.00, 0.00, 1.00, 1350.00),
(172, 68, NULL, NULL, NULL, NULL, 1.00, NULL),
(134, 69, 150.00, 0.00, 0.00, 1.00, 2.00, 300.00),
(134, 72, 150.00, 0.00, 0.10, 1.00, 1.00, 135.00),
(134, 73, 50.00, 0.00, 0.00, 1.00, 2.00, 100.00),
(136, 75, 1000.00, 0.00, 0.00, 1.00, 2.00, 2000.00),
(116, 76, 0.00, 0.00, 0.00, 0.00, 2.00, 24.00),
(116, 77, 0.00, 0.00, 0.00, 0.00, 2.00, 28.00),
(135, 77, 14.00, 0.00, 0.00, 1.00, 2.00, 28.00),
(123, 78, 0.00, 0.00, 0.00, 0.00, 1.00, 14.00),
(135, 78, 14.00, 0.00, 0.00, 1.00, 1.00, 14.00),
(123, 79, 0.00, 0.00, 0.00, 0.00, 1.00, 13.50);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `sale_return`
--

CREATE TABLE `sale_return` (
  `id` bigint(20) NOT NULL,
  `sale_id` bigint(20) NOT NULL,
  `reference` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `product_id` bigint(20) NOT NULL,
  `quantity` decimal(10,2) DEFAULT NULL,
  `status` varchar(255) DEFAULT NULL,
  `payment` varchar(255) DEFAULT NULL,
  `total` decimal(10,2) DEFAULT NULL,
  `tax` decimal(10,2) DEFAULT NULL,
  `discount` decimal(10,2) DEFAULT NULL,
  `grand_total` decimal(10,2) DEFAULT NULL,
  `paid` decimal(10,2) DEFAULT NULL,
  `due` decimal(10,2) DEFAULT NULL,
  `reason` text DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `sale_return`
--

INSERT INTO `sale_return` (`id`, `sale_id`, `reference`, `email`, `product_id`, `quantity`, `status`, `payment`, `total`, `tax`, `discount`, `grand_total`, `paid`, `due`, `reason`, `created_at`, `updated_at`) VALUES
(141, 134, 'SRT001', '21562101253@gmail.com', 72, 1.00, 'Complete', 'Paid', 135.00, 0.00, 27.00, 108.00, 108.00, 0.00, 'dfdfd', '2023-09-05 00:00:00', '2023-09-05 04:07:27'),
(142, 117, 'SRT001', '2156210125@gmail.com', 67, 4.00, 'Complete', 'Paid', 5400.00, 0.20, 1080.00, 5400.00, 5400.00, 0.00, 'sdsdssds', '2024-04-05 00:00:00', '2023-09-05 16:06:37'),
(143, 134, 'SRT002', '21562101253@gmail.com', 73, 2.00, 'Pending', 'Paid', 100.00, 0.00, 20.00, 80.00, 0.00, 80.00, '', '2023-09-09 00:00:00', '2023-09-05 16:18:55');

--
-- Bẫy `sale_return`
--
DELIMITER $$
CREATE TRIGGER `SetCreatedAt_sale_return` BEFORE INSERT ON `sale_return` FOR EACH ROW BEGIN
    IF NEW.created_at IS NULL THEN
        SET NEW.created_at = NOW();
    END IF;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `before_insert_sale_reference__return` BEFORE INSERT ON `sale_return` FOR EACH ROW BEGIN
    DECLARE next_id INT;

    -- Lấy phần số thứ tự tiếp theo từ chuỗi reference
    SELECT IFNULL(MAX(CAST(SUBSTRING_INDEX(reference, 'SRT', -1) AS UNSIGNED)), 0) INTO next_id FROM sale_return;

    -- Tính toán giá trị tiếp theo
    SET next_id = next_id + 1;

    -- Nếu không có giá trị tiếp theo hoặc reference của bản ghi mới là NULL, bắt đầu từ SRT001
    IF next_id IS NULL AND NEW.reference IS NULL THEN
        SET NEW.reference = 'SRT001';
    ELSE
        -- Tạo giá trị mới cho reference với định dạng 'SRTxxx'
        SET NEW.reference = CONCAT('SRT', LPAD(next_id, 3, '0'));
    END IF;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `inserttrigger_status_payment_return` BEFORE INSERT ON `sale_return` FOR EACH ROW BEGIN
    IF NEW.status = 'Complete' THEN
        SET NEW.payment = 'Paid';
    END IF;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `update_payment_status_return` BEFORE UPDATE ON `sale_return` FOR EACH ROW BEGIN
    IF NEW.status = 'Complete' THEN
        SET NEW.payment = 'Paid';
    END IF;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `supplier`
--

CREATE TABLE `supplier` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `type` varchar(50) DEFAULT NULL,
  `country` varchar(100) DEFAULT NULL,
  `city` varchar(100) DEFAULT NULL,
  `district` varchar(100) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `zipcode` varchar(20) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `code` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `supplier`
--

INSERT INTO `supplier` (`id`, `name`, `phone`, `image`, `email`, `type`, `country`, `city`, `district`, `address`, `zipcode`, `description`, `code`, `created_at`, `updated_at`) VALUES
(23, 'Công ty 2', '0976887887', '../upload/supplier/customer5.jpg', 'cskhhoangnhan23@gmail.com', 'Choose Type', 'Aland Islands', 'Select State', 'Choose District', '23232', '3423232', '232323', 'SP005', NULL, '2023-09-02 14:36:05');

--
-- Bẫy `supplier`
--
DELIMITER $$
CREATE TRIGGER `trg_before_insert_supplier_reference` BEFORE INSERT ON `supplier` FOR EACH ROW BEGIN
    DECLARE new_code VARCHAR(10);
    SET new_code = CONCAT('SP', LPAD((SELECT COUNT(*) + 1 FROM customer), 3, '0'));
    SET NEW.code = new_code;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `trash_image_product`
--

CREATE TABLE `trash_image_product` (
  `id` int(20) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `product_trash_id` bigint(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `trash_image_product`
--

INSERT INTO `trash_image_product` (`id`, `image`, `product_trash_id`) VALUES
(16, 'C:\\xampp\\htdocs/admin-page/trash/64e5df7aa7546.jpg', 55),
(17, 'C:\\xampp\\htdocs/admin-page/trash/64e5df7aab536.jpg', 55),
(18, 'C:\\xampp\\htdocs/admin-page/trash/64e5e05c31446.jpg', 56),
(19, 'C:\\xampp\\htdocs/admin-page/trash/64e5e05c33569.jpg', 56),
(20, 'C:\\xampp\\htdocs/admin-page/trash/64e61e26ac60d.jpg', 58),
(21, 'C:\\xampp\\htdocs/admin-page/trash/64e61e26b5753.jpg', 58),
(22, 'C:\\xampp\\htdocs/admin-page/trash/64e624055b82b.jpg', 61),
(23, 'C:/xampp/htdocs/admin-page/trash/64e793032af30.jpg', 62),
(24, 'C:/xampp/htdocs/admin-page/trash/64e81a7530942.jpg', 96),
(25, 'C:/xampp/htdocs/admin-page/trash/6613cfab0dbca.png', 100);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `trash_product`
--

CREATE TABLE `trash_product` (
  `id` bigint(20) NOT NULL,
  `product_id` bigint(20) NOT NULL,
  `sku` varchar(255) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  `minium_quantity` int(11) DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL,
  `unit` varchar(50) DEFAULT NULL,
  `tax` float DEFAULT NULL,
  `discount` float DEFAULT NULL,
  `status` varchar(30) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `categoryproduct_id` int(11) DEFAULT NULL,
  `subcategoryproduct_id` int(11) DEFAULT NULL,
  `slug` varchar(1000) DEFAULT NULL,
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `created_at` datetime DEFAULT NULL,
  `created_by` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `trash_product`
--

INSERT INTO `trash_product` (`id`, `product_id`, `sku`, `name`, `price`, `minium_quantity`, `quantity`, `unit`, `tax`, `discount`, `status`, `description`, `categoryproduct_id`, `subcategoryproduct_id`, `slug`, `updated_at`, `created_at`, `created_by`) VALUES
(4, 55, 'QR123789', 'cream', 1212121.00, 21212, 12121, 'USD', 0, 0, 'Closed', '<p>1212</p>\r\n', 1, 0, 'cream', '2023-08-23 10:29:14', NULL, 'admin'),
(5, 56, 'QR123789', 'cream', 2333.00, 112, 12, 'INR', 0, 0, 'Closed', '<p>123</p>\r\n', 1, 0, 'cream', '2023-08-23 10:33:00', NULL, 'manager'),
(6, 58, 'QR123789', 'cream', 23232.00, 232, 23232, 'INR', 0, 0, 'Closed', '<p>323</p>\r\n', 10, NULL, 'cream', '2023-08-23 14:56:38', NULL, 'manager'),
(7, 61, 'QR123789', 'yaout', 23233.00, 23, 232, 'USD', 0, 0, 'Closed', '<p>2323</p>\r\n', 11, NULL, 'yaout', '2023-08-23 15:21:41', NULL, 'manager'),
(8, 62, 'QR123', 'yaout', 233232.00, 232, 2323, 'USD', 0, 0, 'Closed', '', 11, NULL, 'yaout', '2023-08-24 17:27:31', NULL, 'manager'),
(9, 84, 'QR123789', 'Orange', 150.00, 1, 1000, 'USD', 0.2, 0.1, 'Open', '', 24, NULL, 'orange', '2023-08-25 02:59:34', NULL, 'admin'),
(10, 85, 'QR1237891', 'Strawberry', 15.00, 1, 100, 'USD', 0.2, 0.1, 'Open', '', 24, NULL, 'strawberry', '2023-08-25 02:59:40', NULL, 'admin'),
(11, 86, 'QR1237892', 'Banana', 150.00, 1, 100, 'USD', 0, 0, 'Open', '', 24, NULL, 'banana', '2023-08-25 02:59:45', NULL, 'admin'),
(12, 87, 'QR1237893', 'Lemon', 1500.00, 1, 100, 'USD', 0.2, 0.1, 'Open', '', 24, NULL, 'lemon', '2023-08-25 02:59:51', NULL, 'admin'),
(13, 88, 'QR1237895', 'Earphones', 150.00, 1, 100, 'USD', 0, 0, 'Open', '', 25, NULL, 'earphones', '2023-08-25 02:59:56', NULL, 'admin'),
(14, 89, 'QR1237896', 'Earphones2', 150.00, 1, 100, 'USD', 0.2, 0, 'Open', '', 25, NULL, 'earphones2', '2023-08-25 03:00:01', NULL, 'admin'),
(15, 90, 'QR1237897', 'Earphones3', 150.00, 1, 100, 'USD', 0.2, 0, 'Open', '', 25, NULL, 'earphones3', '2023-08-25 03:00:06', NULL, 'admin'),
(16, 96, 'QR12378927', 'e5', 1500.00, 1, 100, 'USD', 0, 0.1, 'Closed', '', 24, NULL, 'e5', '2023-08-25 03:05:25', NULL, 'admin'),
(17, 98, 'QR123789', 'Orangexcx', 232323.00, 232, 2323, 'USD', 0, 0, 'Closed', '', 16, NULL, 'orangexcx', '2023-08-29 19:18:01', NULL, 'manager'),
(18, 99, 'QR12378928', 'Earphones', 1400.00, 1, 100, 'USD', 0, 0.1, 'Closed', '', 25, NULL, 'earphones', '2023-08-29 19:19:31', NULL, 'admin'),
(19, 100, 'QR123456', 'mecedes02', 50.00, 1, 100, 'USD', 0.2, 0.1, 'Open', '<p><img alt=\"Khóa học kinh doanh khóa học\" src=\"https://mona.media/wp-content/uploads/2024/04/banner-khoa-hoc.png\" /></p>\r\n', 20, NULL, 'mecedes02', '2024-04-08 11:06:19', NULL, 'manager');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `user_customer`
--

CREATE TABLE `user_customer` (
  `id` bigint(20) NOT NULL,
  `customer_id` int(11) DEFAULT NULL,
  `first_name` varchar(255) DEFAULT NULL,
  `last_name` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `status` tinyint(1) DEFAULT 1,
  `email` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `user_customer`
--

INSERT INTO `user_customer` (`id`, `customer_id`, `first_name`, `last_name`, `password`, `status`, `email`, `created_at`, `updated_at`) VALUES
(1, 11, 'Quốc', 'Hoàng Xuân', 'Hoangquoc318', 1, '2156210125@gmail.com', NULL, '2023-08-25 02:05:06'),
(4, NULL, 'Quốc', 'Hoàng Xuân', '$2y$10$djFGkT9qULlomGPpQxTRAOiPfW/IzjI2P7LDO.sYSDLxAPegrbsoK', 1, '216210125@gmail.com', NULL, '2023-08-25 02:05:06'),
(6, NULL, 'Quốc', 'Hoàng Xuân', '$2y$10$x7WPVPEiG62KUKNAC.w/Vuu0.mWoxvb1hAh0fFtPOyBGjjHG.LxC.', 1, '2156210000@gmail.com', NULL, '2024-04-06 05:32:06'),
(7, NULL, 'Nguyễn ', 'Thành Công', '$2y$10$l6VLKK6Vno9ekKgTeP4M/e0OjR7g0lALXUVTa6ts05Uw8.Kna/Zmi', 1, '1907htng@gmail.com', NULL, '2024-04-06 06:26:41'),
(8, NULL, 'Hoàng Xuân', 'Thành', '$2y$10$aPrjfh1dNbrBEX3JwKj8FuWRBCuqMxXjYZaH7EGZwCAwIJiK729cO', 1, '2156210166@gmail.com', NULL, '2024-04-06 08:29:52'),
(9, NULL, 'Hoàng Xuân Thành', 'nhân', '$2y$10$nNCciYbOcw66g1WfKjLP0eJMVoeDEMEwSQUmPGhJPCaAoiDCwJLoC', 1, '2156210167@gmail.com', NULL, '2024-04-06 08:32:17'),
(10, NULL, 'Nguyễn THành', 'Tân', '$2y$10$BykSThXGrmLT64xT/Xa1rei5Xyhmc8jhHxWSKGa0Qz/znC3g.xxDu', 1, '2156210100@gmail.com', NULL, '2024-04-08 08:31:46');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `user_manager`
--

CREATE TABLE `user_manager` (
  `id` int(11) NOT NULL,
  `firstname` varchar(255) DEFAULT NULL,
  `lastname` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `role` varchar(255) DEFAULT NULL,
  `status` varchar(100) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `user_manager`
--

INSERT INTO `user_manager` (`id`, `firstname`, `lastname`, `email`, `phone`, `password`, `role`, `status`, `image`, `created_at`) VALUES
(9, 'Hoang', 'Xuanquoc', 'hxqduccopny@gmail.com', '0393643357', '$2y$10$FB0/soFsESwD7riU9bncLu1lBG1qbubqGQtdZU8hV98MRSlZA2bb6', 'Manager', 'Active', '../upload/usermanager/6501fb0581ebb_Screenshot 2023-0.png', '2023-09-12 03:45:10'),
(10, 'Nguyen', 'Nhan', 'hoangnhan@hcmussh.edu.vn', '0926623782', '$2y$10$cnJRIaD2tiwMwkYGZytVsesAmTYxxJehuOiWdMiHDSs8IUMKBvGfa', 'Admin', 'Active', '../upload/usermanager/avatar-13.jpg', '2023-09-14 16:20:19'),
(11, 'Tran ', 'Dai', 'trandai@hcmussh.edu.vn', '02365458125', '$2y$10$uZ.aCWafWte0BCdnCiNO8eujah5iCYWXQANny0VfV/W4RSE./Z6fO', 'Salesman', 'Active', '../upload/usermanager/avatar-17.jpg', '2023-09-14 16:21:11');

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `blog`
--
ALTER TABLE `blog`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`cart_id`);

--
-- Chỉ mục cho bảng `categoryproduct`
--
ALTER TABLE `categoryproduct`
  ADD PRIMARY KEY (`categoryproduct_id`);

--
-- Chỉ mục cho bảng `category_blog`
--
ALTER TABLE `category_blog`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `category_expense`
--
ALTER TABLE `category_expense`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `category_sub`
--
ALTER TABLE `category_sub`
  ADD PRIMARY KEY (`category_sub_id`);

--
-- Chỉ mục cho bảng `customer`
--
ALTER TABLE `customer`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Chỉ mục cho bảng `discount`
--
ALTER TABLE `discount`
  ADD PRIMARY KEY (`discount_id`);

--
-- Chỉ mục cho bảng `email_setting`
--
ALTER TABLE `email_setting`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `expense`
--
ALTER TABLE `expense`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `general_setting`
--
ALTER TABLE `general_setting`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `image_product`
--
ALTER TABLE `image_product`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `notification`
--
ALTER TABLE `notification`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `payment_detail`
--
ALTER TABLE `payment_detail`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `payment_return_detail`
--
ALTER TABLE `payment_return_detail`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `payment_type`
--
ALTER TABLE `payment_type`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `quotation`
--
ALTER TABLE `quotation`
  ADD PRIMARY KEY (`quotation_id`);

--
-- Chỉ mục cho bảng `quotation_detail`
--
ALTER TABLE `quotation_detail`
  ADD PRIMARY KEY (`quotation_id`,`product_id`);

--
-- Chỉ mục cho bảng `sale`
--
ALTER TABLE `sale`
  ADD PRIMARY KEY (`sale_id`);

--
-- Chỉ mục cho bảng `sale_detail`
--
ALTER TABLE `sale_detail`
  ADD PRIMARY KEY (`product_id`,`sale_id`);

--
-- Chỉ mục cho bảng `sale_return`
--
ALTER TABLE `sale_return`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `supplier`
--
ALTER TABLE `supplier`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Chỉ mục cho bảng `trash_image_product`
--
ALTER TABLE `trash_image_product`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `trash_product`
--
ALTER TABLE `trash_product`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `user_customer`
--
ALTER TABLE `user_customer`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `user_manager`
--
ALTER TABLE `user_manager`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `blog`
--
ALTER TABLE `blog`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT cho bảng `cart`
--
ALTER TABLE `cart`
  MODIFY `cart_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=53;

--
-- AUTO_INCREMENT cho bảng `categoryproduct`
--
ALTER TABLE `categoryproduct`
  MODIFY `categoryproduct_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT cho bảng `category_blog`
--
ALTER TABLE `category_blog`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT cho bảng `category_expense`
--
ALTER TABLE `category_expense`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT cho bảng `category_sub`
--
ALTER TABLE `category_sub`
  MODIFY `category_sub_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT cho bảng `customer`
--
ALTER TABLE `customer`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;

--
-- AUTO_INCREMENT cho bảng `discount`
--
ALTER TABLE `discount`
  MODIFY `discount_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT cho bảng `email_setting`
--
ALTER TABLE `email_setting`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT cho bảng `expense`
--
ALTER TABLE `expense`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT cho bảng `general_setting`
--
ALTER TABLE `general_setting`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT cho bảng `image_product`
--
ALTER TABLE `image_product`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=115;

--
-- AUTO_INCREMENT cho bảng `notification`
--
ALTER TABLE `notification`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `payment_detail`
--
ALTER TABLE `payment_detail`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=75;

--
-- AUTO_INCREMENT cho bảng `payment_return_detail`
--
ALTER TABLE `payment_return_detail`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT cho bảng `payment_type`
--
ALTER TABLE `payment_type`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT cho bảng `product`
--
ALTER TABLE `product`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=102;

--
-- AUTO_INCREMENT cho bảng `quotation`
--
ALTER TABLE `quotation`
  MODIFY `quotation_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT cho bảng `sale`
--
ALTER TABLE `sale`
  MODIFY `sale_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=180;

--
-- AUTO_INCREMENT cho bảng `sale_return`
--
ALTER TABLE `sale_return`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=144;

--
-- AUTO_INCREMENT cho bảng `supplier`
--
ALTER TABLE `supplier`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT cho bảng `trash_image_product`
--
ALTER TABLE `trash_image_product`
  MODIFY `id` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT cho bảng `trash_product`
--
ALTER TABLE `trash_product`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT cho bảng `user_customer`
--
ALTER TABLE `user_customer`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT cho bảng `user_manager`
--
ALTER TABLE `user_manager`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- Các ràng buộc cho các bảng đã đổ
--

--
-- Các ràng buộc cho bảng `sale_detail`
--
ALTER TABLE `sale_detail`
  ADD CONSTRAINT `sale_detail_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `product` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
