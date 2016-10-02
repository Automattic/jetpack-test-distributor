-- phpMyAdmin SQL Dump
-- version 4.6.4
-- https://www.phpmyadmin.net/
--
-- Host: db
-- Generation Time: Oct 02, 2016 at 12:27 AM
-- Server version: 10.1.17-MariaDB-1~jessie
-- PHP Version: 5.6.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `testing`
--

-- --------------------------------------------------------

--
-- Table structure for table `jetpack_test_items`
--

CREATE TABLE `jetpack_test_items` (
  `jetpack_test_item_id` int(11) NOT NULL,
  `active` tinyint(2) DEFAULT '0',
  `date_added` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `importance` tinyint(3) DEFAULT '0',
  `title` varchar(255) DEFAULT NULL,
  `instructions` text,
  `min_jp_ver` varchar(15) DEFAULT NULL,
  `max_jp_ver` varchar(15) DEFAULT NULL,
  `min_wp_ver` varchar(15) DEFAULT NULL,
  `max_wp_ver` varchar(15) DEFAULT NULL,
  `min_php_ver` varchar(15) DEFAULT NULL,
  `max_php_ver` varchar(128) DEFAULT NULL,
  `module` varchar(128) DEFAULT NULL,
  `host` varchar(128) DEFAULT NULL,
  `browser` varchar(128) DEFAULT NULL,
  `initial_path` varchar(128) DEFAULT NULL,
  `added_by` varchar(128) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `jetpack_test_items`
--

INSERT INTO `jetpack_test_items` (`jetpack_test_item_id`, `active`, `date_added`, `importance`, `title`, `instructions`, `min_jp_ver`, `max_jp_ver`, `min_wp_ver`, `max_wp_ver`, `min_php_ver`, `max_php_ver`, `module`, `host`, `browser`, `initial_path`, `added_by`) VALUES
(4, 1, '2016-07-19 10:33:10', 10, 'Publicize to Facebook', '1. Ensure that you have a connected Facebook account\r\n2. Publish a new post (with an image)\r\n3. Ensure that the post was published to your Facebook feed', '', '', '', '', '', '', 'publicize', '', '', '/wp-admin/options-general.php?page=sharing', 'samhotchkiss'),
(5, 1, '2016-07-19 10:51:58', 10, 'Publicize to Twitter', '1. Ensure that you have a connected Twitter account\r\n2. Publish a new post\r\n3. Ensure that the post was published to your Twitter account', '', '', '', '', '', '', 'publicize', '', '', '/wp-admin/options-general.php?page=sharing', 'samhotchkiss'),
(6, 1, '2016-07-19 18:45:31', 1, 'Publish a full post', '1. Go to Posts > Add New in your dashboard.\r\n2. Write a long post, with text and images\r\n3. Hit Publish.\r\n4. The post should be sent to all Jetpack subscribers for that site.', '', '', '', '', '5.4', '7.1', 'subscriptions', '', '', NULL, 'jeherve'),
(7, 1, '2016-07-19 18:46:18', 1, 'Subscriptions: Schedule a post', '1. Go to Posts > Add New in your dashboard.\r\n2. Write a long post, with text and images.\r\n3. Schedule the post to be published later.\r\n4. When the post gets published, it should be sent to all Jetpack subscribers for that site.', '', '', '', '', '', '', 'subscriptions', '', '', NULL, 'jeherve'),
(8, 1, '2016-07-19 18:47:15', 1, 'Publish a post including a Read More tag', '1. Go to Posts > Add New in your dashboard.\r\n2. Write a long post, with text and images.\r\n3. Add a Read More tag in the middle of your post.\r\n4. Hit Publish.\r\n5. The post should be sent to all Jetpack subscribers for that site, and should only include the content above the Read more tag.', '', '', '', '', '', '', 'subscriptions', '', '', NULL, 'jeherve'),
(9, 1, '2016-07-19 18:48:02', 1, 'Publish a post with feed settings set to Full', '0. In Settings > Reading, set your Feed settings to Full.\r\n1. Go to Posts > Add New in your dashboard.\r\n2. Write a long post, with text and images.\r\n3. Hit Publish.\r\n4. The post should be sent to all Jetpack subscribers for that site. The whole post content should be sent to subscribers.', '', '', '', '', '', '', 'subscriptions', '', '', NULL, 'jeherve'),
(10, 1, '2016-07-19 18:48:54', 1, 'Publish a post with feed settings set to Excerpt', '0. In Settings > Reading, set your Feed settings to Summary.\r\n1. Go to Posts > Add New in your dashboard.\r\n2. Write a long post, with text and images.\r\n3. Hit Publish.\r\n4. The post should be sent to all Jetpack subscribers for that site. Only an automated excerpt should be sent to subscribers.', '', '', '', '', '', '', 'subscriptions', '', '', NULL, 'jeherve'),
(11, 1, '2016-07-19 18:49:33', 1, 'Publish a post with feed settings set to Excerpt', '0. In Settings > Reading, set your Feed settings to Summary.\r\n1. Go to Posts > Add New in your dashboard.\r\n2. Write a long post, with text and images.\r\n3. Create a custom excerpt in the excerpt box below the visual editor.\r\n4. Hit Publish.\r\n5. The post should be sent to all Jetpack subscribers for that site. Only the custom excerpt should be sent to subscribers.', '', '', '', '', '', '', 'subscriptions', '', '', NULL, 'jeherve'),
(12, 1, '2016-07-19 18:51:18', 1, 'Publish a post while using the jetpack_allow_per_post_subscriptions filter', '0. Follow the instructions here to add the jetpack_allow_per_post_subscriptions filter to your site:\r\nhttps://developer.jetpack.com/hooks/jetpack_allow_per_post_subscriptions/\r\n1. Go to Posts > Add New in your dashboard.\r\n2. Write a long post, with text and images.\r\n3. Select the checkbox to send the email to subscribers.\r\n4. Hit Publish.\r\n5. The post should be sent to all Jetpack subscribers for that site.', '', '', '', '', '', '', 'subscriptions', '', '', NULL, 'jeherve'),
(13, 1, '2016-07-19 18:53:30', 1, 'Publish a post while using the jetpack_subscriptions_exclude_these_categories filter', '0. Follow the instructions here to add the jetpack_subscriptions_exclude_these_categories filter to your site:\r\nhttps://developer.jetpack.com/hooks/jetpack_subscriptions_exclude_these_categories/\r\n1. Go to Posts > Add New in your dashboard.\r\n2. Write a long post, with text and images.\r\n3. Select a category that should be excluded from Subscriptions\r\n4. Hit Publish.\r\n5. The post should not be sent to the Jetpack subscribers since it belongs to an excluded category.', '', '', '', '', '', '', 'subscriptions', '', '', NULL, 'jeherve'),
(14, 1, '2016-07-19 19:02:13', 1, 'Publish a post while using the jetpack_subscriptions_exclude_all_categories_except filter', '0. Follow the instructions here to add the jetpack_subscriptions_exclude_all_categories_except filter to your site:\r\nhttps://developer.jetpack.com/hooks/jetpack_subscriptions_exclude_all_categories_except/\r\n1. Go to Posts > Add New in your dashboard.\r\n2. Write a long post, with text and images.\r\n3. Select a category that should be included in Subscriptions.\r\n4. Hit Publish.\r\n5. The post should be sent to the Jetpack subscribers since it belongs to an allowed category.', '', '', '', '', '', '', 'subscriptions', '', '', NULL, 'jeherve'),
(15, 1, '2016-07-19 19:02:53', 1, 'Publish a post via the WordPress.com Post Editor', '1. Go to http://wordpress.com/post/\r\n2. Write a long post, with text and images.\r\n3. Hit Publish.\r\n4. The post should be sent to the Jetpack subscribers.', '', '', '', '', '', '', 'subscriptions', '', '', NULL, 'jeherve'),
(16, 1, '2016-07-19 19:03:29', 1, 'Schedule a post via the WordPress.com Post Editor', '1. Go to http://wordpress.com/post/\r\n2. Write a long post, with text and images.\r\n3. Schedule the post to be published later.\r\n4. When the post gets published, it should be sent to the Jetpack subscribers.', '', '', '', '', '', '', 'subscriptions', '', '', NULL, 'jeherve'),
(17, 1, '2016-07-19 19:15:53', 1, 'Publish a post via a third party app using the JSON API', '1. Go to https://stackedit.io/editor\r\n2. Write a long post, with text and images.\r\n3. Click on # > Publish > WordPress\r\n4. Follow the instructions to connect StackEdit to your site.\r\n5. Use the button in the top right corner to publish your post.\r\n6. The post should be sent to the Jetpack subscribers.', '', '', '', '', '', '', 'subscriptions', '', '', NULL, 'jeherve'),
(18, 1, '2016-07-19 19:18:53', 1, 'Publish a post via the bulk editing tools in your Posts list.', '1. Go to Posts > Add New\r\n2. Write a long post, with text and images.\r\n3. Save your draft.\r\n4. Go to the Posts screen\r\n5. Select your post, click on Edit, and publish it without entering the post editing screen.\r\n6. The post should be sent to the Jetpack subscribers.', '', '', '', '', '', '', 'subscriptions', '', '', NULL, 'jeherve'),
(19, 1, '2016-07-19 19:20:08', 1, 'Edit multiple post via the bulk editing tools in your Posts list.', '1. Go to the Posts screen\r\n2. Select several posts that were already published, click on Edit, and make some changes (change the publication date, add tags, ...).\r\n3. Save your changes.\r\n4. The posts should not be sent to the Jetpack subscribers.', '', '', '', '', '', '', 'subscriptions', '', '', NULL, 'jeherve'),
(20, 1, '2016-07-19 19:21:42', 1, 'Import posts via the WordPress Importer.', '1. Go to Tools > Import\r\n2. Import several posts from another WordPress site. You can use this import file as an example:\r\nhttps://wpcom-themes.svn.automattic.com/demo/theme-unit-test-data.xml\r\n3. Run the import\r\n4. The posts should not be sent to the Jetpack subscribers.', '', '', '', '', '', '', 'subscriptions', '', '', NULL, 'jeherve'),
(21, 1, '2016-08-02 00:13:19', 5, 'Publicize to LinkedIn', '1. Ensure that you have a connected LinkedIn account\r\n2. Publish a new post (with an image)\r\n3. Ensure that the post was published to your LinkedIn feed', '', '', '', '', '', '', 'publicize', '', '', '/wp-admin/options-general.php?page=sharing', 'ryancowles'),
(22, 1, '2016-08-02 00:15:22', 5, 'Publicize to Google+', '1. Ensure that you have a connected Google+ account\r\n2. Publish a new post (with an image)\r\n3. Ensure that the post was published to your Google+ feed', '', '', '', '', '', '', 'publicize', '', '', '/wp-admin/options-general.php?page=sharing', 'ryancowles'),
(23, 1, '2016-08-02 00:16:01', 5, 'Publicize to Tumblr', '1. Ensure that you have a connected Tumblr account\r\n2. Publish a new post (with an image)\r\n3. Ensure that the post was published to your Tumblr feed', '', '', '', '', '', '', 'publicize', '', '', '/wp-admin/options-general.php?page=sharing', 'ryancowles'),
(24, 1, '2016-08-02 00:16:32', 1, 'Publicize to Path', '1. Ensure that you have a connected Path account\r\n2. Publish a new post (with an image)\r\n3. Ensure that the post was published to your Path feed', '', '', '', '', '', '', 'publicize', '', '', '/wp-admin/options-general.php?page=sharing', 'ryancowles');

-- --------------------------------------------------------

--
-- Table structure for table `jetpack_test_items_completed`
--

CREATE TABLE `jetpack_test_items_completed` (
  `jetpack_test_item_id` int(11) NOT NULL,
  `site_id` int(11) NOT NULL,
  `skipped` tinyint(1) NOT NULL,
  `date_added` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `jetpack_versions`
--

CREATE TABLE `jetpack_versions` (
  `jetpack_version_id` int(11) NOT NULL,
  `version` varchar(15) NOT NULL,
  `touched_modules` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `jetpack_versions`
--

INSERT INTO `jetpack_versions` (`jetpack_version_id`, `version`, `touched_modules`) VALUES
(1, '4.6.0', '["carousel", "comments", "publicize"]'),
(2, '4.5.9', '["shortcodes", "sso"]');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `jetpack_test_items`
--
ALTER TABLE `jetpack_test_items`
  ADD PRIMARY KEY (`jetpack_test_item_id`),
  ADD KEY `module` (`module`),
  ADD KEY `host` (`host`),
  ADD KEY `browser` (`browser`),
  ADD KEY `active` (`active`);

--
-- Indexes for table `jetpack_test_items_completed`
--
ALTER TABLE `jetpack_test_items_completed`
  ADD PRIMARY KEY (`jetpack_test_item_id`,`site_id`);

--
-- Indexes for table `jetpack_versions`
--
ALTER TABLE `jetpack_versions`
  ADD PRIMARY KEY (`jetpack_version_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `jetpack_test_items`
--
ALTER TABLE `jetpack_test_items`
  MODIFY `jetpack_test_item_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;
--
-- AUTO_INCREMENT for table `jetpack_versions`
--
ALTER TABLE `jetpack_versions`
  MODIFY `jetpack_version_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
