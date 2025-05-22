-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 01, 2025 at 12:58 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `cooking`
--

-- --------------------------------------------------------

--
-- Table structure for table `favorites`
--

CREATE TABLE `favorites` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `recipe_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `favorites`
--

INSERT INTO `favorites` (`id`, `user_id`, `recipe_id`, `created_at`) VALUES
(2, 7, 12, '2025-04-17 06:18:48'),
(13, 6, 12, '2025-04-26 12:00:54');

-- --------------------------------------------------------

--
-- Table structure for table `followers`
--

CREATE TABLE `followers` (
  `id` int(11) NOT NULL,
  `follower_id` int(11) NOT NULL,
  `following_id` int(11) NOT NULL,
  `followed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `followers`
--

INSERT INTO `followers` (`id`, `follower_id`, `following_id`, `followed_at`) VALUES
(1, 6, 7, '2025-04-26 12:17:33');

-- --------------------------------------------------------

--
-- Table structure for table `password_token`
--

CREATE TABLE `password_token` (
  `id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `otp` int(11) DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `expires_at` datetime NOT NULL,
  `otp_attempts` int(11) NOT NULL,
  `last_resend` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `password_token`
--

INSERT INTO `password_token` (`id`, `email`, `otp`, `created_at`, `expires_at`, `otp_attempts`, `last_resend`) VALUES
(7, 'kpansara790@rku.ac.in', 317053, '2025-04-07 08:32:58', '2025-04-07 08:33:58', 1, '2025-04-07 03:02:58');

-- --------------------------------------------------------

--
-- Table structure for table `recipes`
--

CREATE TABLE `recipes` (
  `recipe_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `title` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `recipe_image` varchar(300) NOT NULL,
  `instructions` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`instructions`)),
  `ingredients` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`ingredients`)),
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `recipes`
--

