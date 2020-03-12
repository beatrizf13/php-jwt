CREATE TABLE `user` (
    `id` INT NOT NULL AUTO_INCREMENT,
    `username` VARCHAR(60) NOT NULL,
    `password` VARCHAR(96) NOT NULL,
    PRIMARY KEY (`id`)
);

CREATE TABLE `token` (
    `id` INT NOT NULL AUTO_INCREMENT,
    `userId` INT NOT NULL,
    `token` VARCHAR(163) NOT NULL,
    `refreshToken` VARCHAR(140) NOT NULL,
    `createdAt` DATETIME NOT NULL,
    `expiresAt` DATETIME NOT NULL,
    PRIMARY KEY (`id`),
    FOREIGN KEY (`userId`) REFERENCES `user`(`id`)
);