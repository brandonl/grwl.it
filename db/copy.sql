
INSERT INTO users ( user_id, user_name, user_email, user_pass, dob, city, state, zipcode, description, profile_image_url, protected, created_at, updated_at, friends_count, followers_count, message_count ) VALUES
(1,'brandon', 'brandon@gmail.com', '7c6a180b36896a0a8c02787eeafb0e4c', now(), 'riverside', 'CA', 91725, 'Test description', '/images/blank.png', 0, now(), now(), 3, 3, 0 ),
(2,'kirby', 'kirby@gmail.com', '6cb75f652a9b52798eb6cf2201057c73', now(), 'riverside', 'CA', 91725, 'Test description', '/images/blank.png', 0, now(), now(), 3, 3, 0),
(3,'jaycee', 'jaycee@gmail.com', '819b0643d6b89dc9b579fdfc9094f28e', now(), 'riverside', 'CA', 91725, 'Test description', '/images/blank.png', 0, now(), now(), 3, 3, 0 ),
(4,'mark', 'mark@gmail.com', '34cc93ece0ba9e3f6f235d4af979b16c', now(), 'riverside', 'CA', 91725, 'Test description', '/images/blank.png', 0, now(), now(), 3, 3, 0 );

INSERT INTO messages( user_id, text, created_at ) VALUES
( 1, 'Hello World!', now() ),
( 2, 'Hello World!', now() ),
( 3, 'Hello World!', now() ),
( 4, 'Hello World!', now() );

INSERT INTO followers( leader_id, follower_id, followed_since, status ) VALUES
(2,1,now(), 1),
(3,1,now(), 1),
(4,1,now(), 1),
(1,2,now(), 1),
(3,2,now(), 1),
(4,2,now(), 1),
(1,3,now(), 1),
(2,3,now(), 1),
(4,3,now(), 1),
(1,4,now(), 1),
(2,4,now(), 1),
(3,4,now(), 1);