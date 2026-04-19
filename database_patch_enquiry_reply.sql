-- Chạy một lần nếu database đã tồn tại nhưng chưa có cột phản hồi admin.
USE `tour`;

ALTER TABLE `tblenquiry`
  ADD COLUMN `AdminReply` MEDIUMTEXT NULL AFTER `Description`,
  ADD COLUMN `ReplyDate` TIMESTAMP NULL DEFAULT NULL AFTER `AdminReply`;
