-- Désactiver les vérifications de clés étrangères pour éviter les erreurs d'ordre
SET FOREIGN_KEY_CHECKS = 0;

-- Vider les tables avec DELETE pour éviter les erreurs de contraintes de clé étrangère (TRUNCATE ne fonctionne pas toujours avec les FK)
DELETE FROM tournoi_participant;
ALTER TABLE tournoi_participant AUTO_INCREMENT = 1;

DELETE FROM tournoi;
ALTER TABLE tournoi AUTO_INCREMENT = 1;

DELETE FROM jeu_video;
ALTER TABLE jeu_video AUTO_INCREMENT = 1;

DELETE FROM participant;
ALTER TABLE participant AUTO_INCREMENT = 1;

DELETE FROM cat_tournoi;
ALTER TABLE cat_tournoi AUTO_INCREMENT = 1;

DELETE FROM plateformes;
ALTER TABLE plateformes AUTO_INCREMENT = 1;

DELETE FROM marque;
ALTER TABLE marque AUTO_INCREMENT = 1;

DELETE FROM genre;
ALTER TABLE genre AUTO_INCREMENT = 1;

DELETE FROM pegi;
ALTER TABLE pegi AUTO_INCREMENT = 1;

DELETE FROM membre;
ALTER TABLE membre AUTO_INCREMENT = 1;

-- 1. Table PEGI
INSERT INTO pegi (age_limite, desc_pegi) VALUES
(3, 'Convient à toutes les classes d\'âge.'),
(7, 'Déconseillé aux moins de 7 ans.'),
(12, 'Déconseillé aux moins de 12 ans.'),
(16, 'Déconseillé aux moins de 16 ans.'),
(18, 'Réservé aux adultes.');

-- 2. Table Genre
INSERT INTO genre (lib_genre) VALUES
('Action'),
('Aventure'),
('RPG'),
('Course'),
('Sport'),
('FPS'),
('Stratégie'),
('Simulation');

-- 3. Table Marque
INSERT INTO marque (nom_marque) VALUES
('Nintendo'),
('Sony'),
('Microsoft'),
('Ubisoft'),
('Electronic Arts'),
('Capcom'),
('Square Enix');

-- 4. Table Plateformes
INSERT INTO plateformes (lib_plateforme) VALUES
('PC'),
('PlayStation 5'),
('Xbox Series X'),
('Nintendo Switch'),
('PlayStation 4');

-- 5. Table CatTournoi
-- Note: Le champ s'appelle 'nom' dans l'entité CatTournoi
INSERT INTO cat_tournoi (nom) VALUES
('Tournoi Local'),
('Championnat National'),
('Amical'),
('E-Sport Pro'),
('Caritatif');

-- 6. Table JeuVideo
-- Supposons les IDs suivants générés ci-dessus :
-- Genre: 1=Action, 2=Aventure, 3=RPG, 4=Course, 5=Sport
-- Pegi: 1=3, 2=7, 3=12, 4=16, 5=18
-- Plateforme: 1=PC, 2=PS5, 3=Xbox, 4=Switch
-- Marque: 1=Nintendo, 2=Sony, 3=Microsoft, 4=Ubisoft, 5=EA

INSERT INTO jeu_video (ref_jeu, nom, prix, date_parution, genre_id, pegi_id, plateforme_id, marque_id) VALUES
('MK8DX', 'Mario Kart 8 Deluxe', 49.99, '2017-04-28', 4, 1, 4, 1),
('FIFA24', 'EA Sports FC 24', 59.99, '2023-09-29', 5, 1, 2, 5),
('ZELDA_TOTK', 'The Legend of Zelda: Tears of the Kingdom', 69.99, '2023-05-12', 2, 3, 4, 1),
('COD_MW3', 'Call of Duty: Modern Warfare III', 79.99, '2023-11-10', 6, 5, 2, 5),
('AC_MIRAGE', 'Assassin\'s Creed Mirage', 49.99, '2023-10-05', 2, 4, 3, 4),
('FF16', 'Final Fantasy XVI', 69.99, '2023-06-22', 3, 4, 2, 7),
('SF6', 'Street Fighter 6', 59.99, '2023-06-02', 1, 3, 1, 6);

