USE `whey_web`;

-- Password: 12345678
INSERT INTO `Users` (`id`, `email`, `password`, `role`, `status`, `created_at`)
VALUES
  ('11111111-1111-4111-8111-111111111111', 'admin@fitwhey.local', '$2y$10$z77lwiakr1fHXAstZDquWOE2vD.QF3aHAe7kjgw3CBYXinuEQoWcW', 'admin', 'active', NOW()),
  ('22222222-2222-4222-8222-222222222222', 'member@fitwhey.local', '$2y$10$z77lwiakr1fHXAstZDquWOE2vD.QF3aHAe7kjgw3CBYXinuEQoWcW', 'member', 'active', NOW())
ON DUPLICATE KEY UPDATE
  `email` = VALUES(`email`);

INSERT INTO `Profiles` (`user_id`, `full_name`, `avatar_url`, `phone`, `address`, `bio`)
VALUES
  ('11111111-1111-4111-8111-111111111111', 'System Admin', NULL, NULL, NULL, 'Admin account for demo'),
  ('22222222-2222-4222-8222-222222222222', 'Demo Member', NULL, NULL, NULL, 'Member account for demo')
ON DUPLICATE KEY UPDATE
  `full_name` = VALUES(`full_name`);
