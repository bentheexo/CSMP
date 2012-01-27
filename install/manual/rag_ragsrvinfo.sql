-- 
-- Add column to the `ragsrvinfo` table for /install/npc/agit_status.txt 
-- 

ALTER TABLE `ragsrvinfo` 
ADD `agit_status` TINYINT(1) UNSIGNED NOT NULL DEFAULT '0' AFTER `drop`;