-- 7. Table Participant
INSERT INTO participant (prenom, nom, telephone, email) VALUES
('Jean', 'Dupont', '0601020304', 'jean.dupont@email.com'),
('Marie', 'Curie', '0605060708', 'marie.curie@email.com'),
('Pierre', 'Martin', '0611121314', 'pierre.martin@email.com'),
('Sophie', 'Durand', '0615161718', 'sophie.durand@email.com'),
('Lucas', 'Bernard', '0621222324', 'lucas.bernard@email.com'),
('Emma', 'Petit', '0625262728', 'emma.petit@email.com'),
('Thomas', 'Robert', '0631323334', 'thomas.robert@email.com'),
('Lea', 'Richard', '0635363738', 'lea.richard@email.com');

-- 8. Table Tournoi
-- CatTournoi: 1=Local, 2=National, 3=Amical
-- Plateforme: 1=PC, 2=PS5, 4=Switch
INSERT INTO tournoi (nom, date_debut, date_fin, nb_participants, description, plateforme_id, cat_tournoi_id) VALUES
('Tournoi Mario Kart 2025', '2025-01-15 14:00:00', '2025-01-15 18:00:00', 32, 'Grand tournoi de rentrée sur Mario Kart 8 Deluxe.', 4, 1),
('Championnat FIFA 25', '2025-02-10 10:00:00', '2025-02-12 20:00:00', 64, 'Championnat régional qualificatif.', 2, 2),
('Soirée Street Fighter', '2025-03-05 19:00:00', '2025-03-05 23:00:00', 16, 'Tournoi amical pour le fun.', 1, 3),
('Marathon Zelda', '2025-04-01 08:00:00', '2025-04-03 08:00:00', 10, 'Speedrun caritatif sur TOTK.', 4, 5),
('League of Legends Open', '2025-05-20 09:00:00', '2025-05-21 22:00:00', 100, 'Tournoi ouvert à tous les rangs.', 1, 4);

-- 9. Table Tournoi_Participant (Liaison)
-- Lier des participants aux tournois
-- Tournoi 1 (Mario Kart)
INSERT INTO tournoi_participant (tournoi_id, participant_id) VALUES
(1, 1), (1, 2), (1, 3), (1, 4),
(2, 5), (2, 6), (2, 7), (2, 8),
(3, 1), (3, 5),
(5, 2), (5, 4), (5, 6), (5, 8);

-- 10. Table Membre (Utilisateurs)
-- Mot de passe 'password' hashé (exemple bcrypt, à adapter selon votre configuration security.yaml)
-- Pour cet exemple, on insère un admin générique.
-- Le mot de passe doit être valide pour votre encodeur.
-- Ici on met une valeur placeholder, il faudra peut-être créer l'user via la commande symfony console si le hash ne matche pas.
INSERT INTO membre (username, roles, password, nom_membre, prenom_membre, tel_membre, mail_membre, rue_membre, cp_membre, ville_membre) VALUES
('admin', '["ROLE_ADMIN"]', '$2y$13$GTkbHXwE.MFTg8Mr5TJc8gSGQFNp70wv9jHcubeLoAVvVMfT', 'Admin', 'System', '0123456789', 'admin@agora.fr', '1 rue de l\'Admin', '75000', 'Paris'),
('user', '["ROLE_USER"]', '$2y$13$fNrTG.WM85ZruJruZPoKkf9SUjGEiJpl5EhBE1PnoWRz7nfP', 'User', 'Lambda', '0987654321', 'user@agora.fr', '2 rue du User', '69000', 'Lyon');

SET FOREIGN_KEY_CHECKS = 1;
