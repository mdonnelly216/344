CREATE DATABASE IF NOT EXISTS mechmaker;


USE mechmaker;



-- Mech table
CREATE TABLE IF NOT EXISTS mech (
    mech_id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    armor INT NOT NULL,
    speed INT NOT NULL,
    image VARCHAR(255),
    no_weapons INT NOT NULL,
   
);

ALTER TABLE mech
ADD COLUMN tonnage INT NOT NULL AFTER no_weapons,
ADD COLUMN internal INT NOT NULL AFTER tonnage;

-- Loadout table
CREATE TABLE IF NOT EXISTS loadout (
    loadout_id INT AUTO_INCREMENT PRIMARY KEY,
    mech_id INT,
    name VARCHAR(100) NOT NULL,
    FOREIGN KEY (mech_id) REFERENCES mech(mech_id)
);



-- Weapon table
CREATE TABLE IF NOT EXISTS weapon (
    weapon_id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    type VARCHAR(50) NOT NULL,
    short_damage INT NOT NULL, -- based on range
    medium_damage INT NOT NULL,
    long_damage INT NOT NULL,
  
);

-- Junction table linking loadout to weapons
CREATE TABLE IF NOT EXISTS WeaponsLoadout (
    loadout_id INT,
    weapon_id INT,
    PRIMARY KEY (loadout_id, weapon_id),
    FOREIGN KEY (loadout_id) REFERENCES loadout(loadout_id),
    FOREIGN KEY (weapon_id) REFERENCES weapon(weapon_id)
);


INSERT INTO weapon (name, type, short_damage, medium_damage, long_damage) VALUES
-- Missile
('LRM 20', 'Missile', 2, 9, 9),
('LRM 15', 'Missile', 2, 6, 6),
('LRM 10', 'Missile', 1, 4, 4),
('LRM 5',  'Missile', 1, 2, 2),
('MRM 40', 'Missile', 11, 8, 0),
('MRM 30', 'Missile', 8, 5, 0),
('MRM 20', 'Missile', 6, 3, 0),
('MRM 10', 'Missile', 5, 2, 0),
('SRM 6',  'Missile', 5, 1, 0),
('SRM 4',  'Missile', 4, 1, 0),
('SRM 2',  'Missile', 2, 0, 0),
('Streak-SRM 6', 'Missile', 5, 1, 0),
('Streak-SRM 4', 'Missile', 4, 1, 0),
('Streak-SRM 2', 'Missile', 2, 0, 0),
('NARC', 'Missile', 0, 0, 0),

-- Ballistic
('AC 20', 'Ballistic', 12, 4, 0),
('AC 10', 'Ballistic', 6, 6, 1),
('AC 5',  'Ballistic', 3, 3, 3),
('AC 2',  'Ballistic', 2, 2, 1),
('Ultra AC 20', 'Ballistic', 12, 4, 0),
('Ultra AC 10', 'Ballistic', 6, 6, 1),
('Ultra AC 5',  'Ballistic', 3, 3, 3),
('Ultra AC 2',  'Ballistic', 2, 2, 1),
('LB 20-X AC', 'Ballistic', 13, 2, 0),
('LB 10-X AC', 'Ballistic', 7, 3, 0),
('LB 5-X AC',  'Ballistic', 4, 3, 1),
('LB 2-X AC',  'Ballistic', 2, 1, 1),
('Gauss Rifle', 'Ballistic', 8, 8, 8),
('Heavy Gauss Rifle', 'Ballistic', 16, 6, 1),
('RAC 5', 'Ballistic', 5, 5, 3),
('RAC 2', 'Ballistic', 2, 2, 2),
('Machine Gun', 'Ballistic', 1, 0, 0),

-- Energy
('Large Laser', 'Energy', 4, 4, 1),
('Medium Laser', 'Energy', 3, 2, 0),
('Small Laser', 'Energy', 2, 0, 0),
('Large Pulse Laser', 'Energy', 5, 3, 0),
('Medium Pulse Laser', 'Energy', 3, 1, 0),
('Small Pulse Laser', 'Energy', 2, 0, 0),
('PPC', 'Energy', 1, 6, 4),
('ER PPC', 'Energy', 6, 6, 6),
('Light PPC', 'Energy', 0, 3, 3),
('Snub-PPC', 'Energy', 6, 1, 0),
('Heavy PPC', 'Energy', 8, 3, 0),
('TAG', 'Energy', 0, 0, 0),
('Flamer', 'Energy', 1, 0, 0);

INSERT INTO weapon (name, type, short_damage, medium_damage, long_damage) VALUES
-- Clan Missiles
('Clan LRM 20', 'Missile', 2, 9, 9),
('Clan LRM 15', 'Missile', 2, 6, 6),
('Clan LRM 10', 'Missile', 1, 4, 4),
('Clan LRM 5',  'Missile', 1, 2, 2),
('Clan ATM 12', 'Missile', 6, 5, 4),
('Clan ATM 9',  'Missile', 5, 4, 3),
('Clan ATM 6',  'Missile', 4, 3, 2),
('Clan ATM 3',  'Missile', 3, 2, 1),
('Clan SRM 6',  'Missile', 5, 1, 0),
('Clan SRM 4',  'Missile', 4, 1, 0),
('Clan SRM 2',  'Missile', 2, 0, 0),
('Clan Streak-SRM 6', 'Missile', 5, 1, 0),
('Clan Streak-SRM 4', 'Missile', 4, 1, 0),
('Clan Streak-SRM 2', 'Missile', 2, 0, 0),
('Clan NARC', 'Missile', 0, 0, 0),

-- Clan Ballistics
('Clan Ultra AC 20', 'Ballistic', 12, 4, 0),
('Clan Ultra AC 10', 'Ballistic', 6, 6, 1),
('Clan Ultra AC 5',  'Ballistic', 3, 3, 3),
('Clan Ultra AC 2',  'Ballistic', 2, 2, 2),
('Clan LB 20-X AC', 'Ballistic', 11, 2, 0),
('Clan LB 10-X AC', 'Ballistic', 6, 3, 0),
('Clan LB 5-X AC',  'Ballistic', 4, 3, 1),
('Clan LB 2-X AC',  'Ballistic', 2, 1, 1),
('Clan Gauss Rifle', 'Ballistic', 8, 8, 8),
('HAG/20', 'Ballistic', 1, 4, 4),
('HAG/30', 'Ballistic', 1, 5, 5),
('HAG/40', 'Ballistic', 1, 6, 6),
('Clan Machine Guns (2)', 'Ballistic', 2, 0, 0),

-- Clan Energy
('Clan ER Large Laser', 'Energy', 4, 4, 2),
('Clan ER Medium Laser', 'Energy', 3, 3, 1),
('Clan ER Small Laser', 'Energy', 2, 2, 0),
('Clan Large Pulse Laser', 'Energy', 6, 3, 2),
('Clan Medium Pulse Laser', 'Energy', 4, 2, 2),
('Clan Small Pulse Laser', 'Energy', 2, 2, 0),
('Clan ER PPC', 'Energy', 8, 8, 8),
('Clan TAG', 'Energy', 0, 0, 0),
('Clan Flamer', 'Energy', 1, 0, 0);

