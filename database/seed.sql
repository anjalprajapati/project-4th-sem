-- ============================================================
-- Street Dog Fundraising System - Seed Data
-- ============================================================

USE street_dog_db;

-- ============================================================
-- Admin User (password: Admin@123)
-- ============================================================
INSERT INTO users (name, email, password, role) VALUES
('System Admin', 'admin@streetdogs.org', '$2y$10$8K1p/a0dL1LXMIgbCe2fPuQr5v3gKj4h5rN6tMwP7yXo8kZqE9bWu', 'admin');

-- ============================================================
-- Sample Donors
-- ============================================================
INSERT INTO users (name, email, password, role) VALUES
('Rahul Sharma', 'rahul@example.com', '$2y$10$8K1p/a0dL1LXMIgbCe2fPuQr5v3gKj4h5rN6tMwP7yXo8kZqE9bWu', 'donor'),
('Priya Patel', 'priya@example.com', '$2y$10$8K1p/a0dL1LXMIgbCe2fPuQr5v3gKj4h5rN6tMwP7yXo8kZqE9bWu', 'donor'),
('Amit Kumar', 'amit@example.com', '$2y$10$8K1p/a0dL1LXMIgbCe2fPuQr5v3gKj4h5rN6tMwP7yXo8kZqE9bWu', 'donor');

-- ============================================================
-- Sample Volunteers
-- ============================================================
INSERT INTO users (name, email, password, role) VALUES
('Sneha Reddy', 'sneha@example.com', '$2y$10$8K1p/a0dL1LXMIgbCe2fPuQr5v3gKj4h5rN6tMwP7yXo8kZqE9bWu', 'volunteer'),
('Vikram Singh', 'vikram@example.com', '$2y$10$8K1p/a0dL1LXMIgbCe2fPuQr5v3gKj4h5rN6tMwP7yXo8kZqE9bWu', 'volunteer');

INSERT INTO volunteers (user_id, phone, availability) VALUES
(5, '9876543210', 'available'),
(6, '9876543211', 'available');

-- ============================================================
-- Sample Campaigns
-- ============================================================
INSERT INTO campaigns (title, description, goal_amount, current_amount, deadline, status) VALUES
('Winter Rescue Drive', 'Help us rescue and shelter street dogs during the harsh winter months. Every contribution provides warmth, food, and medical care to dogs in need.', 50000.00, 32500.00, '2026-08-31', 'active'),
('Vaccination Campaign 2026', 'Our annual vaccination drive aims to vaccinate 500 street dogs against rabies and other diseases. Help us keep the community safe.', 75000.00, 45000.00, '2026-09-30', 'active'),
('Emergency Medical Fund', 'An emergency fund for critically injured street dogs who need immediate surgical intervention and intensive care.', 100000.00, 67800.00, '2026-12-31', 'active'),
('Feed a Stray Program', 'Monthly feeding program covering 10 locations across the city. Your donation provides nutritious meals to over 200 street dogs daily.', 30000.00, 28500.00, '2026-07-31', 'active');

-- ============================================================
-- Sample Donations
-- ============================================================
INSERT INTO donations (user_id, campaign_id, amount, transaction_id, is_anonymous, date) VALUES
(2, 1, 5000.00, 'TXN20260601001', 0, '2026-06-01 10:30:00'),
(3, 1, 10000.00, 'TXN20260602002', 0, '2026-06-02 14:15:00'),
(4, 2, 7500.00, 'TXN20260603003', 1, '2026-06-03 09:00:00'),
(2, 2, 2500.00, 'TXN20260604004', 0, '2026-06-04 11:45:00'),
(3, 3, 15000.00, 'TXN20260605005', 0, '2026-06-05 16:20:00'),
(4, 3, 5000.00, 'TXN20260606006', 0, '2026-06-06 13:30:00'),
(2, 4, 3000.00, 'TXN20260607007', 0, '2026-06-07 10:00:00');

