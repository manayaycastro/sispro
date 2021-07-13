
-- ***************Inicio tabla PROPRODUCCIONSACODET ***************************

create table PROPRODUCCIONSACODET(
prosacodet_id int identity (1,1),
proroll_id int ,

prosacodet_sacoa numeric (15,2) default (0.0), 
prosacodet_sacotel numeric (15,2)default (0.0), 
prosacodet_sacolam numeric (15,2) default (0.0), 
prosacodet_sacoimp numeric (15,2)default (0.0), 
prosacodet_sacoconv numeric (15,2) default (0.0), 

prosacodet_total numeric (15,2)default (0.0), 
prosacodet_totalb numeric (15,2) default (0.0), 


prosacodet_operario int , --CODDIGO SIEMPRESOFT
prosacodet_obs varchar (200),
usuario_creacion varchar (20),
fecha_creacion datetime2 default sysdatetime(),

estado int,
eliminado int,
constraint pk_prosacodet_id primary key clustered (prosacodet_id)

)

alter table PROPRODUCCIONSACODET add default ((0)) for eliminado
alter table PROPRODUCCIONSACODET add default ((0)) for estado


-- ***************fin tabla PROPRODUCCIONSACODET ***************************

alter table PROPRODUCCIONSACODET add prosacodet_sacobast numeric (15,2)
alter table PROPRODUCCIONSACODET  add default ((0.0)) for prosacodet_sacobast

alter table PROPRODUCCIONSACODET add prosacodet_maq int
alter table PROPRODUCCIONSACODET  add default ((0)) for prosacodet_maq