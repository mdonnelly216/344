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