-- ============================================================
-- Sample Dogs
-- ============================================================
INSERT INTO dogs (name, age, gender, breed, health_status, vaccinated, description) VALUES
('Buddy', '2 years', 'male', 'Labrador Mix', 'healthy', 'vaccinated', 'Buddy is a friendly and energetic dog who loves to play fetch. He was rescued from a busy highway and has fully recovered.'),
('Luna', '1 year', 'female', 'Indian Spitz', 'healthy', 'vaccinated', 'Luna is a gentle and affectionate dog. She was found malnourished but has made a complete recovery with proper care.'),
('Rocky', '3 years', 'male', 'German Shepherd Mix', 'under_treatment', 'partially_vaccinated', 'Rocky was rescued with a broken leg. He is currently receiving treatment and is expected to make a full recovery.'),
('Daisy', '6 months', 'female', 'Mixed Breed', 'healthy', 'vaccinated', 'Daisy is a playful puppy who was found abandoned near a park. She is now healthy and looking for a forever home.'),
('Max', '4 years', 'male', 'Indie', 'injured', 'not_vaccinated', 'Max was found with severe skin infections. He is receiving treatment and showing improvement every day.'),
('Coco', '1.5 years', 'female', 'Pomeranian Mix', 'healthy', 'vaccinated', 'Coco is a sweet and calm dog who gets along well with other animals. Perfect for a loving home.');

-- ============================================================
-- Sample Rescues
-- ============================================================
INSERT INTO rescues (dog_id, location, rescue_date, status, notes) VALUES
(1, 'MG Road, Near Central Mall', '2026-03-15', 'recovered', 'Found injured on highway. Treated for minor wounds.'),
(2, 'Gandhi Nagar, Block 5', '2026-04-10', 'recovered', 'Found malnourished. Needed nutritional support for 2 weeks.'),
(3, 'Industrial Area, Phase 2', '2026-05-20', 'under_treatment', 'Broken front left leg. Surgery completed, in recovery.'),
(4, 'City Park, East Gate', '2026-05-28', 'recovered', 'Abandoned puppy. No injuries, needed deworming and vaccination.'),
(5, 'Railway Station Area', '2026-06-05', 'under_treatment', 'Severe mange and skin infection. On medication.'),
(6, 'Residential Colony, Sector 7', '2026-06-10', 'recovered', 'Found tied to a pole. Rescued and rehabilitated.');

-- ============================================================
-- Sample Tasks
-- ============================================================
INSERT INTO tasks (volunteer_id, title, description, category, status, deadline) VALUES
(1, 'Morning Feeding - MG Road', 'Feed dogs at MG Road area. Approximately 15 dogs. Food supplies at shelter.', 'feeding', 'completed', '2026-06-15'),
(1, 'Rescue Call - Highway Area', 'Injured dog reported near highway toll booth. Take rescue kit and carrier.', 'rescue', 'in_progress', '2026-06-20'),
(2, 'Transport Rocky to Vet', 'Take Rocky for follow-up X-ray at City Vet Clinic at 10 AM.', 'transportation', 'pending', '2026-06-22'),
(2, 'Vaccination Drive - Sector 5', 'Assist vet team with vaccination of street dogs in Sector 5 area.', 'medical_support', 'pending', '2026-06-25'),
(1, 'Evening Feeding - Park Area', 'Feed dogs near City Park. Approximately 20 dogs.', 'feeding', 'pending', '2026-06-21');

-- ============================================================
-- Sample Adoptions
-- ============================================================
INSERT INTO adoptions (dog_id, adopter_name, phone, email, address, reason, status) VALUES
(1, 'Anjali Mehta', '9876543212', 'anjali@example.com', '123, Green Valley Apartments, Sector 12', 'I have always loved dogs and have a spacious home with a garden. I want to give Buddy a loving forever home.', 'pending'),
(4, 'Rajesh Gupta', '9876543213', 'rajesh@example.com', '456, Sunshine Residency, MG Road', 'My family has been looking for a puppy. We have experience with pets and will provide excellent care.', 'approved');

-- ============================================================
-- Sample Updates/News
-- ============================================================
INSERT INTO updates (title, description, category, date) VALUES
('Buddy Finds a Home!', 'After months of rehabilitation, Buddy has been adopted by a wonderful family! He now enjoys daily walks in the park and has a warm bed to sleep in. Thank you to everyone who contributed to his recovery.', 'success_story', '2026-06-01 09:00:00'),
('Annual Vaccination Drive Starting July', 'We are excited to announce our annual vaccination drive starting July 1st. We aim to vaccinate 500 dogs across the city. Volunteers needed! Sign up through your volunteer dashboard.', 'event', '2026-06-10 10:00:00'),
('Why Street Dogs Need Your Help', 'There are millions of street dogs in India who lack food, shelter, and medical care. By supporting our organization, you can help us rescue, treat, and rehome these beautiful animals. Every contribution matters.', 'awareness', '2026-06-15 12:00:00');
