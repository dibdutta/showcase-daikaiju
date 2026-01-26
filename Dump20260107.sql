--
-- Dumping routines for database 'mpe'
--
/*!50003 DROP FUNCTION IF EXISTS `cond` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'STRICT_TRANS_TABLES,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` FUNCTION `cond`(poster_id INT) READS SQL DATA RETURNS varchar(100) CHARSET latin1
BEGIN
 DECLARE poster_size VARCHAR (100) ;
 set poster_size = 
  (SELECT 
    c.cat_value 
  FROM
    tbl_poster_to_category ptc 
    RIGHT JOIN tbl_category c 
      ON ptc.fk_cat_id = c.cat_id 
      AND c.fk_cat_type_id = 5 
  WHERE ptc.fk_poster_id = poster_id 
  LIMIT 0, 1) ;
RETURN poster_size;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP FUNCTION IF EXISTS `cond_auction` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'STRICT_TRANS_TABLES,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` FUNCTION `cond_auction`(poster_id INT) READS SQL DATA RETURNS varchar(100) CHARSET latin1
BEGIN
  DECLARE poster_size VARCHAR (100) ;
  IF poster_id != '' 
  THEN SET poster_size = 
  (SELECT 
    c.cat_value 
  FROM
    tbl_poster_to_category_live ptc 
    RIGHT JOIN tbl_category c 
      ON ptc.fk_cat_id = c.cat_id 
      AND c.fk_cat_type_id = 5 
  WHERE ptc.fk_poster_id = poster_id 
  LIMIT 0, 1) ;
  END IF ;
  RETURN (poster_size) ;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP FUNCTION IF EXISTS `countMax` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'STRICT_TRANS_TABLES,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` FUNCTION `countMax`(auctionId INT) READS SQL DATA RETURNS varchar(100) CHARSET latin1
BEGIN
  DECLARE CountTotal VARCHAR (100) ;
  IF auctionId != '' 
  THEN SET CountTotal = 
  ( SELECT COUNT(DISTINCT(bid_id)) AS highest_no FROM tbl_bid
	 WHERE bid_fk_auction_id=auctionId AND bid_amount =
		( SELECT MAX(bid_amount) FROM tbl_bid WHERE  bid_fk_auction_id=auctionId GROUP BY auctionId )) ;
  END IF ;
  RETURN (CountTotal) ;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP FUNCTION IF EXISTS `highest_user` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'STRICT_TRANS_TABLES,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` FUNCTION `highest_user`(auctionId INT) READS SQL DATA RETURNS varchar(100) CHARSET latin1
BEGIN
  DECLARE highestUser VARCHAR (100) ;
  IF auctionId != '' 
  THEN SET highestUser = 
  ( SELECT
            					   tb.bid_fk_user_id
            					   FROM tbl_bid tb
            					   WHERE tb.bid_fk_auction_id=auctionId AND
                 				CASE WHEN countMax(auctionId) = 1 THEN tb.bid_amount = (SELECT
                                                                       MAX(ntb.bid_amount)
                                                                     FROM tbl_bid ntb
                                                                     WHERE ntb.bid_fk_auction_id = auctionId
                                                                     GROUP BY ntb.bid_fk_auction_id)WHEN countMax(auctionId) > 1 THEN tb.bid_amount = (SELECT
                                                                                                                                                            MAX(ntb.bid_amount)
                                                                                                                                                          FROM tbl_bid ntb
                                                                                                                                                          WHERE ntb.bid_fk_auction_id = auctionId
                                                                                                                                                          GROUP BY ntb.bid_fk_auction_id)
      							AND tb.is_proxy = '1' END GROUP BY  tb.bid_fk_auction_id) ;
  END IF ;
  RETURN (highestUser) ;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP FUNCTION IF EXISTS `poster_size` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'STRICT_TRANS_TABLES,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` FUNCTION `poster_size`(poster_id INT) READS SQL DATA RETURNS varchar(100) CHARSET latin1
BEGIN
  DECLARE poster_size VARCHAR (100) ;
  IF poster_id != '' 
  THEN SET poster_size = 
  (SELECT 
    c.cat_value 
  FROM
    tbl_poster_to_category ptc 
    RIGHT JOIN tbl_category c 
      ON ptc.fk_cat_id = c.cat_id 
      AND c.fk_cat_type_id = 4 
  WHERE ptc.fk_poster_id = poster_id 
  LIMIT 0, 1) ;
  END IF ;
  RETURN (poster_size) ;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP FUNCTION IF EXISTS `poster_size_auction` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'STRICT_TRANS_TABLES,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` FUNCTION `poster_size_auction`(poster_id INT) READS SQL DATA RETURNS varchar(100) CHARSET latin1
BEGIN
  DECLARE poster_size VARCHAR (100) ;
  IF poster_id != '' 
  THEN SET poster_size = 
  (SELECT 
    c.cat_value 
  FROM
    tbl_poster_to_category_live ptc 
    RIGHT JOIN tbl_category c 
      ON ptc.fk_cat_id = c.cat_id 
      AND c.fk_cat_type_id = 4 
  WHERE ptc.fk_poster_id = poster_id 
  LIMIT 0, 1) ;
  END IF ;
  RETURN (poster_size) ;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `fetchLiveAuctions` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'STRICT_TRANS_TABLES,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `fetchLiveAuctions`(
  IN param1 VARCHAR (100),
  IN UserID VARCHAR (100),
  IN order_by VARCHAR (100),
  IN order_type VARCHAR (100),
  IN off_set INTEGER UNSIGNED,
  IN toshow INTEGER UNSIGNED
)
BEGIN
  IF (param1 = '' 
    OR param1 = 'NULL') 
  THEN 
  SELECT 
    c.cat_value AS poster_size,
    c1.cat_value AS genre,
    c2.cat_value AS decade,
    poster_size (p.poster_id) AS country,
    cond (p.poster_id) AS cond,
    COUNT(tw.watching_id) AS watch_indicator,
    a.auction_id,
    a.is_reopened,
    a.fk_auction_type_id,
    a.auction_asked_price,
    a.auction_reserve_offer_price,
    a.fk_event_id,
    a.fk_auction_week_id,
    a.is_offer_price_percentage,
    a.auction_buynow_price,
    a.auction_actual_start_datetime,
    (
      UNIX_TIMESTAMP(a.auction_actual_end_datetime) - UNIX_TIMESTAMP()
    ) AS seconds_left,
    a.auction_actual_end_datetime,
    e.event_title,
    aw.auction_week_title,
    p.poster_id,
    p.fk_user_id,
    p.poster_title,
    p.poster_sku,
    p.poster_desc,
    pim.poster_thumb 
  FROM
    tbl_auction a 
    LEFT JOIN tbl_poster p 
      ON a.fk_poster_id = p.poster_id 
    LEFT JOIN tbl_poster_images pim
      ON a.fk_poster_id = pim.fk_poster_id 
    LEFT JOIN tbl_event e 
      ON a.fk_event_id = e.event_id 
    LEFT JOIN tbl_auction_week aw 
      ON a.fk_auction_week_id = aw.auction_week_id 
    LEFT JOIN tbl_watching tw 
      ON a.auction_id = tw.auction_id 
      AND tw.user_id = UserID 
    LEFT JOIN (
        tbl_poster_to_category ptc 
        RIGHT JOIN tbl_category c 
          ON ptc.fk_cat_id = c.cat_id 
          AND c.fk_cat_type_id = 1
      ) 
      ON a.fk_poster_id = ptc.fk_poster_id 
    LEFT JOIN (
        tbl_poster_to_category ptc1 
        RIGHT JOIN tbl_category c1 
          ON ptc1.fk_cat_id = c1.cat_id 
          AND c1.fk_cat_type_id = 2
      ) 
      ON a.fk_poster_id = ptc1.fk_poster_id 
    LEFT JOIN (
        tbl_poster_to_category ptc2 
        RIGHT JOIN tbl_category c2 
          ON ptc2.fk_cat_id = c2.cat_id 
          AND c2.fk_cat_type_id = 3
      ) 
      ON a.fk_poster_id = ptc2.fk_poster_id 
  WHERE pim.is_default = '1' 
    AND a.auction_is_approved = '1' 
    AND a.auction_is_sold = '0' 
    AND 
    CASE
      WHEN a.fk_auction_type_id = '2' 
      THEN (
        a.auction_actual_start_datetime <= NOW() 
        AND a.auction_actual_end_datetime >= NOW()
      ) 
      WHEN a.fk_auction_type_id = '3' 
      THEN (
        a.auction_actual_start_datetime <= NOW() 
        AND a.auction_actual_end_datetime >= NOW() 
        AND a.is_approved_for_monthly_auction = '1'
      ) 
      ELSE a.fk_auction_type_id = '1' 
    END 
  GROUP BY a.auction_id 
  ORDER BY order_by DESC 
  LIMIT 0 , 20  ;
  
  
  END IF ;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `myOfferSP` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'STRICT_TRANS_TABLES,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `myOfferSP`(  
  IN input TEXT, 
  IN `delimiter` VARCHAR(10)
)
    READS SQL DATA
BEGIN 
 IF input IS NULL THEN
		SET input = 'NULL';
    END IF;
    SET @qry = CONCAT('SELECT auction_id, fk_auction_type_id, auction_is_sold, auction_actual_end_datetime,
                    COUNT(offer_id) AS offer_count, MAX(offer_amount) AS last_offer_amount
                    FROM tbl_auction 
                    LEFT JOIN tbl_offer  ON auction_id = offer_fk_auction_id
                    WHERE auction_id IN (', input, ') AND offer_parent_id = 0 GROUP BY auction_id');
    
    
    PREPARE stmt FROM @qry;
    EXECUTE stmt;
    DEALLOCATE PREPARE stmt;
  
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `spGetAuction` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'STRICT_TRANS_TABLES,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `spGetAuction`(IN input TEXT, IN `delimiter` VARCHAR(10))
BEGIN
	IF input IS NULL THEN
		SET input = 'NULL';
	END IF;
    SET @qry = CONCAT(
			'SELECT	auction_id,
				auction_asked_price,
				fk_auction_type_id,
				fk_auction_week_id, 
				auction_is_sold, 
				auction_actual_end_datetime,
				(UNIX_TIMESTAMP(auction_actual_end_datetime) - UNIX_TIMESTAMP()) AS seconds_left, 
				bid_count,
				max_bid_amount  AS last_bid_amount,
				highest_user
			FROM 	tbl_auction_live	
			WHERE 	auction_id IN (', input, ') 
			 '
		);
    
    
    PREPARE stmt FROM @qry;
    EXECUTE stmt;
    DEALLOCATE PREPARE stmt;
    END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `spGetAuction_bak` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'STRICT_TRANS_TABLES,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `spGetAuction_bak`(IN input TEXT, IN `delimiter` VARCHAR(10))
BEGIN
	IF input IS NULL THEN
		SET input = 'NULL';
	END IF;
    SET @qry = CONCAT(
			'SELECT	auction_id,
				auction_asked_price,
				fk_auction_type_id,
				fk_auction_week_id, 
				auction_is_sold, 
				auction_actual_end_datetime,
				(UNIX_TIMESTAMP(auction_actual_end_datetime) - UNIX_TIMESTAMP()) AS seconds_left, 
				bid_count,
				max_bid_amount  AS last_bid_amount,
				highest_user
			FROM 	tbl_auction_live	
			WHERE 	auction_id IN (', input, ') 
			 '
		);
    
    
    PREPARE stmt FROM @qry;
    EXECUTE stmt;
    DEALLOCATE PREPARE stmt;
    END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2026-01-07 23:12:42
