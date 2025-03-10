-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 09, 2025 at 06:31 AM
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
-- Database: `assignment3`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `id` int(11) NOT NULL,
  `fullname` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`id`, `fullname`, `email`, `password`) VALUES
(6, 'Edward(ADMIN)', 'admin@gmail.com', '$2y$10$ecD7MlQYW854cyyIIbqUJ.mn3w.u/XPQoOQrCM.UCmUujdtFUFZUC'),
(7, 'Beatrice(ADMIN)', 'admin2@gmail.com', '$2y$10$kjWpyjcb0jS5EQe4m61AROjVwRR3jhSRNNiS/9o8nTeFGXY4RHGBm'),
(8, 'Theodore(ADMIN)', 'admin3@gmail.com', '$2y$10$E9TGg5TtK/rOanruqHfcX.pyeXcPfTBOhwrUMNJtS4Hb3instTbDm'),
(9, 'Charlotte(ADMIN)', 'admin4@gmail.com', '$2y$10$jA0Vo7Fu.BJIhOi54qgAiOHgtzcLD2ulBjXItKEwInNy.dvcLc832');

-- --------------------------------------------------------

--
-- Table structure for table `assignments`
--

CREATE TABLE `assignments` (
  `id` int(11) NOT NULL,
  `course_name` varchar(255) NOT NULL,
  `file_name` varchar(255) NOT NULL,
  `file_desc` text NOT NULL,
  `file_path` varchar(255) NOT NULL,
  `assignment_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `assignments`
--

INSERT INTO `assignments` (`id`, `course_name`, `file_name`, `file_desc`, `file_path`, `assignment_id`) VALUES
(70, '', 'lab 9 ', 'lab 9 ', 'uploads/Lab 9 Permisson Control.docx', 5),
(73, '', 'Data Science asm', 'submit before next monthh', 'uploads/data science.docx', 13),
(74, '', 'Marketing Asm', 'try to this project', 'uploads/Marketing asm.docx', 14),
(75, '', 'Account asm', 'submit before next monthh', 'uploads/Account.docx', 15),
(78, '', 'Mechanical Engineering', 'try to this project', 'uploads/Mechanical Engineering.docx', 16),
(81, '', 'Biology Asm', 'submit before next month', 'uploads/Biology.docx', 17),
(85, '', 'Pharmacy asm', 'try to this project', 'uploads/Pharmacy.docx', 18),
(88, '', 'Journalism asm', 'Journalism activityt', 'uploads/Journalism asm.docx', 19),
(91, '', 'Criminology asm', 'Criminology activity', 'uploads/Criminology.docx', 21);

-- --------------------------------------------------------

--
-- Table structure for table `courses`
--

CREATE TABLE `courses` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `teacher_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `courses`
--

INSERT INTO `courses` (`id`, `title`, `description`, `teacher_id`) VALUES
(39, 'Web Development', 'HTML, CSS, JavaScript, and responsive design techniques.', 16),
(70, 'Computer Science', 'This course focuses on the study of computing, programming, and software development. Students learn about algorithms, data structures, artificial intelligence, cybersecurity, and web development. Graduates can work as software engineers, data analysts, or IT consultants.', 15),
(73, 'Data Science with Python', 'This course covers essential data science techniques using Python. Topics include data cleaning, visualization, machine learning, and statistical analysis', 9),
(74, 'Marketing', 'Studies consumer behavior, branding, advertising, and digital marketing strategies to promote products and services effectively.', 19),
(75, 'Accounting', 'Focuses on recording, analyzing, and managing financial transactions to ensure accurate financial reporting and compliance.', 20),
(76, 'Financial Management', 'Involves planning, organizing, and controlling financial resources to maximize business profitability and growth.', 22),
(77, 'Auditing', 'Examines financial records and processes to ensure accuracy, detect fraud, and verify compliance with financial regulations.', 21),
(78, 'Mechanical Engineering', 'Focuses on designing, manufacturing, and maintaining mechanical systems, including machines, engines, and robotics.', 23),
(79, 'Electrical & Electronics Engineering', 'Deals with electrical systems, circuits, power generation, and electronic devices like microchips and communication systems.', 24),
(80, 'Civil Engineering', 'Involves designing and constructing infrastructure, such as buildings, bridges, roads, and water systems.', 25),
(81, 'Biology', 'Studies living organisms, including their structure, function, evolution, and interactions with the environment.', 26),
(82, 'Chemistry', 'Focuses on the composition, properties, and reactions of substances, including elements, compounds, and chemical processes.', 27),
(83, 'Physics', 'Explores the fundamental laws of nature, including motion, energy, force, and the behavior of matter and radiation.', 28),
(84, 'Nursing', 'Focuses on patient care, medical assistance, and healthcare management, working closely with doctors to treat and support patients.', 29),
(85, 'Pharmacy', 'Involves the study of medicines, drug interactions, and their safe distribution, ensuring proper use of medications for patient health.', 30),
(86, 'Dentistry', 'Specializes in oral health, diagnosing and treating dental issues, performing surgeries, and promoting preventive dental care.', 31),
(87, 'Mass Communication', 'Covers various media platforms like television, radio, digital, and print to deliver information, entertainment, and news to the public.', 35),
(88, 'Journalism', 'Focuses on researching, investigating, and reporting news through newspapers, magazines, TV, and online platforms with accuracy and ethics.', 36),
(89, 'Public Relations (PR)', 'Manages a company’s or individual’s public image by handling media relations, crisis communication, and brand reputation.', 37),
(90, 'Psychology', 'Studies human behavior, emotions, and mental processes to understand and improve individual well-being and social interactions.', 32),
(91, 'Criminology', 'Examines crime, criminal behavior, and law enforcement, focusing on crime prevention, justice systems, and rehabilitation.', 34),
(92, 'Political Science', 'Analyzes government systems, political behavior, policies, and international relations to understand power structures and governance.', 33),
(94, 'Business Administration', 'Covers management, finance, operations, and leadership to run businesses efficiently and make strategic decisions.', 17);

-- --------------------------------------------------------

--
-- Table structure for table `department`
--

CREATE TABLE `department` (
  `id` int(11) NOT NULL,
  `department_name` varchar(255) NOT NULL,
  `person_incharge` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `department`
--

INSERT INTO `department` (`id`, `department_name`, `person_incharge`, `created_at`) VALUES
(8, 'Technology & Programming', 'Dr Shawarmah', '2025-03-01 10:12:23'),
(9, 'Business & Management', 'Dr Kuntucky', '2025-03-02 11:17:00'),
(10, 'Accounting & Finance', 'Dr Zanmai', '2025-03-02 21:21:19'),
(11, 'Engineering', 'Dr Stone', '2025-03-02 08:20:23'),
(12, 'Science & Mathematics', 'Dr Mochi', '2025-03-02 08:21:36'),
(13, 'Health & Medical Sciences', 'Dr Yoimiya', '2025-03-02 08:22:14'),
(14, 'Law & Social Sciences', 'Dr Bugremon', '2025-03-02 08:23:09'),
(15, 'Media & Communication', 'Dr Mangkali', '2025-03-02 08:23:38');

-- --------------------------------------------------------

--
-- Table structure for table `downloadable_materials`
--

CREATE TABLE `downloadable_materials` (
  `id` int(11) NOT NULL,
  `course_id` int(11) NOT NULL,
  `file_name` varchar(255) NOT NULL,
  `file_desc` text NOT NULL,
  `file_path` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `downloadable_materials`
--

INSERT INTO `downloadable_materials` (`id`, `course_id`, `file_name`, `file_desc`, `file_path`) VALUES
(5, 70, 'Cyber Section A.docx', 'cyber question', 'uploads/Cyber Section A.docx'),
(9, 80, 'Cheh Qin Hui.pdf', 'aa', 'uploads/Cheh Qin Hui.pdf'),
(10, 73, 'python-data-science.htm', 'sample code from github', 'uploads/python-data-science.htm'),
(11, 73, 'data science handbook.htm', 'information about data science', 'uploads/data science handbook.htm'),
(12, 74, 'Marketing.htm', 'Marketing tips', 'uploads/Marketing.htm'),
(13, 75, 'Account.htm', 'Learning Accountant basic', 'uploads/Account.htm'),
(14, 78, 'mechanical-engineering.htm', 'learn this website before class start', 'uploads/mechanical-engineering.htm'),
(15, 81, 'Biology.htm', 'Biology tips', 'uploads/Biology.htm'),
(16, 85, 'Pharmacy.htm', 'Pharmacy learning materials', 'uploads/Pharmacy.htm'),
(17, 88, 'Journalism communications.htm', 'Journalism communications', 'uploads/Journalism communications.htm'),
(19, 91, 'Criminology.htm', 'Criminology materials', 'uploads/Criminology.htm');

-- --------------------------------------------------------

--
-- Table structure for table `quizzes`
--

CREATE TABLE `quizzes` (
  `id` int(11) NOT NULL,
  `course_id` int(11) DEFAULT NULL,
  `question` text NOT NULL,
  `answer` enum('True','False') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `quizzes`
--

INSERT INTO `quizzes` (`id`, `course_id`, `question`, `answer`) VALUES
(12, 73, 'Python is the only programming language used for Data Science.', 'False'),
(13, 73, 'Pandas is a library used for data manipulation and analysis in Python.', 'True'),
(14, 73, 'NumPy is mainly used for working with relational databases.', 'False'),
(15, 73, 'Matplotlib and Seaborn are commonly used for data visualization.', 'True'),
(16, 73, 'Machine learning models in Python can only be built using TensorFlow.', 'False'),
(17, 74, 'Digital marketing only includes social media advertising.', 'False'),
(18, 74, 'A SWOT analysis is used to evaluate a company\'s strengths, weaknesses, opportunities, and threats.', 'True'),
(19, 74, 'Branding is not important for customer loyalty.', 'False'),
(20, 74, 'The 4Ps of marketing include Product, Price, Place, and Promotion.', 'True'),
(21, 74, 'Customer feedback is not essential in developing a marketing strategy.', 'False'),
(22, 75, 'The accounting equation is Assets = Liabilities + Equity.', 'True'),
(23, 75, 'Revenue is recorded as a liability on the balance sheet.', 'False'),
(24, 75, 'Depreciation reduces the value of a fixed asset over time.', 'True'),
(25, 75, 'In double-entry accounting, every transaction affects only one account.', 'False'),
(26, 75, 'A balance sheet shows a company\'s financial position at a specific point in time.', 'True'),
(27, 78, 'Newton’s First Law states that an object will remain at rest or in uniform motion unless acted upon by an external force.', 'True'),
(28, 78, 'Torque is a force that causes linear motion.', 'False'),
(29, 78, 'A flywheel is used to store rotational energy.', 'True'),
(30, 78, 'Heat transfer occurs only through conduction.', 'False'),
(31, 78, 'A cantilever beam is fixed at both ends.', 'False'),
(32, 81, 'The cell is the basic unit of life.', 'True'),
(33, 81, 'DNA is found only in the nucleus of a cell.', 'False'),
(34, 81, 'Photosynthesis occurs in the mitochondria of plant cells.', 'False'),
(35, 81, 'Red blood cells transport oxygen throughout the body.', 'True'),
(36, 81, 'Viruses are considered living organisms.', 'False'),
(37, 88, 'Journalism is the practice of gathering, assessing, creating, and presenting news and information.', 'True'),
(38, 88, 'A news article should always contain the journalist’s personal opinions.', 'False'),
(39, 88, 'he \"5 Ws and 1 H\" (Who, What, When, Where, Why, How) are essential in news reporting.', 'True'),
(40, 88, 'Investigative journalism involves in-depth reporting to uncover hidden facts.', 'True'),
(41, 88, 'A journalist should verify facts from multiple reliable sources before publishing.', 'True'),
(42, 85, 'All medicines are safe to use without a prescription.', 'False'),
(43, 85, 'Pharmacists can provide advice on drug interactions.', 'True'),
(44, 85, 'Over-the-counter (OTC) medications do not have side effects.', 'False'),
(45, 85, 'A pharmacist\'s primary role is to dispense medications.', 'True'),
(46, 85, 'All generic drugs are less effective than brand-name drugs.', 'False'),
(47, 91, 'Criminology is the study of crime, criminals, and the criminal justice system.', 'True'),
(48, 91, 'All crimes are considered criminal offenses under the law.', 'False'),
(49, 91, 'Criminologists primarily work as police officers.', 'False'),
(50, 91, 'White-collar crimes refer to non-violent financial crimes.', 'True'),
(51, 91, 'Theories in criminology help explain why people commit crimes.', 'True');

-- --------------------------------------------------------

--
-- Table structure for table `quiz_results`
--

CREATE TABLE `quiz_results` (
  `id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `course_id` int(11) NOT NULL,
  `score` decimal(5,2) NOT NULL,
  `taken_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `quiz_results`
--

INSERT INTO `quiz_results` (`id`, `student_id`, `course_id`, `score`, `taken_at`) VALUES
(4, 22, 73, 33.33, '2025-03-02 11:22:06'),
(9, 25, 73, 0.00, '2025-03-07 15:31:38'),
(10, 25, 73, 100.00, '2025-03-07 15:31:54'),
(11, 23, 74, 40.00, '2025-03-07 15:33:13'),
(12, 35, 75, 60.00, '2025-03-07 15:44:15'),
(13, 27, 78, 60.00, '2025-03-07 15:50:31'),
(14, 27, 81, 40.00, '2025-03-07 15:54:26'),
(15, 23, 85, 20.00, '2025-03-07 16:01:08'),
(16, 41, 85, 0.00, '2025-03-07 16:06:08'),
(17, 41, 85, 100.00, '2025-03-07 16:06:16'),
(18, 31, 91, 80.00, '2025-03-07 16:23:07');

-- --------------------------------------------------------

--
-- Table structure for table `quiz_submissions`
--

CREATE TABLE `quiz_submissions` (
  `id` int(11) NOT NULL,
  `student_id` int(11) DEFAULT NULL,
  `course_id` int(11) DEFAULT NULL,
  `quiz_id` int(11) DEFAULT NULL,
  `student_answer` enum('True','False') DEFAULT NULL,
  `submitted_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `quiz_submissions`
--

INSERT INTO `quiz_submissions` (`id`, `student_id`, `course_id`, `quiz_id`, `student_answer`, `submitted_at`) VALUES
(26, 25, 73, 12, 'True', '2025-03-07 15:31:38'),
(27, 25, 73, 13, 'False', '2025-03-07 15:31:38'),
(28, 25, 73, 14, 'True', '2025-03-07 15:31:38'),
(29, 25, 73, 15, 'False', '2025-03-07 15:31:38'),
(30, 25, 73, 16, 'True', '2025-03-07 15:31:38'),
(31, 25, 73, 12, 'False', '2025-03-07 15:31:54'),
(32, 25, 73, 13, 'True', '2025-03-07 15:31:54'),
(33, 25, 73, 14, 'False', '2025-03-07 15:31:54'),
(34, 25, 73, 15, 'True', '2025-03-07 15:31:54'),
(35, 25, 73, 16, 'False', '2025-03-07 15:31:54'),
(36, 23, 74, 17, 'True', '2025-03-07 15:33:13'),
(37, 23, 74, 18, 'True', '2025-03-07 15:33:13'),
(38, 23, 74, 19, 'False', '2025-03-07 15:33:13'),
(39, 23, 74, 20, 'False', '2025-03-07 15:33:13'),
(40, 23, 74, 21, 'True', '2025-03-07 15:33:13'),
(41, 35, 75, 22, 'True', '2025-03-07 15:44:15'),
(42, 35, 75, 23, 'True', '2025-03-07 15:44:15'),
(43, 35, 75, 24, 'True', '2025-03-07 15:44:15'),
(44, 35, 75, 25, 'False', '2025-03-07 15:44:15'),
(45, 35, 75, 26, 'False', '2025-03-07 15:44:15'),
(46, 27, 78, 27, 'False', '2025-03-07 15:50:31'),
(47, 27, 78, 28, 'False', '2025-03-07 15:50:31'),
(48, 27, 78, 29, 'True', '2025-03-07 15:50:31'),
(49, 27, 78, 30, 'True', '2025-03-07 15:50:31'),
(50, 27, 78, 31, 'False', '2025-03-07 15:50:31'),
(51, 27, 81, 32, 'False', '2025-03-07 15:54:26'),
(52, 27, 81, 33, 'False', '2025-03-07 15:54:26'),
(53, 27, 81, 34, 'False', '2025-03-07 15:54:26'),
(54, 27, 81, 35, 'False', '2025-03-07 15:54:26'),
(55, 27, 81, 36, 'True', '2025-03-07 15:54:26'),
(56, 23, 85, 42, 'True', '2025-03-07 16:01:08'),
(57, 23, 85, 43, 'False', '2025-03-07 16:01:08'),
(58, 23, 85, 44, 'False', '2025-03-07 16:01:08'),
(59, 23, 85, 45, 'False', '2025-03-07 16:01:08'),
(60, 23, 85, 46, 'True', '2025-03-07 16:01:08'),
(61, 41, 85, 42, 'True', '2025-03-07 16:06:08'),
(62, 41, 85, 43, 'False', '2025-03-07 16:06:08'),
(63, 41, 85, 44, 'True', '2025-03-07 16:06:08'),
(64, 41, 85, 45, 'False', '2025-03-07 16:06:08'),
(65, 41, 85, 46, 'True', '2025-03-07 16:06:08'),
(66, 41, 85, 42, 'False', '2025-03-07 16:06:16'),
(67, 41, 85, 43, 'True', '2025-03-07 16:06:16'),
(68, 41, 85, 44, 'False', '2025-03-07 16:06:16'),
(69, 41, 85, 45, 'True', '2025-03-07 16:06:16'),
(70, 41, 85, 46, 'False', '2025-03-07 16:06:16'),
(71, 31, 91, 47, 'False', '2025-03-07 16:23:07'),
(72, 31, 91, 48, 'False', '2025-03-07 16:23:07'),
(73, 31, 91, 49, 'False', '2025-03-07 16:23:07'),
(74, 31, 91, 50, 'True', '2025-03-07 16:23:07'),
(75, 31, 91, 51, 'True', '2025-03-07 16:23:07');

-- --------------------------------------------------------

--
-- Table structure for table `students`
--

CREATE TABLE `students` (
  `student_id` int(11) NOT NULL,
  `fullname` varchar(255) NOT NULL,
  `id_number` varchar(50) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `students`
--

INSERT INTO `students` (`student_id`, `fullname`, `id_number`, `email`, `password`) VALUES
(12, 'Orion', 'TP036498', 'orion@gmail.com', '$2y$10$rhHjai55E1lE8iJAsW6DOO3t/rdgCTnN.JOZ4bX6j/wGvo5AyAugq'),
(22, 'Caleb Winters', 'TP030738', 'Caleb@gmail.com', '$2y$10$Ed5ll6WUQr9MY7xPPSB.YuCV819KddBFM7QK3r3qSoetSY0pG325.'),
(23, 'Ethan Hawthorne', 'TP066320', 'Ethan@gmail.com', '$2y$10$dQURvLQUaGCaEvhjJdPzp.RmvRd7Faq45wUD2JK3dq4vyf6wJuO3i'),
(24, 'Lena Sinclair', 'TP032552', 'Lena@gmail.com', '$2y$10$kcnqvfQDCGA0J3MItX4zYOxOONfqSkBU0IzRo6ThDraXZ7lXHe2DO'),
(25, 'Mira Davenport', 'TP026977', 'Mira@gmail.com', '$2y$10$YaEKYOM4Z4O0Avs9oZk46OTiNqHacZt.EfV5ZC/bbNePXV1Dgwhie'),
(26, 'Felix Montgomery', 'TP040213', 'Felix@gmail.com', '$2y$10$nxtSYhT17kcIxgYEzzHub.6jQntCA0f8JucnK03duRXDSyaWtuy0e'),
(27, 'Ava Calloway', 'TP034651', 'Ava@gmail.com', '$2y$10$y9uqkmhDKGvB18x4QMk2qOUziBd6id8PJX8veA/y6flFBdqmN57Im'),
(28, 'Jasper Whitmore', 'TP073513', 'Jasper@gmail.com', '$2y$10$vzP8uhiYdS0mK1.ar/OW0OGBcSmw1rMZkZf9RcQo4PlsTzZMmGh5y'),
(29, 'Noelle Fairfax', 'TP046648', 'Noelle@gmail.com', '$2y$10$U52mO.EgOc1CSVRgxHnx3.K/Mw4hF1Eow/B6kWMpt4I8hnxgQZyFW'),
(30, 'Gideon Blake', 'TP068756', 'Gideon@gmail.com', '$2y$10$I5WdggOPacfwfy/Rm1sAkOaMIRB/4L7uLDcKb57vc3HAwcWXL8AAe'),
(31, 'Sienna Aldridge', 'TP077953', 'Sienna@gmail.com', '$2y$10$JkehQqBNAEN1mlJlwA.yvuO4B6aD0I4BhOOBobZ3nsEDCfOAgUSsi'),
(32, 'Zachary Langston', 'TP025031', 'Zachary@gmail.com', '$2y$10$CXj5.AC.WMu31OuByWLtX.aP3uz80CmNZk6u2MEWonD3Q4veUh1c6'),
(33, 'Isla Remington', 'TP058042', 'Isla@gmail.com', '$2y$10$E6RJhk5sFLxrGu40IsU4Ju7iPy4Bde5Rc.CjBUfnasrfVdA.Q1a9u'),
(34, 'Damian Holloway', 'TP061582', 'Damian@gmail.com', '$2y$10$G.KBX8ozZTw5YLjmvEoM2.aFhYs4uNg8Qy7xh/rEPHZacvCrewIY.'),
(35, 'Vivian Crosswell', 'TP063782', 'Vivian@gmail.com', '$2y$10$9l5oMuQUyoer7.Aw.hUrB.tEGA4GNppPMsoPubDejTYkjqiF9VxT2'),
(36, 'Sebastian Fordham', 'TP040125', 'Sebastian@gmail.com', '$2y$10$viffehwMm80959BLP191a.DzXvBgcBWh7FlYDTswJxDqjR06kqEwm'),
(37, 'Elodie Prescott', 'TP054179', 'Elodie@gmail.com', '$2y$10$9yrRG10gfbWZEQktZrbv6Oe.iwnFo8Agrg9h9V3KQB0ha8qTxlcTi'),
(38, 'Grayson Thatcher', 'TP058939', 'Grayson@gmail.com', '$2y$10$A92aPivgqOeRAkv8AJ1rPuZViEqxL/lfm8hg83wNeqLac1DjHz5lC'),
(39, 'Ophelia Winslow', 'TP079958', 'Ophelia@gmail.com', '$2y$10$KXb.cCu0jzOBm8Vv9fWUR.Z8flgbN/VQKFavobD2FkEiPbGXAqNLC'),
(40, 'Xavier Kensington', 'TP095973', 'Xavier@gmail.com', '$2y$10$RoEXjZy6Cs2NxCuNQ0bRxetNll5yfbzJG0NV7AtNLH3jiaueKpH.G'),
(41, 'Celeste Hawthorne', 'TP070394', 'Celeste@gmail.com', '$2y$10$Gk9SOWpTJl.0tn8cNb5eMOaaKtDMKOEf56DWLRm83IrYPIHquUkXi');

-- --------------------------------------------------------

--
-- Table structure for table `student_classes`
--

CREATE TABLE `student_classes` (
  `id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `class_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `student_classes`
--

INSERT INTO `student_classes` (`id`, `student_id`, `class_id`) VALUES
(12, 22, 70),
(13, 22, 66),
(14, 22, 71),
(17, 23, 66),
(19, 23, 70),
(21, 22, 80),
(22, 12, 75),
(23, 12, 79),
(24, 12, 86),
(25, 12, 88),
(26, 23, 74),
(27, 23, 81),
(28, 23, 83),
(29, 23, 85),
(30, 24, 89),
(31, 24, 90),
(32, 24, 88),
(33, 24, 87),
(34, 24, 94),
(35, 24, 91),
(36, 24, 92),
(37, 25, 74),
(38, 25, 39),
(39, 25, 70),
(40, 25, 73),
(41, 25, 87),
(42, 26, 91),
(43, 26, 90),
(44, 26, 92),
(45, 26, 88),
(46, 26, 89),
(47, 26, 79),
(48, 27, 78),
(49, 27, 79),
(50, 27, 81),
(51, 27, 80),
(52, 28, 74),
(53, 28, 76),
(54, 28, 91),
(55, 28, 94),
(56, 29, 39),
(57, 29, 70),
(58, 29, 73),
(59, 29, 80),
(60, 29, 79),
(61, 30, 82),
(62, 30, 81),
(63, 30, 83),
(64, 31, 91),
(65, 31, 88),
(66, 31, 89),
(67, 31, 87),
(68, 32, 84),
(69, 32, 86),
(70, 32, 83),
(71, 32, 87),
(72, 33, 94),
(73, 33, 73),
(74, 33, 74),
(75, 34, 91),
(76, 34, 94),
(77, 34, 39),
(78, 34, 76),
(79, 35, 87),
(80, 35, 39),
(81, 35, 70),
(82, 35, 75),
(83, 36, 86),
(84, 36, 90),
(85, 36, 89),
(86, 37, 84),
(87, 37, 73),
(88, 37, 79),
(89, 37, 76),
(90, 38, 87),
(91, 38, 70),
(92, 38, 75),
(93, 38, 80),
(94, 39, 90),
(95, 39, 75),
(96, 39, 77),
(97, 40, 94),
(98, 40, 77),
(99, 40, 76),
(100, 40, 75),
(101, 40, 74),
(102, 41, 83),
(103, 41, 85),
(104, 41, 86),
(105, 41, 84),
(106, 41, 82),
(107, 41, 73),
(108, 22, 93);

-- --------------------------------------------------------

--
-- Table structure for table `submitted_assignments`
--

CREATE TABLE `submitted_assignments` (
  `id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `course_id` int(11) NOT NULL,
  `file_name` varchar(255) NOT NULL,
  `file_desc` text DEFAULT NULL,
  `file_path` varchar(255) NOT NULL,
  `submitted_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `submitted_assignments`
--

INSERT INTO `submitted_assignments` (`id`, `student_id`, `course_id`, `file_name`, `file_desc`, `file_path`, `submitted_at`) VALUES
(1, 12, 39, 'Testing', 'Testring', 'uploads/assignments/student_12_1740767814.pdf', '2025-02-28 18:36:54'),
(2, 22, 70, 'cheh', 'cheh', 'uploads/assignments/student_22_1740835589.pdf', '2025-03-01 13:26:29'),
(4, 22, 39, 'submit', 'submit', 'uploads/assignments/student_22_1740849595.pdf', '2025-03-01 17:19:55'),
(10, 22, 73, 'submit assignment ', 'for testing', 'uploads/assignments/student_22_1740914515.pdf', '2025-03-02 11:21:55'),
(13, 25, 73, 'Data Science asm', 'submited', 'uploads/assignments/student_25_1741361482.docx', '2025-03-07 15:31:22'),
(14, 23, 74, 'Marketing Asm', 'submited', 'uploads/assignments/student_23_1741361585.docx', '2025-03-07 15:33:05'),
(15, 35, 75, 'Account asm', 'submited', 'uploads/assignments/student_35_1741362250.docx', '2025-03-07 15:44:10'),
(16, 27, 78, 'Mechanical Engineering', 'submited', 'uploads/assignments/student_27_1741362621.docx', '2025-03-07 15:50:21'),
(17, 27, 81, 'Biology Asm', 'submited', 'uploads/assignments/student_27_1741362852.docx', '2025-03-07 15:54:12'),
(18, 23, 85, 'Pharmacy asm', 'submited', 'uploads/assignments/student_23_1741362997.docx', '2025-03-07 15:56:37'),
(19, 41, 85, 'Pharmacy asm', 'submited', 'uploads/assignments/student_41_1741363562.docx', '2025-03-07 16:06:02'),
(20, 24, 88, 'Journalism asm', 'submited', 'uploads/assignments/student_24_1741364029.docx', '2025-03-07 16:13:49'),
(21, 31, 91, 'Criminology asm', 'submited', 'uploads/assignments/student_31_1741364580.docx', '2025-03-07 16:23:00');

-- --------------------------------------------------------

--
-- Table structure for table `teachers`
--

CREATE TABLE `teachers` (
  `id` int(11) NOT NULL,
  `department` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `teachers`
--

INSERT INTO `teachers` (`id`, `department`, `name`, `email`, `password`, `created_at`) VALUES
(9, 'Technology & Programming', 'James(Programming)', 'James@gmail.com', '$2y$10$5c.h/CzslwFbRLbQod7STeoIXmZ5.eN/cPPNx023hDVltg/vxdsm6', '2025-02-19 05:04:19'),
(15, 'Technology & Programming', 'Aria(Programming)', 'Aria@gmail.com', '$2y$10$Wz54cfiAxXQgfm1l2W3YGOi4o.hzR9OFcicEnLZxCC0whGVVtfNry', '2025-03-01 10:12:39'),
(16, 'Technology & Programming', 'Eleanor(Programming)', 'Eleanor@gmail.com', '$2y$10$l3/gzxfaT7jYwRLns5yPouZ1HBn8EpoioZZ52z5g8zGxZ1T2UWmui', '2025-03-02 08:54:11'),
(17, 'Business & Management', 'Emma(Business)', 'Emma@gmail.com', '$2y$10$WidgMn0Jte00cNTzWu6vxehwT0j/DcIynh7DpKk8K7jmxvjNLBmWK', '2025-03-02 11:17:23'),
(18, 'Business & Management', 'Michael(Business)', 'Michael@gmail.com', '$2y$10$RgdeGnnEbn4M8GyfxQ7uN.89vgInwnQxByD6rAuvw3Zq9BPvZSF/6', '2025-03-02 21:21:33'),
(19, 'Business & Management', 'Olivia(Business)', 'Olivia@gmail.com', '$2y$10$fnYL7oAoduLkT38uVKOinuduUgCF0kyu.rv7N0uWIfU7LlmXKHUuK', '2025-03-02 21:22:05'),
(20, 'Accounting & Finance', 'William(Account)', 'William@gmail.com', '$2y$10$16/d.KuIcThelwWO5Pplfee0yGmHsdDzUm7g4aQLbzWe5k5a89W0i', '2025-03-02 10:34:18'),
(21, 'Accounting & Finance', 'Sophia(Account)', 'Sophia@gmail.com', '$2y$10$pC2wz62DKvkKKpw57GgcDu4J7OdAtyR12W1n0mgbxDYzPariA.T9i', '2025-03-02 10:41:33'),
(22, 'Accounting & Finance', 'Daniel(Account)', 'Daniel@gmail.com', '$2y$10$ckmCeJ.VW.X/dm/TscpTcOKMAONUvTKJpfupyHaocvTQFf0Jwj86C', '2025-03-02 10:42:06'),
(23, 'Engineering', 'David(Engineering)', 'David@gmail.com', '$2y$10$Ii/WCBGEFaZRv7TBT/aDveJW0vuEFXGMKbRoWSrXRGZtteDtmdNDq', '2025-03-02 10:42:57'),
(24, 'Engineering', 'Ava(Engineering)', 'Ava@gmail.com', '$2y$10$nghjyyaGy4cPOodF1wxVyOkirol3WruCSMFDEt6gi7YJ2Zj8xZrXm', '2025-03-02 11:07:12'),
(25, 'Engineering', 'Isabella(Engineering)', 'Isabella@gmail.com', '$2y$10$G7ks68hRfD.RKNQ1BhEHge3luq7j4pAQfd6PWoT9A1WLhC7hrU4SK', '2025-03-02 11:08:15'),
(26, 'Science & Mathematics', 'Noah(Science)', 'Noah@gmail.com', '$2y$10$oJV2khJ946Ad31NzVoAEwuG28Lk0kHcS5I6PkKdzYvogd5wg5if8W', '2025-03-02 11:09:06'),
(27, 'Science & Mathematics', 'Luna(Science)', 'Luna@gmail.com', '$2y$10$8WIHwPiSdU4XVMghnjXOb.ySB8IN5fYduK/t1OSO7Zwpr4Hi6qD9.', '2025-03-02 11:10:35'),
(28, 'Science & Mathematics', 'Mason(Science)', 'Mason@gmail.com', '$2y$10$OF9B9DVYz2vsLwwh6yhYuuXMYg/oTWFY4z8km2jujExcuhMTX/Ufq', '2025-03-02 11:11:45'),
(29, 'Health & Medical Sciences', 'Harper(Medical Sciences)', 'Harper@gmail.com', '$2y$10$FvpqqcprBZiopQnG2m9Lx..OoLcA383nogkZEP8xjWpZefmBbUluy', '2025-03-02 11:15:13'),
(30, 'Health & Medical Sciences', 'Ezra(Medical Sciences)', 'Ezra@gmail.com', '$2y$10$taLD.3MSz5uSeVncmws5zOM.sl5Lq8q1GBHycQI7XPjZsuDT3jPh.', '2025-03-02 11:15:38'),
(31, 'Health & Medical Sciences', 'Nova(Medical Sciences)', 'Nova@gmail.com', '$2y$10$lfgwwwoSTdyGRP.Y9scOC.LaaJuk/AlXcX8ea6hzo1kEFiXN7/ABm', '2025-03-02 11:22:32'),
(32, 'Law & Social Sciences', 'Jaxon(Law)', 'Jaxon@gmail.com', '$2y$10$kJnQ11HsmLcu9WKnFQ0xuO2pD8aumrYoaV7HAIILCN.VfUDEOh/CC', '2025-03-02 11:32:49'),
(33, 'Law & Social Sciences', 'Zoey(Law)', 'Zoey@gmail.com', '$2y$10$uuxzd5kElb76hTRadJHoEeTbY6bmgKvQ72UlNuvCA46qhjmpDlRoq', '2025-03-02 11:33:56'),
(34, 'Law & Social Sciences', 'Charles(Law)', 'Charles@gmail.com', '$2y$10$NLMGgwd8naCUxudOPPSreenr44rFHGgcWm106Pm9SQp/Y1ZlulGhm', '2025-03-02 11:34:26'),
(35, 'Media & Communication', 'Henry(Media)', 'Henry@gmail.com', '$2y$10$nEFwZszeQWgwjuE66cW8..bZze0.Jd8aH1kgnDjhOX8LZSr9rUEaS', '2025-03-02 11:35:13'),
(36, 'Media & Communication', 'Katherin(Media)', 'Katherine@gmail.com', '$2y$10$5Xe1JxZAEeeVU.9iE.V53OdwUdPbwpUM23/AGoB6jFuh/xPvcWcVC', '2025-03-02 11:35:31'),
(37, 'Media & Communication', 'Margaret(Media)', 'Margaret@gmail.com', '$2y$10$xUIOeTXjB3iF6a0hTa513uholJhFMj58Bvt8ZFghQoCuc0hQldGAS', '2025-03-02 11:35:53');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `assignments`
--
ALTER TABLE `assignments`
  ADD PRIMARY KEY (`assignment_id`);

--
-- Indexes for table `courses`
--
ALTER TABLE `courses`
  ADD PRIMARY KEY (`id`),
  ADD KEY `teacher_id` (`teacher_id`);

--
-- Indexes for table `department`
--
ALTER TABLE `department`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `downloadable_materials`
--
ALTER TABLE `downloadable_materials`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `quizzes`
--
ALTER TABLE `quizzes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `course_id` (`course_id`);

--
-- Indexes for table `quiz_results`
--
ALTER TABLE `quiz_results`
  ADD PRIMARY KEY (`id`),
  ADD KEY `student_id` (`student_id`),
  ADD KEY `course_id` (`course_id`);

--
-- Indexes for table `quiz_submissions`
--
ALTER TABLE `quiz_submissions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `student_id` (`student_id`),
  ADD KEY `course_id` (`course_id`),
  ADD KEY `quiz_id` (`quiz_id`);

--
-- Indexes for table `students`
--
ALTER TABLE `students`
  ADD PRIMARY KEY (`student_id`),
  ADD UNIQUE KEY `id_number` (`id_number`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `student_classes`
--
ALTER TABLE `student_classes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `student_id` (`student_id`),
  ADD KEY `class_id` (`class_id`);

--
-- Indexes for table `submitted_assignments`
--
ALTER TABLE `submitted_assignments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `student_id` (`student_id`),
  ADD KEY `course_id` (`course_id`);

--
-- Indexes for table `teachers`
--
ALTER TABLE `teachers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `assignments`
--
ALTER TABLE `assignments`
  MODIFY `assignment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `courses`
--
ALTER TABLE `courses`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=96;

--
-- AUTO_INCREMENT for table `department`
--
ALTER TABLE `department`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `downloadable_materials`
--
ALTER TABLE `downloadable_materials`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `quizzes`
--
ALTER TABLE `quizzes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=52;

--
-- AUTO_INCREMENT for table `quiz_results`
--
ALTER TABLE `quiz_results`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `quiz_submissions`
--
ALTER TABLE `quiz_submissions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=76;

--
-- AUTO_INCREMENT for table `students`
--
ALTER TABLE `students`
  MODIFY `student_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- AUTO_INCREMENT for table `student_classes`
--
ALTER TABLE `student_classes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=109;

--
-- AUTO_INCREMENT for table `submitted_assignments`
--
ALTER TABLE `submitted_assignments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `teachers`
--
ALTER TABLE `teachers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `courses`
--
ALTER TABLE `courses`
  ADD CONSTRAINT `courses_ibfk_1` FOREIGN KEY (`teacher_id`) REFERENCES `teachers` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `quizzes`
--
ALTER TABLE `quizzes`
  ADD CONSTRAINT `quizzes_ibfk_1` FOREIGN KEY (`course_id`) REFERENCES `courses` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `quiz_results`
--
ALTER TABLE `quiz_results`
  ADD CONSTRAINT `quiz_results_ibfk_1` FOREIGN KEY (`student_id`) REFERENCES `students` (`student_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `quiz_results_ibfk_2` FOREIGN KEY (`course_id`) REFERENCES `courses` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `quiz_submissions`
--
ALTER TABLE `quiz_submissions`
  ADD CONSTRAINT `quiz_submissions_ibfk_1` FOREIGN KEY (`student_id`) REFERENCES `students` (`student_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `quiz_submissions_ibfk_2` FOREIGN KEY (`course_id`) REFERENCES `courses` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `quiz_submissions_ibfk_3` FOREIGN KEY (`quiz_id`) REFERENCES `quizzes` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `submitted_assignments`
--
ALTER TABLE `submitted_assignments`
  ADD CONSTRAINT `submitted_assignments_ibfk_1` FOREIGN KEY (`student_id`) REFERENCES `students` (`student_id`),
  ADD CONSTRAINT `submitted_assignments_ibfk_2` FOREIGN KEY (`course_id`) REFERENCES `courses` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