INSERT INTO `recipes` (`recipe_id`, `user_id`, `title`, `description`, `recipe_image`, `instructions`, `ingredients`, `created_at`) VALUES
(12, 7, 'Paneer Butter Masala Recipe', 'Paneer Butter Masala is one of India\'s most popular paneer recipes, and with good reason! Indian cottage cheese cubes are smothered in a creamy, lightly spiced tomato sauce that is downright delicious. With my video and step-by-step guide you can easily make this restaurant style Paneer Butter Masala recipe at home!', '67f213482545d_paneer-butter-masala-1.webp', '[\"Soak 18 to 20 cashews in \\u2153 cup hot water for 20 to 30 minutes.\",\"While the cashews are soaking, you can prep the other ingredients. It\\u2019s time for chopping tomatoes, chopping and preparing the ginger-garlic paste, and slicing paneer into cubes.\",\"To make the ginger garlic paste, crush a 1 inch piece of peeled ginger with 3 to 4 small to medium-sized garlic cloves in a mortar & pestle. Continue crushing until it is a semi-fine or fine paste. Keep aside.\",\"After 20 to 30 minutes, drain the water and add the soaked cashews to a blender or mixer-grinder. Also, add 2 to 3 tablespoons fresh water (or as much as is required to blend to a fine paste).\",\"Blend to a smooth paste without any tiny bits or chunks of cashews. Remove the cashew paste from the blender and set it aside.\",\"n the same blender, add 2 cups of diced or roughly chopped tomatoes.\",\"Blend to a smooth tomato puree. Set aside.\"]', '[\"Ripe, red & juicy tomatoes : Tomatoes are a key ingredient here and form the base of the makhani sauce. As such, it is important to choose good, ripe tomatoes that are sweet.  If ripe tomatoes are not in season where you live, I suggest opting for using canned whole tomatoes that you blend instead.  These canned tomatoes are picked at peak ripeness, and for whatever reason, the whole variety is generally much more flavorful than tomato pur\\u00e9e.\",\"Raw Cashews : Yet another important ingredient for the gravy is cashews. The nuts impart a lovely creaminess and sheen in the dish, and the sweetness of the cashews help to balance the tanginess of the tomatoes.  If you are nut free, please see my recipe for Paneer Makhani, which tastes quite similar but is made with just cream and no cashews.\",\"Cream : In addition to using cashew paste, this Butter Paneer recipe calls for cream to help thicken the sauce and add richness.  If you are vegan, you can opt to use coconut cream instead, though you should note that the final flavor of the dish will be impacted a bit. You can also opt to omit the cream for a less rich gravy, too.\",\"Butter : The amount of butter that is added is just right in this paneer butter masala recipe. Butter makes the curry luxurious and, well\\u2026 buttery.  I don\\u2019t add a ton of butter here, so you don\\u2019t have to feel too guilty about it. Also note that you can go overboard by adding too much butter, so I recommend that you stick to the recipe.\",\"Paneer : The quality of your paneer can make or break your dish. What you want are succulent, soft paneer cubes gently coated with a smooth, buttery tomato sauce.  Make sure to use either Homemade Paneer (which I believe is always the best option) or good quality store bought paneer. If you opt to use store bought, be sure to follow the instructions on the package before using.\",\"Spices & Herbs : One reason this recipe is so great for weeknights is that the list of herbs and spices isn\\u2019t intimidatingly long. For that brilliant orange color, you need to add Kashmiri red chilli powder.  If you don\'t have any on hand, you can sub it with cayenne pepper or sweet paprika instead. You will also need garam masala powder. Kasuri methi, which are dried fenugreek leaves, also add good flavor.  Just skip them if you do not have them. For garnish, fresh cilantro (coriander leaves) are added.\"]', '2025-04-06 05:38:16'),
(13, 7, 'Dal Makhani Recipe', 'One of our staples during weekends is a creamy Dal Makhani, which is a slow-cooked lentil dish from classic Punjabi cuisine. Here, I share a recipe on how to make this delicious curried lentils in the Instant Pot; where you do not need to sauté any ingredients. Simply add them, pressure cook and later simmer. But keep in mind that you do need to presoak the lentils.', '67f217a171b09_dal--makhani.jpg', '[\"Soak 1 cup of whole black lentils and \\u00bd cup of kidney beans overnight in water.\",\"While the lentils and beans are soaking, chop the tomatoes and prepare the ginger-garlic paste. To make the ginger-garlic paste, crush 1-inch ginger and 3-4 garlic cloves in a mortar & pestle until fine.\",\"In a large pot or pressure cooker, add the soaked lentils and kidney beans with fresh water. Cook until they are soft and fully cooked. (If using a pressure cooker, this should take around 15\\u201320 minutes).\",\"Soak about 15\\u201320 cashews in hot water for 20-30 minutes. After soaking, drain and blend the cashews with a little water to make a smooth paste. Set aside.\",\"Blend 2 cups of ripe tomatoes into a smooth puree. No need to add water while blending.\",\"Heat oil or butter in a pan and saut\\u00e9 the ginger-garlic paste until fragrant. Add cumin seeds and let them splutter. Next, add the tomato puree and cook the tomatoes until the oil begins to separate, which indicates they are well-cooked.\",\"Once the tomato gravy is ready, add the cooked lentils and beans. Stir well to combine. Add water if necessary to adjust the consistency.\",\"Add the cashew paste to the simmering dal to give it a creamy texture. Stir in cream (or coconut cream for vegan). Simmer for 15-20 minutes, allowing the flavors to blend.\",\"Add butter to the dal for a rich, buttery finish. Season with garam masala, turmeric, and Kashmiri red chili powder. Optionally, add dried fenugreek leaves (Kasuri methi) and adjust salt and sugar to taste.\",\"Garnish with fresh cilantro leaves and serve hot with naan or rice.\"]', '[\"Whole Black Lentils (Urad Dal) : Whole black lentils, also known as urad dal, are the base of Dal Makhani. They are small, black lentils with a slightly nutty flavor.  Unlike split urad dal (which is peeled), whole urad dal retains its skin, making it more flavorful and rich in texture when cooked.\",\"Kidney Beans (Rajma) : Kidney beans, known as rajma in Hindi, are used in Dal Makhani to add volume and a hearty texture.  They\\u2019re smaller than most kidney beans and have a soft, creamy texture when cooked.\",\"Tomatoes : Tomatoes are a key base ingredient that forms the heart of the gravy in Dal Makhani.  They add acidity and natural sweetness, which help balance the richness of the lentils and beans.\",\"Raw Cashews: : Raw cashews are used to create a smooth, rich, and creamy texture in the gravy.  They are soaked in hot water, blended into a paste, and added to the dish.\",\"Cream : Cream is essential for creating the luxurious, velvety texture that Dal Makhani is known for.  It is added towards the end of cooking to enrich the gravy and smoothen the flavor profile.\",\"Butter : Butter is a defining ingredient in Dal Makhani, contributing to its signature \\\"makhani\\\" (buttery) flavor.  The butter is used to saut\\u00e9 the ginger-garlic paste and is often added at the end to enrich the dish.\",\"Spices & Herbs : One reason this recipe is so great for weeknights is that the list of herbs and spices isn\\u2019t intimidatingly long. For that brilliant orange color, you need to add Kashmiri red chilli powder.  If you don\'t have any on hand, you can sub it with cayenne pepper or sweet paprika instead. You will also need garam masala powder. Kasuri methi, which are dried fenugreek leaves, also add good flavor.  Just skip them if you do not have them. For garnish, fresh cilantro (coriander leaves) are added.\"]', '2025-04-06 05:56:49'),
(15, 6, 'Masala Pasta', 'Masala Pasta is a vibrant fusion dish combining the richness of Indian spices with the comforting texture of Italian pasta. It’s packed with colorful vegetables, bold flavors, and a spicy tomato-based sauce that coats every bite. This easy and quick recipe is perfect for lunch, dinner, or even a fun party meal. It’s a great way to use pantry staples and turn them into a delicious, satisfying meal that everyone will love.', '680cffdb6c54c_masala-pasta-recipe.jpg', '[\"Cook pasta according to package instructions. Drain and set aside.\",\"Heat oil in a pan. Add onions and saut\\u00e9 until translucent.\",\"Add ginger-garlic paste and cook until the raw smell disappears.\",\"Add tomatoes, capsicum, and carrots. Cook until the vegetables are slightly tender.\",\"Add red chili powder, turmeric, garam masala, and salt. Mix well.\",\"Add tomato ketchup and stir until the sauce thickens.\",\"Add the cooked pasta and toss well to coat it evenly with the masala.\",\"Garnish with fresh coriander leaves and serve hot.\"]', '[\"2 cups pasta (penne or fusilli)\",\"1 tablespoon oil\",\"1 small onion, finely chopped\",\"1 tomato, finely chopped\",\"\\u00bd cup capsicum (any color), diced\",\"\\u00bd cup carrots, diced\",\"1 teaspoon ginger-garlic paste\",\"1 teaspoon red chili powder\",\"\\u00bd teaspoon turmeric powder\",\"1 teaspoon garam masala\",\"2 tablespoons tomato ketchup\",\"Salt to taste\",\"Fresh coriander leaves for garnish\"]', '2025-04-26 10:16:35'),
(16, 6, 'Badam Halwa Recipe', 'Badam Halwa is a rich, traditional Indian dessert made with ground almonds, ghee, sugar, and flavored with cardamom. This luxurious sweet treat has a soft, melt-in-your-mouth texture and a beautiful golden hue. Often prepared during festivals, celebrations, or special occasions, Badam Halwa is loved for its irresistible aroma and rich taste. Though it requires a little patience, the end result is absolutely worth it!\r\n\r\n', '680d00b4ee6ae_badam-halwa.jpg', '[\"Soak almonds in hot water for 30 minutes. Peel off the skin and grind them into a smooth paste using milk.\",\"Heat ghee in a heavy-bottomed pan and add the almond paste. Cook on low flame, stirring continuously.\",\"After the paste thickens slightly, add sugar and continue cooking.\",\"Add saffron strands (if using) and cardamom powder. Keep stirring until the halwa leaves the sides of the pan and ghee starts separating.\",\"Garnish with chopped almonds and serve warm.\"]', '[\"1 cup almonds (badam)\",\"\\u00be cup sugar\",\"\\u00bd cup ghee\",\"\\u00be cup milk\",\"\\u00bc teaspoon cardamom powder\",\"A few strands of saffron (optional)\",\"2 tablespoons chopped almonds for garnish\"]', '2025-04-26 10:20:12'),
(17, 6, 'Paneer Bhurji Recipe', 'Paneer Bhurji is a quick, flavorful Indian dish made with crumbled paneer (Indian cottage cheese), onions, tomatoes, and a blend of spices. It’s a protein-packed meal that\'s easy to whip up for breakfast, lunch, or dinner. Deliciously spiced and bursting with fresh flavors, Paneer Bhurji can be served with roti, paratha, or even bread for a hearty meal. Perfect for busy weekdays or a satisfying weekend brunch!', '680d01a835f78_paneer-bhurji.jpg', '[\"Heat oil or ghee in a pan. Add cumin seeds and let them splutter.\",\"Add chopped onions and green chilies. Saut\\u00e9 until onions turn golden.\",\"Add ginger-garlic paste and saut\\u00e9 until the raw smell disappears.\",\"Add tomatoes and cook until soft and mushy.\",\"Add turmeric powder, red chili powder, and salt. Mix well.\",\"Add crumbled paneer and gently mix until well combined with the masala.\",\"Cook for 2-3 minutes, stirring occasionally.\",\"Garnish with fresh coriander leaves and serve hot with roti, paratha, or toast.\"]', '[\"200 grams paneer, crumbled\",\"1 tablespoon oil or ghee\",\"1 onion, finely chopped\",\"1 tomato, finely chopped\",\"1 green chili, finely chopped\",\"1 teaspoon ginger-garlic paste\",\"\\u00bd teaspoon turmeric powder\",\"1 teaspoon red chili powder\",\"1 teaspoon cumin seeds\",\"Salt to taste\",\"Fresh coriander leaves for garnish\"]', '2025-04-26 10:24:16'),
(18, 6, 'Handvo Recipe', 'Handvo is a savory, spiced lentil and rice cake from Gujarat, India. Packed with the goodness of mixed dals (lentils), rice, yogurt, and lots of vegetables like bottle gourd and carrots, it\'s flavored with green chilies, ginger, and an aromatic tempering of mustard seeds and sesame seeds. Crispy on the outside and soft inside, Handvo is a wholesome, protein-rich dish perfect for breakfast, lunch, or snacks.', '680d02e14e7ac_handvo-recipe.jpg', '[\"Soak rice and dals together for 4-5 hours. Drain and grind into a coarse batter using little water.\",\"Mix yogurt into the batter, cover, and ferment it overnight.\",\"Add grated bottle gourd, carrot, ginger-chili paste, turmeric, red chili powder, and salt. Mix well.\",\"Just before cooking, add baking soda and mix gently.\",\"Heat oil in a non-stick pan. Add mustard seeds, sesame seeds, hing, and curry leaves for tempering.\",\"Pour the batter into the pan, cover, and cook on low heat until the base turns golden and crisp.\",\"Flip carefully if cooking on the stovetop, or bake at 180\\u00b0C (350\\u00b0F) for about 35\\u201340 minutes if baking.\",\"Cut into slices and serve hot with chutney or tea.\"]', '[\"1 cup rice\",\"\\u00bd cup mixed dals (chana dal, toor dal, urad dal, moong dal)\",\"1 cup grated bottle gourd (lauki)\",\"1 cup yogurt (curd)\",\"1 teaspoon ginger-green chili paste\",\"\\u00bd teaspoon turmeric powder\",\"1 teaspoon red chili powder\",\"1 teaspoon baking soda (or Eno fruit salt)\",\"Salt to taste\",\"1 tablespoon oil\"]', '2025-04-26 10:29:29'),
(20, 6, 'Bengali Khichdi Recipe', 'Bengali Khichdi, also known as Bhoger Khichuri, is a comforting, festive dish made with fragrant rice, roasted moong dal, assorted vegetables, and aromatic spices. It’s especially prepared during Durga Puja and other religious occasions. Unlike regular khichdi, this version is rich, slightly sweet, and has a delightful, ghee-laden flavor. Served typically with fried eggplants, papad, chutney, or beguni, Bengali Khichdi is pure comfort food!', '680d03d28de7d_Bengali-Khichdi.jpg', '[\"Dry roast the moong dal until golden and aromatic. Rinse well and keep aside.\\r\\n\\r\\n\",\"Rinse rice separately and drain.\",\"Heat ghee in a large pan. Add cumin seeds, bay leaves, cinnamon, cloves, and cardamoms.\",\"Add the roasted dal and saut\\u00e9 for a minute.\",\"Add the rice and saut\\u00e9 for another 2-3 minutes.\",\"Add chopped vegetables, turmeric powder, sugar, salt, and green chilies. Mix well.\",\"Pour in water. Cover and cook on medium flame until rice, dal, and vegetables are cooked and the khichdi is soft yet slightly mushy.\",\"Drizzle a little more ghee before serving for enhanced flavor.\"]', '[\"1 cup gobindobhog rice (or basmati rice)\",\"\\u00bd cup moong dal (yellow lentils)\",\"1 cup mixed vegetables (potatoes, peas, carrots, cauliflower)\",\"2 tablespoons ghee\",\"1 teaspoon cumin seeds\",\"2 bay leaves\",\"2-3 green chilies, slit\",\"1-inch cinnamon stick\",\"2 cloves\",\"2 green cardamoms\",\"\\u00bd teaspoon turmeric powder\",\"1 teaspoon sugar\",\"Salt to taste\",\"4 cups water\"]', '2025-04-26 10:33:30'),
(21, 6, 'Kanda Bhaji Recipe', 'Kanda Bhaji, also known as Onion Pakora or Pyaz Bhajiya, is a classic Indian street food snack made with thinly sliced onions, gram flour (besan), and flavorful spices. These crispy, golden fritters are a perfect companion to a hot cup of chai, especially during rainy days. Easy to make and irresistibly crunchy, Kanda Bhaji is a beloved comfort food across India, especially in Maharashtra.', '680d052369742_kanda-bhaji.jpg', '[\"Place the thinly sliced onions in a bowl. Add salt and let them sit for 5\\u201310 minutes to release moisture.\",\"Add besan, rice flour, green chilies, coriander leaves, ajwain, turmeric, and red chili powder.\",\"Mix gently without adding extra water; the moisture from the onions should be enough to bind the batter.\",\"Heat oil in a deep pan or kadhai.\",\"Drop small portions of the mixture into hot oil and fry until golden and crispy.\",\"Remove on paper towels to drain excess oil.\",\"Serve hot with chutney or ketchup and a cup of tea!\"]', '[\"2 large onions, thinly sliced\",\"1 cup besan (gram flour)\",\"2 tablespoons rice flour (for extra crispiness)\",\"2 green chilies, finely chopped\",\"2 tablespoons coriander leaves, chopped\",\"1 teaspoon ajwain (carom seeds)\",\"\\u00bd teaspoon turmeric powder\",\"\\u00bd teaspoon red chili powder\",\"Salt to taste\",\"Oil for deep frying\"]', '2025-04-26 10:39:07'),
(22, 6, 'Kanda Bhaji Recipe', 'Kanda Bhaji, also known as Onion Pakora or Pyaz Bhajiya, is a classic Indian street food snack made with thinly sliced onions, gram flour (besan), and flavorful spices. These crispy, golden fritters are a perfect companion to a hot cup of chai, especially during rainy days. Easy to make and irresistibly crunchy, Kanda Bhaji is a beloved comfort food across India, especially in Maharashtra.', '680d055ea4bdb_kanda-bhaji.jpg', '[\"Place the thinly sliced onions in a bowl. Add salt and let them sit for 5\\u201310 minutes to release moisture.\",\"Add besan, rice flour, green chilies, coriander leaves, ajwain, turmeric, and red chili powder.\",\"Mix gently without adding extra water; the moisture from the onions should be enough to bind the batter.\",\"Heat oil in a deep pan or kadhai.\",\"Drop small portions of the mixture into hot oil and fry until golden and crispy.\",\"Remove on paper towels to drain excess oil.\",\"Serve hot with chutney or ketchup and a cup of tea!\"]', '[\"2 large onions, thinly sliced\",\"1 cup besan (gram flour)\",\"2 tablespoons rice flour (for extra crispiness)\",\"2 green chilies, finely chopped\",\"2 tablespoons coriander leaves, chopped\",\"1 teaspoon ajwain (carom seeds)\",\"\\u00bd teaspoon turmeric powder\",\"\\u00bd teaspoon red chili powder\",\"Salt to taste\",\"Oil for deep frying\"]', '2025-04-26 10:40:06');

