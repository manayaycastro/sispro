-- ***************Inicio tabla PROPROGRAMACION PROCESOS***************************

create table PROPROGRAMACIONPROC(
progpro_id int identity (1,1),
progpro_proceso int ,
progpro_codreferencia int ,
progpro_kanban int,
progpro_fecprogramacion datetime not null,
usuario_creacion varchar (20),
fecha_creacion datetime2 default sysdatetime(),
progpro_atendido int ,
estado int,
eliminado int,
constraint pk_progpro_id primary key clustered (progpro_id)

)
alter table PROPROGRAMACIONPROC add default ((0)) for progpro_atendido
alter table PROPROGRAMACIONPROC add default ((0)) for eliminado
alter table PROPROGRAMACIONPROC add default ((0)) for estado
alter table PROPROGRAMACIONPROC add progpro_siguienteproc int default ((0))
alter table PROPROGRAMACIONPROC add fecha_atencion datetime2
--validar que no se pueda programar con fecha anterior

-- ***************fin tabla PROPROGRAMACION PROCESOS***************************

-- ***************Inicio tabla PROPROGRAMACIONPROCDET PROCESOS***************************

create table PROPROGRAMACIONPROCDET(
progprodet_id int identity (1,1),
progpro_id int ,
progprodet_fecha_ini date ,
progprodet_hora_ini varchar(10),
progprodet_fecha_fin date ,
progprodet_hora_fin varchar(10),
progprodet_atendido int ,
usuario_creacion varchar (20),
fecha_creacion datetime2 default sysdatetime(),

estado int,
eliminado int,
constraint pk_progprodet_id primary key clustered (progprodet_id)

)
ALTER TABLE PROPROGRAMACIONPROCDET add  usuario_modificacion varchar (20)
alter table PROPROGRAMACIONPROCDET add default ((0)) for progprodet_atendido
alter table PROPROGRAMACIONPROCDET add default ((0)) for eliminado
alter table PROPROGRAMACIONPROCDET add default ((0)) for estado
--validar que no se pueda programar con fecha anterior

-- ***************fin tabla PROPROGRAMACIONPROCDET PROCESOS***************************

-- ***************Inicio tabla PROPRODUCCIONROLLO ***************************

create table PROPRODUCCIONROLLO(
proroll_id int identity (1,1),
progprodet_id int ,
proroll_mtrs_total numeric (15,2) default (0.0), 
proroll_peso_total numeric (15,2)default (0.0), 
proroll_atendido int , -- para cerrar la producci�n de los registros parciales
usuario_creacion varchar (20),
fecha_creacion datetime2 default sysdatetime(),

estado int,
eliminado int,
constraint pk_proroll_id primary key clustered (proroll_id)

)
alter table PROPRODUCCIONROLLO add  usuario_atendido varchar (20)
alter table PROPRODUCCIONROLLO add default ((0)) for proroll_atendido
alter table PROPRODUCCIONROLLO add default ((0)) for eliminado
alter table PROPRODUCCIONROLLO add default ((0)) for estado


-- ***************fin tabla PROPRODUCCIONROLLO ***************************
-- ***************Inicio tabla PROPRODUCCIONROLLODET ***************************

create table PROPRODUCCIONROLLODET(
prorolldet_id int identity (1,1),
proroll_id int ,
prorolldet_mtrs numeric (15,2) default (0.0), 
prorolldet_peso numeric (15,2)default (0.0), 
prorolldet_operario int , --CODDIGO SIEMPRESOFT
prorolldet_obs varchar (200),
usuario_creacion varchar (20),
fecha_creacion datetime2 default sysdatetime(),

estado int,
eliminado int,
constraint pk_prorolldet_id primary key clustered (prorolldet_id)

)

alter table PROPRODUCCIONROLLODET add default ((0)) for eliminado
alter table PROPRODUCCIONROLLODET add default ((0)) for estado


-- ***************fin tabla PROPRODUCCIONROLLODET ***************************


-- ***************fin tabla PROPRODUCCIONROLLO ***************************
-- ***************Inicio tabla PRORENDIMIENTOMAQPRODUCTO ***************************

create table PRORENDIMIENTOMAQPRODUCTO(
rendmaqprod_id int identity (1,1),
rendmaqprod_maquina int ,
rendmaqprod_velinic_xmin numeric (15,2) ,
rendmaqprod_tiempuestpunto numeric (15,2)default (0.0), 
rendmaqprod_art int , --CODDIGO SIEMPRESOFT
usuario_creacion varchar (20),
fecha_creacion datetime2 default sysdatetime(),
estado int,
eliminado int,
constraint pk_renprod_id primary key clustered (rendmaqprod_id)

)

alter table PRORENDIMIENTOMAQPRODUCTO add default ((0)) for eliminado
alter table PRORENDIMIENTOMAQPRODUCTO add default ((0)) for estado


-- ***************fin tabla PRORENDIMIENTOMAQPRODUCTO ***************************

 --***************Inicio tabla PROFECHADISPMAQUINA ***************************

create table PROFECHADISPMAQUINA(
fecdispmaq_id int identity (1,1),
fecdispmaq_codmaq int ,
fecdispmaq_fechadisp datetime2 ,
fecha_creacion datetime2 default sysdatetime(),
estado int,

constraint pk_fecdispmaq_id primary key clustered (fecdispmaq_id)
)

alter table PROFECHADISPMAQUINA add default ((0)) for estado


-- ***************fin tabla PROFECHADISPMAQUINA ***************************
 --***************Inicio tabla PROMOVDISPONIBILIDADMAQ ***************************

