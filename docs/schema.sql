CREATE TABLE `log_post` (
  `id` varchar(36) NOT NULL
,  "created_at" datetime NOT NULL
,  "updated_at" datetime NOT NULL
,  `title` text NOT NULL
,  `content` text DEFAULT NULL
,  `is_pinned` integer DEFAULT NULL
,  PRIMARY KEY (`id`)
);