-- --------------------------------------------------------

--
-- Table structure for table `recipe_states`
--

CREATE TABLE `recipe_states` (
  `recipe_states_id` int(11) NOT NULL,
  `recipe_id` int(11) DEFAULT NULL,
  `cooking_time` int(11) DEFAULT NULL,
  `prep_time` int(11) DEFAULT NULL,
  `course` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`course`)),
  `diet` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`diet`)),
  `cuisin` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`cuisin`)),
  `calories` int(11) NOT NULL,
  `protein` int(11) NOT NULL,
  `carbohydrates` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `recipe_states`
--

INSERT INTO `recipe_states` (`recipe_states_id`, `recipe_id`, `cooking_time`, `prep_time`, `course`, `diet`, `cuisin`, `calories`, `protein`, `carbohydrates`) VALUES
(5, 12, 30, 10, '\"Main Course\"', '[\"Vegetarian\",\"\"]', '\"North Indian\"', 120, 4, 25),
(6, 13, 45, 15, '\"Main Course\"', '[\"Vegetarian\",\"\"]', '\"North Indian\"', 120, 4, 25),
(8, 15, 10, 10, '\"Lunch,Dinner,Snacks\"', '[\"Vegetarian\",\"\"]', '\"North Indian\"', 320, 8, 45),
(9, 16, 30, 10, '\"Desserts\"', '[\"Vegetarian\",\"Gluten Free\",\"\"]', '\"South-Indian\"', 320, 5, 30),
(10, 17, 15, 10, '\"Breakfast,Lunch,Dinner\"', '[\"Vegetarian\",\"Gluten Free\",\"\"]', '\"Punjabi\"', 280, 14, 10),
(11, 18, 40, 10, '\"Breakfast,Dinner,Snacks\"', '[\"Vegetarian\",\"\"]', '\"Gujarati\"', 210, 8, 28),
(13, 20, 35, 15, '\"Lunch,Dinner\"', '[\"Vegetarian\",\"\"]', '\"Bengali\"', 310, 10, 40),
(14, 21, 15, 10, '\"Snacks\"', '[\"Vegetarian\",\"Gluten Free\",\"\"]', '\"Street-Food,Maharashtrian\"', 220, 6, 22),
(15, 22, 15, 10, '\"Snacks\"', '[\"Vegetarian\",\"Gluten Free\",\"\"]', '\"Street-Food,Maharashtrian\"', 220, 6, 22);