create table PROMOVDISPONIBILIDADMAQ(
movdismaq_id int identity (1,1),
movdismaq_idmaq int ,
movdismaq_numped int ,
movdismaq_idkanban int ,
movdismaq_mtrs numeric (15,2) ,
movdismaq_fecinicio datetime2 ,
movdismaq_tiempo numeric (15,2)  ,
movdismaq_fecfin datetime2 ,
movdismaq_atendido int ,
movdismaq_estado int ,
fecha_creacion datetime2 default sysdatetime(),


constraint pk_movdismaq_id primary key clustered (movdismaq_id)
)
alter table PROMOVDISPONIBILIDADMAQ add movdismaq_tipoocupacion varchar(50)
alter table PROMOVDISPONIBILIDADMAQ add movdismaq_proceso int
alter table PROMOVDISPONIBILIDADMAQ add movdismaq_maqid int
alter table PROMOVDISPONIBILIDADMAQ add default ((0)) for movdismaq_atendido
alter table PROMOVDISPONIBILIDADMAQ add default ((0)) for movdismaq_estado

-- ***************fin tabla PROMOVDISPONIBILIDADMAQ ***************************
alter table PROARTSEMIMAQUINA add artsemimaq_velinicial numeric (15,2)
alter table PROARTSEMIMAQUINA add artsemimaq_puestapunto numeric(15,2)
alter table PROARTSEMIMAQUINA  add default ((0.0)) for artsemimaq_velinicial
alter table PROARTSEMIMAQUINA add default ((0.0)) for artsemimaq_puestapunto



-- ************** INICIO TABLA RUTA ARTICULO***************************


 /*
 delete from PROMOVDISPONIBILIDADMAQ
 delete from PROFECHADISPMAQUINA
 update PROPROGKANBANDET set prokandet_telar = '0'

delete PROPRODUCCIONROLLODET
 delete from PROPRODUCCIONROLLO
 DELETE FROM PROPROGRAMACIONPROCDET
 DELETE FROM PROPROGRAMACIONPROC

 */







 select tabla03.*,tabla04.progpro_id, tabla04.progpro_kanban,tabla04.progpro_atendido,tabla04.progpro_siguienteproc
 from ( 
	select tabla1.*,tabla02.tabgendet_nombre as proceso_tabgen
	from
		 (
		 select VAL.valitemcarac_id, VAL.artsemi_id, VAL.itemcaracsemi_id, VAL.valitemcarac_valor,CARACSEMI.itemcaracsemi_descripcion,clasi.clasem_id,
		 clasi.clasem_titulo , semi.form_id
		 from PROVALITEMSCARACT VAL
		 INNER JOIN PROITEMCARACTSEMITERMINADO CARACSEMI ON CARACSEMI.itemcaracsemi_id = VAL.itemcaracsemi_id
		 inner join PROCLASIFSEMITERMINADO clasi on clasi.clasem_id = CARACSEMI.clasem_id
		 inner join PROARTSEMITERMINADO semi on semi.artsemi_id= VAL.artsemi_id
		 where clasi.clasem_id = '14'  and semi.form_id ='4775' --and VAL.valitemcarac_valor != '-1'
		 )tabla1 --caracteristicas y valores del producto en cuento a la rura
	inner join 
		 ( select tabgendet_id, tabgendet_nombre 
		 from PROTABLAGENDET
		 where tabgen_id= '19'
		 ) tabla02 on tabla02.tabgendet_id = tabla1.valitemcarac_valor 
    )tabla03
	 left  join
 (select * from PROPROGRAMACIONPROC where eliminado = '0' and estado ='0' and  progpro_kanban = '29') tabla04
 on tabla04.progpro_proceso = cast (tabla03.valitemcarac_valor as int ) order by tabla03.valitemcarac_valor
-- ************** FIN TABLA RUTA ARTICULO ***************************
select kandet.* ,ved.cantped, ved.codart,ved.desart,vec.codcli,vec.razonsocial,kan.prokan_cantkanban
,propro.progpro_id, CAST ( propro.progpro_fecprogramacion AS DATE) progpro_fecprogramacion, propro.progpro_atendido, propro.progpro_proceso
,propro.progpro_siguienteproc,propro.fecha_atencion
,roll.proroll_mtrs_total, roll.proroll_peso_total, roll.proroll_atendido
from PROPROGKANBANDET kandet
INNER JOIN PROPROGKANBAN kan on kan.prokan_nroped = kandet.prokandet_nroped
inner join [192.168.10.242].[ELAGUILA].[DBO].vepedidod ved on ved.nroped = kandet.prokandet_nroped
inner join  [192.168.10.242].[ELAGUILA].[DBO].vepedidoc vec on vec.nroped = kandet.prokandet_nroped
inner join PROPROGRAMACIONPROC propro on propro.progpro_kanban= kandet.prokandet_id
inner join PROPROGRAMACIONPROCDET proprodet on proprodet.progpro_id= propro.progpro_id
inner join PROPRODUCCIONROLLO roll on roll.progprodet_id= proprodet.progprodet_id

where kandet.estado = '0' and kandet.eliminado = '0' and propro.progpro_atendido= '1' and propro.progpro_siguienteproc = '168' and-- AND progra.movdismaq_tipoocupacion = 'Programacion' and
 ( CAST(propro.fecha_atencion AS DATE) >= '2020-09-01' AND CAST( propro.fecha_atencion AS DATE)<='2020-09-04') and roll.proroll_atendido ='1'