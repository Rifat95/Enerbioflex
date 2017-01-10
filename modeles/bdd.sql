CREATE TABLE Userr(
	id INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
	login VARCHAR(15) NOT NULL UNIQUE,
	mail VARCHAR(100),
	mdp CHAR(40) NOT NULL,
	dateInscription DATE NOT NULL,
	type VARCHAR(6) NOT NULL, -- membre, modo ou admin
	adresseIp VARCHAR(45) NOT NULL
) ENGINE=InnoDB;

CREATE TABLE Diffusion(
	id MEDIUMINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
	titre VARCHAR(100) NOT NULL,
	lien VARCHAR(200) NOT NULL,
	debut DATETIME NOT NULL,
	auteurId INT UNSIGNED,
	FOREIGN KEY(auteurId) REFERENCES Userr(id) ON DELETE SET NULL
) ENGINE=InnoDB;

CREATE TABLE Chat(
	id INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
	message TEXT NOT NULL,
	dateMessage DATETIME NOT NULL,
	auteurId INT UNSIGNED,
	diffusionId MEDIUMINT UNSIGNED NOT NULL,
	FOREIGN KEY(auteurId) REFERENCES Userr(id) ON DELETE SET NULL,
	FOREIGN KEY(diffusionId) REFERENCES Diffusion(id) ON DELETE CASCADE
) ENGINE=InnoDB;

CREATE TABLE Forum(
	id TINYINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
	nom VARCHAR(25) NOT NULL,
	description VARCHAR(100) NOT NULL
) ENGINE=InnoDB;

CREATE TABLE Topic(
	id INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
	nom VARCHAR(70) NOT NULL,
	message TEXT NOT NULL,
	dateCreation DATETIME NOT NULL,
	auteurId INT UNSIGNED,
	forumId TINYINT UNSIGNED NOT NULL,
	FOREIGN KEY(auteurId) REFERENCES Userr(id) ON DELETE SET NULL,
	FOREIGN KEY(forumId) REFERENCES Forum(id) ON DELETE CASCADE
) ENGINE=InnoDB;

CREATE TABLE Post(
	id INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
	contenu TEXT NOT NULL,
	dateCreation DATETIME NOT NULL,
	auteurId INT UNSIGNED,
	topicId INT UNSIGNED NOT NULL,
	FOREIGN KEY(auteurId) REFERENCES Userr(id) ON DELETE SET NULL,
	FOREIGN KEY(topicId) REFERENCES Topic(id) ON DELETE CASCADE
) ENGINE=InnoDB;

CREATE TABLE Discussion(
	id INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
	user1Id INT UNSIGNED NOT NULL,
	user2Id INT UNSIGNED,
	FOREIGN KEY(user1Id) REFERENCES Userr(id) ON DELETE CASCADE,
	FOREIGN KEY(user2Id) REFERENCES Userr(id) ON DELETE SET NULL
) ENGINE=InnoDB;

CREATE TABLE Reception(
	id INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
	contenu TEXT NOT NULL,
	dateEnvoi DATETIME NOT NULL,
	lu BOOLEAN DEFAULT FALSE,
	destinataireId INT UNSIGNED NOT NULL,
	expediteurId INT UNSIGNED,
	discussionId INT UNSIGNED,
	FOREIGN KEY(destinataireId) REFERENCES Userr(id) ON DELETE CASCADE,
	FOREIGN KEY(expediteurId) REFERENCES Userr(id) ON DELETE SET NULL,
	FOREIGN KEY(discussionId) REFERENCES Discussion(id) ON DELETE CASCADE
) ENGINE=InnoDB;

CREATE TABLE Envoi(
	id INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
	contenu TEXT NOT NULL,
	dateEnvoi DATETIME NOT NULL,
	expediteurId INT UNSIGNED NOT NULL,
	destinataireId INT UNSIGNED,
	discussionId INT UNSIGNED,
	FOREIGN KEY(expediteurId) REFERENCES Userr(id) ON DELETE CASCADE,
	FOREIGN KEY(destinataireId) REFERENCES Userr(id) ON DELETE SET NULL,
	FOREIGN KEY(discussionId) REFERENCES Discussion(id) ON DELETE CASCADE
) ENGINE=InnoDB;

DELIMITER $$
CREATE TRIGGER AvantEnvoiMsg BEFORE INSERT
ON Envoi FOR EACH ROW
BEGIN
	IF EXISTS(
		SELECT id
		FROM Discussion
		WHERE user1Id = NEW.expediteurId AND user2Id = NEW.destinataireId
	)
	THEN
		BEGIN
			SET NEW.DiscussionId = (
				SELECT id
				FROM Discussion
				WHERE user1Id = NEW.expediteurId AND user2Id = NEW.destinataireId
			);
		END;
	ELSE
		BEGIN
			INSERT INTO Discussion
			VALUES(NULL, NEW.expediteurId, NEW.destinataireId);

			SET NEW.DiscussionId = (
				SELECT id
				FROM Discussion
				WHERE user1Id = NEW.expediteurId AND user2Id = NEW.destinataireId
			);
		END;
	END IF;

	INSERT INTO Reception
	VALUES(NULL, NEW.contenu, NEW.dateEnvoi, FALSE, NEW.destinataireId, NEW.expediteurId, NULL);
END

DELIMITER $$
CREATE TRIGGER AvantInsertionReception BEFORE INSERT
ON Reception FOR EACH ROW
BEGIN
	IF EXISTS(
		SELECT id
		FROM Discussion
		WHERE user1Id = NEW.destinataireId AND user2Id = NEW.expediteurId
	)
	THEN
		BEGIN
			SET NEW.DiscussionId = (
				SELECT id
				FROM Discussion
				WHERE user1Id = NEW.destinataireId AND user2Id = NEW.expediteurId
			);
		END;
	ELSE
		BEGIN
			INSERT INTO Discussion
			VALUES(NULL, NEW.destinataireId, NEW.expediteurId);

			SET NEW.DiscussionId = (
				SELECT id
				FROM Discussion
				WHERE user1Id = NEW.destinataireId AND user2Id = NEW.expediteurId
			);
		END;
	END IF;
END