-- --------------------------------------------------------

--
-- Table structure for table `reviews`
--

CREATE TABLE `reviews` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `recipe_id` int(11) DEFAULT NULL,
  `rating` int(11) DEFAULT NULL CHECK (`rating` between 1 and 5),
  `review` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `reviews`
--

INSERT INTO `reviews` (`id`, `user_id`, `recipe_id`, `rating`, `review`, `created_at`) VALUES
(7, 6, 12, 4, 'I love this recipe soo much', '2025-04-26 13:34:53'),
(8, 6, 13, 5, '\r\nThhe taste is so good', '2025-04-26 13:35:31');

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `sr_no` int(11) NOT NULL,
  `site_title` varchar(100) NOT NULL,
  `site_about` text NOT NULL,
  `site_logo` varchar(300) NOT NULL,
  `youtube_link` varchar(200) NOT NULL,
  `facebook_link` varchar(200) NOT NULL,
  `twitter_link` varchar(200) NOT NULL,
  `instagram_link` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`sr_no`, `site_title`, `site_about`, `site_logo`, `youtube_link`, `facebook_link`, `twitter_link`, `instagram_link`) VALUES
(1, 'CooKing', 'Cooking Recipes was created out of a passion for food, cooking, and sharing knowledge. The website was started by a team of food enthusiasts who wanted to share their culinary journey and recipes with the world. What started as a small collection of family recipes quickly grew into a platform that serves millions of cooking enthusiasts globally.', 'https://th.bing.com/th/id/OIP.L9QPFHdNx-GIxjQL4LCSWgHaEu?rs=1&pid=ImgDetMain', 'https://youtube.com/', 'https://facebbok.com/', 'https://twitter.com/', 'https://instagram.com/');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `first_name` varchar(50) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `email` varchar(150) NOT NULL,
  `password` varchar(300) NOT NULL,
  `role` enum('admin','user') DEFAULT 'user',
  `email_verified` int(11) NOT NULL DEFAULT 0,
  `verification_token` varchar(200) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `first_name`, `last_name`, `email`, `password`, `role`, `email_verified`, `verification_token`, `created_at`) VALUES
