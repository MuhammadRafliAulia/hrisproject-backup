usersusersusersCREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) UNIQUE,
    password VARCHAR(255)
);

CREATE TABLE projects (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100),
    status VARCHAR(50),
    deadline DATE
);

CREATE TABLE employees (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nik VARCHAR(20) UNIQUE,
    nama VARCHAR(100),
    gol VARCHAR(10),
    dept VARCHAR(50),
    jabatan VARCHAR(50),
    seksi VARCHAR(50),
    status_kerja VARCHAR(20),
    tmp_lahir VARCHAR(50),
    tgl_lahir DATE,
    gol_darah VARCHAR(5),
    alamat TEXT
);

-- Tambah user awal
INSERT INTO users (username, password) VALUES ('rafli', 'raflirafli12');
