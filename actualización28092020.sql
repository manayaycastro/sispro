
-- ***************Inicio tabla PROPRENSAFILAS ***************************

create table PROPRENSAFILAS(
prefila_id int identity (1,1),
proroll_id int ,

prefila_op int,
prefila_kanban int, 
prefila_cantidad_ini int,
prefila_cantidad_fin int,
prefila_peso numeric (15,2)default (0.0), 

prefila_tipo varchar (50),-- para identificar  agrupar si es pucho de A o pucho de B
prefila_kanbas varchar (80), --para kanbas agrupados (en sacos a y sacos b)

usuario_creacion varchar (20),
fecha_creacion datetime2 default sysdatetime(),

usuario_modif varchar (20), -- usuaario que registra el peso
fecha_modif datetime2 default sysdatetime(),

estado int DEFAULT (0), -- 1 consumido, 
eliminado int DEFAULT (0),
constraint pk_prefila_id primary key clustered (prefila_id),
--CONSTRAINT pk_prefila_proroll_id FOREIGN KEY  (proroll_id) REFERENCES PROPRODUCCIONROLLO (proroll_id) SE ELIMINO

)
ALTER TABLE PROPRENSAFILAS ADD prefila_tamanio varchar (50)
ALTER TABLE PROPRENSAFILAS ALTER COLUMN prefila_kanban VARCHAR(50); --se cambio para poder ingresar manualmente los kanban agrupados

alter table PROPRENSAFILAS add atendido varchar (1) -- se inerto para poder dar como atendido el enfardelado
alter table PROPRENSAFILAS add default ((0)) for atendido --se inserto el valor por default 0

-- estado de la tabla kanban sirve para cerrar la OP

-- ***************fin tabla PROPRENSAFILAS ***************************

--18-10-2020 hacia arriba ok!

ALTER TABLE PROPROGKANBAN  ADD  prokan_kanb_manual integer default ((0))  -- (ok)
ALTER TABLE PROPROGKANBANDET  ADD  prokandet_manual integer default ((0))  -- 0 -> sistema 1-> Manual



create table PROTRANSKANBAN( -- (OK)
transkanb_id int identity (1,1),
transkanb_op_origen int ,
transkanb_kanb_origen int,
transkanb_op_destino int,
usuario_creacion varchar (20),
fecha_creacion datetime2 default sysdatetime(),
estado int DEFAULT (0), 
eliminado int DEFAULT (0),

constraint pk_transkanb_id primary key clustered (transkanb_id),
)



alter table PROPROGKANBAN add prokan_mtrs_totalparche  numeric (15,2) default (0.0)  --OK

alter table PROPROGKANBAN add prokan_cantkanbanparche  int default 0 --OK

ALTER TABLE PROPROGKANBANDET ADD prokandet_tipo varchar (40) --ok

alter table PROPROGKANBANDET add artsemi_id int -- ok


create table PROPRODUCCIONROLLPARCH( --ok
prorollparch_id int identity (1,1),
proroll_id int ,-- llave foranea

prorollparch_a int , 
prorollparch_b int , 
prorollparch_mtrscort numeric (15,2) default (0.0), 


prorollparch_mtrstotal numeric (15,2)default (0.0), 
prorollparch_mtrstotalb numeric (15,2) default (0.0), 


prorollparch_operario int , --CODDIGO SIEMPRESOFT
prorollparch_obs varchar (200),
usuario_creacion varchar (20),
fecha_creacion datetime2 default sysdatetime(),

estado int,
eliminado int,
constraint pk_prorollparch primary key clustered (prorollparch_id)

)

alter table PROPRODUCCIONROLLPARCH add default (0) for eliminado --ok
alter table PROPRODUCCIONROLLPARCH add default (0) for estado -- ok

CAMBIAR ID DE LA MAQUINA CONVERTIDORA  A 155, LINEA DE COD 1017  Y LINEA DE CODIGO 1053