(6, 'Rushi', 'Sorathiya', 'rsorathiya880@rku.ac.in', '$2y$10$hq5yBC4q7T0WakWuUXXs4.aeF4fkxTbsqkHduWJLKYNQH/JUeUA0y', 'user', 1, 'f84b15e9e8cce2deaa9f84dfb5815772', '2025-04-05 07:37:11'),
(7, 'Krrish', 'Patel', 'kpansara790@rku.ac.in', '$2y$10$.UJfqe9ekYeVlVqzYaCY3u4uqVEtThRGce7X60LxcmJOzK.ZxgGGW', 'user', 1, '15d16bd1ee2e64320f55a5e08cfa9acb', '2025-04-05 07:43:50'),
(8, 'Krish', 'Pansara', 'krishpanasara9265@gmail.com', '$2y$10$MS7UppFAqRtg9mTdlXHu6.rj0L60x2JKBWgBnQixrX8TxOaq2CjO.', 'admin', 1, 'b412673885030c6470541995d4164754', '2025-04-05 07:47:18'),
(12, 'Ved', 'Makadiya', 'makadiyaved04@gmail.com', '$2y$10$45rSi/RNRebqsQb3RrvDN.iSfGP0/Cm4E8rVJmpCPzO1ZFwZXg2pW', 'user', 1, '27bd42a042b7f7f0294e1a3d4108b6b3', '2025-04-07 06:04:38'),
(13, 'Deep', 'Kacha', 'dkacha329@rku.ac.in', '$2y$10$SUjWIDsnIVIDaXR5mq2Vy.usEt0QLaDfSDz1AyYMbuYKJ6Xa7M0BK', 'user', 1, '66c4b72bce856dba9ecab17e4292fe0b', '2025-04-27 10:03:58');

