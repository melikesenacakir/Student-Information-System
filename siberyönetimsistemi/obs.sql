-- MySQL dump 10.13  Distrib 8.0.34, for Win64 (x86_64)
--
-- Host: localhost    Database: obs
-- ------------------------------------------------------
-- Server version	8.0.34

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `t_classes`
--

DROP TABLE IF EXISTS `t_classes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `t_classes` (
  `id` int NOT NULL AUTO_INCREMENT,
  `class_teacher_id` int DEFAULT NULL,
  `class_name` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `class_teacher_id` (`class_teacher_id`),
  CONSTRAINT `t_classes_ibfk_1` FOREIGN KEY (`class_teacher_id`) REFERENCES `t_users` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `t_classes`
--

LOCK TABLES `t_classes` WRITE;
/*!40000 ALTER TABLE `t_classes` DISABLE KEYS */;
/*!40000 ALTER TABLE `t_classes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `t_classes_students`
--

DROP TABLE IF EXISTS `t_classes_students`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `t_classes_students` (
  `id` int NOT NULL AUTO_INCREMENT,
  `student_id` int NOT NULL,
  `class_id` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `class_id` (`class_id`),
  KEY `student_id` (`student_id`),
  CONSTRAINT `t_classes_students_ibfk_1` FOREIGN KEY (`class_id`) REFERENCES `t_classes` (`id`),
  CONSTRAINT `t_classes_students_ibfk_2` FOREIGN KEY (`student_id`) REFERENCES `t_users` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `t_classes_students`
--

LOCK TABLES `t_classes_students` WRITE;
/*!40000 ALTER TABLE `t_classes_students` DISABLE KEYS */;
/*!40000 ALTER TABLE `t_classes_students` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `t_exams`
--

DROP TABLE IF EXISTS `t_exams`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `t_exams` (
  `id` int NOT NULL AUTO_INCREMENT,
  `student_id` int NOT NULL,
  `lesson_id` int NOT NULL,
  `class_id` int NOT NULL,
  `exam_score` tinyint NOT NULL,
  `exam_date` timestamp NOT NULL,
  PRIMARY KEY (`id`),
  KEY `student_id` (`student_id`),
  KEY `lesson_id` (`lesson_id`),
  KEY `class_id` (`class_id`),
  CONSTRAINT `t_exams_ibfk_1` FOREIGN KEY (`student_id`) REFERENCES `t_users` (`id`),
  CONSTRAINT `t_exams_ibfk_2` FOREIGN KEY (`lesson_id`) REFERENCES `t_lessons` (`id`),
  CONSTRAINT `t_exams_ibfk_3` FOREIGN KEY (`class_id`) REFERENCES `t_classes` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `t_exams`
--

LOCK TABLES `t_exams` WRITE;
/*!40000 ALTER TABLE `t_exams` DISABLE KEYS */;
/*!40000 ALTER TABLE `t_exams` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `t_lessons`
--

DROP TABLE IF EXISTS `t_lessons`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `t_lessons` (
  `id` int NOT NULL AUTO_INCREMENT,
  `teacher_user_id` int DEFAULT NULL,
  `lesson_name` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `teacher_user_id` (`teacher_user_id`),
  CONSTRAINT `t_lessons_ibfk_1` FOREIGN KEY (`teacher_user_id`) REFERENCES `t_users` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `t_lessons`
--

LOCK TABLES `t_lessons` WRITE;
/*!40000 ALTER TABLE `t_lessons` DISABLE KEYS */;
/*!40000 ALTER TABLE `t_lessons` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `t_users`
--

DROP TABLE IF EXISTS `t_users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `t_users` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `surname` varchar(255) DEFAULT NULL,
  `username` varchar(255) NOT NULL,
  `password` text NOT NULL,
  `role` varchar(10) NOT NULL,
  `created_at` timestamp NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`),
  CONSTRAINT `t_users_chk_1` CHECK ((`role` in (_utf8mb4'Admin',_utf8mb4'Öğrenci',_utf8mb4'Öğretmen')))
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `t_users`
--

LOCK TABLES `t_users` WRITE;
/*!40000 ALTER TABLE `t_users` DISABLE KEYS */;
INSERT INTO `t_users` VALUES (1,'admin','admin','admin','$argon2id$v=19$m=65536,t=4,p=1$UXB4M1JCL25GbHBET1BNVA$q22UL9KLlj0+LawK8wADriEAmkBRYUwctUd2koxXRiI','Admin','2023-10-11 17:11:32');
/*!40000 ALTER TABLE `t_users` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2023-10-12 19:17:35
