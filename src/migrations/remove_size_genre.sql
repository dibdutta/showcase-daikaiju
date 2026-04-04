-- Remove Size (fk_cat_type_id=1) and Genre (fk_cat_type_id=2) associations from poster_to_category tables
DELETE FROM tbl_poster_to_category
WHERE fk_cat_id IN (SELECT cat_id FROM tbl_category WHERE fk_cat_type_id IN (1, 2));

DELETE FROM tbl_poster_to_category_live
WHERE fk_cat_id IN (SELECT cat_id FROM tbl_category WHERE fk_cat_type_id IN (1, 2));

-- Optionally remove the category entries themselves
-- DELETE FROM tbl_category WHERE fk_cat_type_id IN (1, 2);
-- DELETE FROM tbl_category_type WHERE cat_type_id IN (1, 2);
