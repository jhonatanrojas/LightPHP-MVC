CREATE TABLE IF NOT EXISTS public.email_masivos
(
    id bigserial ,
    id_version_base bigint  DEFAULT 0,
    id_pais bigint  DEFAULT 0,
     pagina bigint  DEFAULT 0,
    nombre text COLLATE pg_catalog."default" NOT NULL DEFAULT ''::text,
    fecha_envio date NOT NULL DEFAULT now(),

 total_envios bigint  DEFAULT 0,
    asunto text COLLATE pg_catalog."default" NOT NULL DEFAULT ''::text,
    plantilla text COLLATE pg_catalog."default" NOT NULL DEFAULT ''::text,

    template_file text COLLATE pg_catalog."default" NOT NULL DEFAULT ''::text,
 fecha_creacion  timestamp without time zone NOT NULL DEFAULT now(),
 estado bigint DEFAULT 0, 
  programados  boolean DEFAULT 'false', 
 activa  boolean DEFAULT 'false',
 CONSTRAINT pk_email_masivos PRIMARY KEY (id)
)

CREATE TABLE IF NOT EXISTS public.estado_envios_email
(
    id  integer ,
    estado text COLLATE pg_catalog."default" NOT NULL DEFAULT ''::text,


 CONSTRAINT pk_estado_envios_email PRIMARY KEY (id)
);
CREATE TABLE IF NOT EXISTS public.email_masivos_clientes
(
    id bigserial ,
    id_campana bigint NOT NULL DEFAULT 0,
    id_cliente bigint NOT NULL DEFAULT 0,
    estatus_envio boolean NOT NULL DEFAULT false,
 fecha_envio date DEFAULT NULL,
    CONSTRAINT pk_email_masivos_clientes PRIMARY KEY (id)
)

INSERT INTO estado_envios_email  VALUES(0,'Eliminado');
INSERT INTO estado_envios_email  VALUES(1,'Borrador');
INSERT INTO estado_envios_email  VALUES(2,'Progarando para envio');
INSERT INTO estado_envios_email  VALUES(3,'Enviados');
INSERT INTO estado_envios_email  VALUES(4,'Pausado');


ALTER TABLE clientes ADD COLUMN suscripcion_mail BOOLEAN DEFAULT 'true';



CREATE TABLE IF NOT EXISTS usuarios
(
    id bigserial ,
   correo text COLLATE pg_catalog."default" NOT NULL DEFAULT ''::text,
    clave text COLLATE pg_catalog."default" NOT NULL DEFAULT ''::text,
    contenido text COLLATE pg_catalog."default" NOT NULL DEFAULT ''::text,
    activo boolean NOT NULL DEFAULT false,

    CONSTRAINT pk_usuarios PRIMARY KEY (id)
)
INSERT INTO usuarios  VALUES(1,'jose@practisis.com','prometeo123','true');
CREATE TABLE IF NOT EXISTS envios_email
(
    id bigserial ,
   correo text COLLATE pg_catalog."default" NOT NULL DEFAULT ''::text,
    asunto text COLLATE pg_catalog."default" NOT NULL DEFAULT ''::text,
    contenido text COLLATE pg_catalog."default" NOT NULL DEFAULT ''::text,
    estatus_envio boolean NOT NULL DEFAULT false,
 fecha_envio date DEFAULT NULL,
    CONSTRAINT pk_email__clientes PRIMARY KEY (id)
)



CREATE TABLE IF NOT EXISTS plantillas_notificaciones
(
    id bigserial ,
    id_version bigint default 0,
    id_pais bigint default 0,
    bases text default '',

    titulo text COLLATE pg_catalog."default" NOT NULL DEFAULT ''::text,
    cuerpo text COLLATE pg_catalog."default" NOT NULL DEFAULT ''::text,
    leido boolean NOT NULL DEFAULT false,
    creado TIMESTAMP DEFAULT now(),
    actualizado TIMESTAMP DEFAULT null,
    CONSTRAINT pk_plantilla_notificaciones PRIMARY KEY (id)
)

ALTER TABLE plantillas_notificaciones ADD column  notificacion_fe boolean default false;
 ALTER TABLE plantillas_notificaciones ADD column     id_factura bigint default 0;




CREATE TABLE IF NOT EXISTS notificaciones
(
    id bigserial ,
    titulo text COLLATE pg_catalog."default" NOT NULL DEFAULT ''::text,
    cuerpo text COLLATE pg_catalog."default" NOT NULL DEFAULT ''::text,
    notificacion_fe boolean default false,
    leido boolean NOT NULL DEFAULT false,
    creado TIMESTAMP DEFAULT now(),
    actualizado TIMESTAMP DEFAULT null,
    CONSTRAINT pk_p_notificaciones PRIMARY KEY (id)
)

CREATE TABLE IF NOT EXISTS empresas_notificaciones
(
    id bigserial ,
    es_factura boolean default false,
    id_factura bigint default 0,
    id_empresa bigint default 0,
    id_notificacion bigint default 0,
     enviado boolean NOT NULL DEFAULT false,
    creado TIMESTAMP DEFAULT now(),
    actualizado TIMESTAMP DEFAULT null,
    CONSTRAINT pk_empresas_notificaciones PRIMARY KEY (id)
)