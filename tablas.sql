CREATE TABLE users (
  id BIGSERIAL PRIMARY KEY,
  nombre VARCHAR(255),
  email VARCHAR(255) UNIQUE,
  pass VARCHAR(255),
  numero_tlf VARCHAR(20),
  autenticado BOOLEAN DEFAULT false,
  active BOOLEAN DEFAULT true,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE restaurants (
  id BIGSERIAL PRIMARY KEY,
  user_id BIGINT ,
  nombre VARCHAR(255),
  url_website VARCHAR(255),
  url_google_maps VARCHAR(255),
  direccion VARCHAR(255),
  historia TEXT,
  sobre_comida_ambiente TEXT,
  especialidad VARCHAR(255),
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE monthly_themes (
 id BIGSERIAL PRIMARY KEY,
  restaurant_id INT,
  tema VARCHAR(255),
  mes VARCHAR(50)
);

CREATE TABLE social_networks (
  id BIGSERIAL PRIMARY KEY,
  nombre VARCHAR(255),
  url_api VARCHAR(255),
  logo_red_social VARCHAR(120),
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE social_network_authentications (
  id SERIAL PRIMARY KEY,
  id_usuer BIGINT,
  id_social_network BIGINT ,
  id_user_social_network BIGINT,
  url_image_perfil VARCHAR(125),
 user_name VARCHAR(125),
  token_autenticacion VARCHAR(255),
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE posts (
  id SERIAL PRIMARY KEY,
 restaurant_id BIGINT,
  titulo VARCHAR(255),
  contenido TEXT,
  imagen VARCHAR(255),
  fecha_publicacion TIMESTAMP,
  aprobado BOOLEAN,
  url_publicacion VARCHAR(255),
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE approvals (
  id BIGSERIAL PRIMARY KEY,
  post_id BIGINT,
  codigo_sms VARCHAR(10),
  aprobado BOOLEAN,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE multimedia_posts (
  id SERIAL PRIMARY KEY,
  post_id BIGINT ,
  tipo VARCHAR(50) CHECK (tipo IN ('imagen', 'video')),
  url_archivo VARCHAR(255),
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
