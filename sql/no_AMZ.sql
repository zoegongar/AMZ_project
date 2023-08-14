/*crear tabla socias*/
create table Socias (
id_usuaria int(4) primary key not null,
id_socia int(4) unique not null,
id_tipo_socia int(1) not null,
nombre varchar(30) not null,
apellido_1 varchar(30) not null,
apellido_2 varchar(30) not null,
dni varchar(7) unique not null,
telefono int(9) not null
);
/*crear tabla permanencia */
create table Permanencia (
id_permanencia int(3) primary key,
dia_semana int(1) constraint chk_dia check (dia_semana <= 7 or dia_semana >=1), 
hora_comienzo time not null,
hora_fin  time not null,
fecha_comienzo date default sysdate not null,
fecha_fin date,
num_socia constraint num_socia_fk references socias(num_socia) not null
);

SHOW DATABASES;