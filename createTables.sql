CREATE DATABASE IF NOT EXISTS mechmaker;

-- Switch to the newly created database
USE mechmaker;

-- Loadout table
CREATE TABLE IF NOT EXISTS loadout (
    id INT AUTO_INCREMENT PRIMARY KEY,
    mech_id INT,
    name VARCHAR(100) NOT NULL,
    FOREIGN KEY (mech_id) REFERENCES mech(mech_id)
);

-- Mech table
CREATE TABLE IF NOT EXISTS mech (
    mech_id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    armor INT NOT NULL,
    speed INT NOT NULL,
    image VARCHAR(255),
    no_weapons INT NOT NULL,
   
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

-- Junction table linking mechs to weapons
CREATE TABLE IF NOT EXISTS MechWeapons (
    loadout_id INT,
    weapon_id INT,
    PRIMARY KEY (loadout_id, weapon_id),
    FOREIGN KEY (loadout_id) REFERENCES loadout(loadout_id),
    FOREIGN KEY (weapon_id) REFERENCES weapon(weapon_id)
);