-- --------------------------------------------------------

--
-- Table structure for table `user_follows`
--

CREATE TABLE `user_follows` (
  `id` int(11) NOT NULL,
  `follower_id` int(11) NOT NULL,
  `following_id` int(11) NOT NULL,
  `followed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_follows`
--

INSERT INTO `user_follows` (`id`, `follower_id`, `following_id`, `followed_at`) VALUES
(7, 6, 7, '2025-04-26 11:56:47');

-- --------------------------------------------------------

--
-- Table structure for table `user_profiles`
--

CREATE TABLE `user_profiles` (
  `user_id` int(11) NOT NULL,
  `profile_picture` varchar(255) DEFAULT NULL,
  `bio` text DEFAULT NULL,
  `location` varchar(200) DEFAULT NULL,
  `cuisine_preferences` text DEFAULT NULL,
  `dietary_preferences` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_profiles`
--

INSERT INTO `user_profiles` (`user_id`, `profile_picture`, `bio`, `location`, `cuisine_preferences`, `dietary_preferences`) VALUES
(6, '67f3ec99c4ab2_IMG_20250110_121619.jpg', 'Huh, I have many cooks who makes different foods for me everyday!! ', 'Dubai', 'Indian', 'Vegetarian,low-carb'),
(7, '67f0df92bd00a_IMG_1223.jpeg', 'hello', 'Rajkot, Gujarat', 'Indian', 'Vegetarian,low-carb'),
(8, NULL, NULL, NULL, NULL, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `favorites`
--
ALTER TABLE `favorites`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `recipe_id` (`recipe_id`);

--
-- Indexes for table `followers`
--
ALTER TABLE `followers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `follower_id` (`follower_id`,`following_id`),
  ADD KEY `following_id` (`following_id`);

--
-- Indexes for table `password_token`
--
ALTER TABLE `password_token`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `recipes`
--
ALTER TABLE `recipes`
  ADD PRIMARY KEY (`recipe_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `recipe_states`
--
ALTER TABLE `recipe_states`
  ADD PRIMARY KEY (`recipe_states_id`),
  ADD KEY `recipe_id` (`recipe_id`);

--
-- Indexes for table `reviews`
--
ALTER TABLE `reviews`
  ADD PRIMARY KEY (`id`),
  ADD KEY `reviews_ibfk_1` (`user_id`),
  ADD KEY `reviews_ibfk_2` (`recipe_id`);

--
-- Indexes for table `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`sr_no`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `user_follows`
--
ALTER TABLE `user_follows`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `follower_id` (`follower_id`,`following_id`),
  ADD KEY `following_id` (`following_id`);

--
-- Indexes for table `user_profiles`
--
ALTER TABLE `user_profiles`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `favorites`
--
ALTER TABLE `favorites`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `followers`
--
ALTER TABLE `followers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `password_token`
--
ALTER TABLE `password_token`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `recipes`
--
ALTER TABLE `recipes`
  MODIFY `recipe_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `recipe_states`
--
ALTER TABLE `recipe_states`
  MODIFY `recipe_states_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `reviews`
--
ALTER TABLE `reviews`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `settings`
--
ALTER TABLE `settings`
  MODIFY `sr_no` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `user_follows`
--
ALTER TABLE `user_follows`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `favorites`
--
ALTER TABLE `favorites`
  ADD CONSTRAINT `favorites_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `favorites_ibfk_2` FOREIGN KEY (`recipe_id`) REFERENCES `recipes` (`recipe_id`) ON DELETE CASCADE;

--
-- Constraints for table `followers`
--
ALTER TABLE `followers`
  ADD CONSTRAINT `followers_ibfk_1` FOREIGN KEY (`follower_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `followers_ibfk_2` FOREIGN KEY (`following_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `recipes`
--
ALTER TABLE `recipes`
  ADD CONSTRAINT `recipes_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `recipe_states`
--
ALTER TABLE `recipe_states`
  ADD CONSTRAINT `recipe_states_ibfk_1` FOREIGN KEY (`recipe_id`) REFERENCES `recipes` (`recipe_id`) ON DELETE CASCADE;

--
-- Constraints for table `reviews`
--
ALTER TABLE `reviews`
  ADD CONSTRAINT `reviews_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `reviews_ibfk_2` FOREIGN KEY (`recipe_id`) REFERENCES `recipes` (`recipe_id`) ON DELETE CASCADE;

--
-- Constraints for table `user_follows`
--
ALTER TABLE `user_follows`
  ADD CONSTRAINT `user_follows_ibfk_1` FOREIGN KEY (`follower_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `user_follows_ibfk_2` FOREIGN KEY (`following_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `user_profiles`
--
ALTER TABLE `user_profiles`
  ADD CONSTRAINT `user_profiles_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
