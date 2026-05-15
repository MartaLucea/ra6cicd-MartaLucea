CREATE TABLE IF NOT EXISTS tasques (
  id   INT AUTO_INCREMENT PRIMARY KEY,
  text VARCHAR(255) NOT NULL,
  done TINYINT(1) DEFAULT 0
);

INSERT INTO tasques (text, done) VALUES
  ('Crear el repositori a GitHub i obrir el Codespace', 1),
  ('Configurar GitHub Pages i desplegar la versió estàtica', 0),
  ('Configurar Docker Compose amb el contenidor web i la base de dades', 0),
  ('Verificar l entorn de desenvolupament al Codespace', 0);