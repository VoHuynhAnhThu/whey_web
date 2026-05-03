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

INSERT INTO `Categories` (`id`, `parent_id`, `name`, `slug`) VALUES 
(1, NULL, 'Thực phẩm bổ sung', 'thuc-pham-bo-sung'),
(2, 1, 'Whey Protein', 'whey-protein');

INSERT INTO `products` (`id`, `category_id`, `name`, `slug`, `description`, `price`, `sale_price`, `stock_quantity`, `weight`, `flavor`, `is_active`, `created_at`, `updated_at`) VALUES
('550e8400-e29b-41d4-a716-446655440000', 2, 'Optimum Nutrition Gold Standard 100 Whey', 'gold-standard-100-whey', 'Best selling whey protein for muscle recovery.', '1650000.00', '1590000.00', 47, '2270.00', 'Double Rich Chocolate', 1, '2026-05-03 10:11:34', '2026-05-03 19:16:56'),
('6ba7b810-9dad-11d1-80b4-00c04fd430c8', 2, 'Rule 1 Protein Isolate', 'rule-1-protein-isolate', 'Ultra pure whey protein isolate.', '1450000.00', '1390000.00', 0, '2270.00', 'Vanilla Butter Cake', 1, '2026-05-03 10:11:34', '2026-05-03 20:04:19'),
('85bde1cb-d775-48e2-841f-f2dd1432e065', 2, 'Labrada Lean Body Protein Shake 80 gói', 'labrada-lean-body-protein-shake-80-g-i', 'ágawhawhabhaw', '14562.00', '12345678.00', 123, '0.00', '1515', 1, '2026-05-03 16:48:16', '2026-05-03 17:49:48');

INSERT INTO `product_images` (`id`, `product_id`, `url`, `is_main`, `position`) VALUES
('a2b3c4d5-e6f7-4839-a0b1-c2d3e4f5a6b7', '6ba7b810-9dad-11d1-80b4-00c04fd430c8', 'uploads/products/rule1.png', 1, 0),
('a57db084-c1b0-4fa3-9848-c821e5e3ffff', '85bde1cb-d775-48e2-841f-f2dd1432e065', 'uploads/products/1777831144_lean_body.png', 1, 0),
('f47ac10b-58cc-4372-a567-0e02b2c3d479', '550e8400-e29b-41d4-a716-446655440000', 'uploads/products/gold-standard.png', 1, 0);

INSERT INTO `product_nutrition` (`product_id`, `serving_size`, `serving_unit`, `calories`, `protein`, `carbs`, `fat`, `fiber`, `sugar`) VALUES
('550e8400-e29b-41d4-a716-446655440000', '30.40', 'g', '120.00', '24.00', '3.00', '1.00', '0.00', '1.00'),
('6ba7b810-9dad-11d1-80b4-00c04fd430c8', '28.90', 'g', '110.00', '25.00', '2.00', '0.00', '0.00', '0.00'),
('85bde1cb-d775-48e2-841f-f2dd1432e065', '124.00', '151', '1515.00', '16161.00', '213.00', '21516.00', NULL, NULL);
