BEGIN TRANSACTION;
CREATE TABLE system_group (
    id int PRIMARY KEY NOT NULL,
    name varchar(256)
);
INSERT INTO system_group VALUES(1,'Template - Admin');
INSERT INTO system_group VALUES(2,'Template - Users');
INSERT INTO system_group VALUES(3,'Pessoa');
INSERT INTO system_group VALUES(4,'Serviços');
INSERT INTO system_group VALUES(5,'Contratos');
INSERT INTO system_group VALUES(6,'Faturas');
INSERT INTO system_group VALUES(7,'Financeiro');
INSERT INTO system_group VALUES(8,'Ferramentas');
CREATE TABLE system_program (
    id int PRIMARY KEY NOT NULL,
    name varchar(256),
    controller varchar(256)
);
INSERT INTO system_program VALUES(1,'System Administration Dashboard','SystemAdministrationDashboard');
INSERT INTO system_program VALUES(2,'System Program Form','SystemProgramForm');
INSERT INTO system_program VALUES(3,'System Program List','SystemProgramList');
INSERT INTO system_program VALUES(4,'System Group Form','SystemGroupForm');
INSERT INTO system_program VALUES(5,'System Group List','SystemGroupList');
INSERT INTO system_program VALUES(6,'System Unit Form','SystemUnitForm');
INSERT INTO system_program VALUES(7,'System Unit List','SystemUnitList');
INSERT INTO system_program VALUES(8,'System Role Form','SystemRoleForm');
INSERT INTO system_program VALUES(9,'System Role List','SystemRoleList');
INSERT INTO system_program VALUES(10,'System User Form','SystemUserForm');
INSERT INTO system_program VALUES(11,'System User List','SystemUserList');
INSERT INTO system_program VALUES(12,'System Preference form','SystemPreferenceForm');
INSERT INTO system_program VALUES(13,'System Log Dashboard','SystemLogDashboard');
INSERT INTO system_program VALUES(14,'System Access Log','SystemAccessLogList');
INSERT INTO system_program VALUES(15,'System ChangeLog View','SystemChangeLogView');
INSERT INTO system_program VALUES(16,'System Sql Log','SystemSqlLogList');
INSERT INTO system_program VALUES(17,'System Request Log','SystemRequestLogList');
INSERT INTO system_program VALUES(18,'System Request Log View','SystemRequestLogView');
INSERT INTO system_program VALUES(19,'System PHP Error','SystemPHPErrorLogView');
INSERT INTO system_program VALUES(20,'System Session vars','SystemSessionVarsView');
INSERT INTO system_program VALUES(21,'System Database Browser','SystemDatabaseExplorer');
INSERT INTO system_program VALUES(22,'System Table List','SystemTableList');
INSERT INTO system_program VALUES(23,'System Data Browser','SystemDataBrowser');
INSERT INTO system_program VALUES(24,'System SQL Panel','SystemSQLPanel');
INSERT INTO system_program VALUES(25,'System Modules','SystemModulesCheckView');
INSERT INTO system_program VALUES(26,'System files diff','SystemFilesDiff');
INSERT INTO system_program VALUES(27,'System Information','SystemInformationView');
INSERT INTO system_program VALUES(28,'System PHP Info','SystemPHPInfoView');
INSERT INTO system_program VALUES(29,'Common Page','CommonPage');
INSERT INTO system_program VALUES(30,'Welcome View','WelcomeView');
INSERT INTO system_program VALUES(31,'Welcome dashboard','WelcomeDashboardView');
INSERT INTO system_program VALUES(32,'System Profile View','SystemProfileView');
INSERT INTO system_program VALUES(33,'System Profile Form','SystemProfileForm');
INSERT INTO system_program VALUES(34,'System Notification List','SystemNotificationList');
INSERT INTO system_program VALUES(35,'System Notification Form View','SystemNotificationFormView');
INSERT INTO system_program VALUES(36,'System Support form','SystemSupportForm');
INSERT INTO system_program VALUES(37,'System Profile 2FA Form','SystemProfile2FAForm');
INSERT INTO system_program VALUES(38,'Estado Form','EstadoForm');
INSERT INTO system_program VALUES(39,'Estado List','EstadoList');
INSERT INTO system_program VALUES(40,'Cidade Form','CidadeForm');
INSERT INTO system_program VALUES(41,'Cidade List','CidadeList');
INSERT INTO system_program VALUES(42,'Grupo Form','GrupoForm');
INSERT INTO system_program VALUES(43,'Grupo List','GrupoList');
INSERT INTO system_program VALUES(44,'Papel Form','PapelForm');
INSERT INTO system_program VALUES(45,'Papel List','PapelList');
INSERT INTO system_program VALUES(46,'Pessoa Form','PessoaForm');
INSERT INTO system_program VALUES(47,'Pessoa List','PessoaList');
INSERT INTO system_program VALUES(48,'Pessoa Form View','PessoaFormView');
INSERT INTO system_program VALUES(49,'Tipo Servico Form','TipoServicoForm');
INSERT INTO system_program VALUES(50,'Tipo Servico List','TipoServicoList');
INSERT INTO system_program VALUES(51,'Servico Form','ServicoForm');
INSERT INTO system_program VALUES(52,'Servico List','ServicoList');
INSERT INTO system_program VALUES(53,'Tipo Contrato Form','TipoContratoForm');
INSERT INTO system_program VALUES(54,'Tipo Contrato List','TipoContratoList');
INSERT INTO system_program VALUES(55,'Contrato Form','ContratoForm');
INSERT INTO system_program VALUES(56,'Contrato List','ContratoList');
INSERT INTO system_program VALUES(57,'Contrato Dashboard','ContratoDashboard');
INSERT INTO system_program VALUES(58,'Gera Faturas List','GeraFaturasList');
INSERT INTO system_program VALUES(59,'Fatura Form','FaturaForm');
INSERT INTO system_program VALUES(60,'Fatura List','FaturaList');
INSERT INTO system_program VALUES(61,'Fatura Dashboard','FaturaDashboard');
INSERT INTO system_program VALUES(62,'Gera Contas Receber List','GeraContasReceberList');
INSERT INTO system_program VALUES(63,'Conta Receber Form','ContaReceberForm');
INSERT INTO system_program VALUES(64,'Conta Receber List','ContaReceberList');
INSERT INTO system_program VALUES(65,'Conta Receber Quitacao List','ContaReceberQuitacaoList');
INSERT INTO system_program VALUES(66,'Financeiro Dashboard','FinanceiroDashboard');
INSERT INTO system_program VALUES(67,'Calendario Form','CalendarioForm');
INSERT INTO system_program VALUES(68,'Calendario View','CalendarioView');
INSERT INTO system_program VALUES(69,'Projeto Form','ProjetoForm');
INSERT INTO system_program VALUES(70,'Projeto List','ProjetoList');
INSERT INTO system_program VALUES(71,'Projeto Card List','ProjetoCardList');
INSERT INTO system_program VALUES(72,'Kanban Atividade Form','KanbanAtividadeForm');
INSERT INTO system_program VALUES(73,'Kanban Fase Form','KanbanFaseForm');
INSERT INTO system_program VALUES(74,'Kanban View','KanbanView');
CREATE TABLE system_unit (
    id int PRIMARY KEY NOT NULL,
    name varchar(256),
    connection_name varchar(256),
    custom_code varchar(256)
);
INSERT INTO system_unit VALUES(1,'Unit A','unit_a',NULL);
INSERT INTO system_unit VALUES(2,'Unit B','unit_b',NULL);
CREATE TABLE system_role (
    id int PRIMARY KEY NOT NULL,
    name varchar(256),
    custom_code varchar(256)
);
INSERT INTO system_role VALUES(1,'Role A','');
INSERT INTO system_role VALUES(2,'Role B','');
CREATE TABLE system_preference (
    id varchar(256),
    value text
);
CREATE TABLE system_users (
    id int PRIMARY KEY NOT NULL,
    name varchar(256),
    login varchar(256),
    password varchar(256),
    email varchar(256),
    accepted_term_policy char(1),
    phone varchar(256),
    address varchar(256),
    function_name varchar(256),
    about text,
    accepted_term_policy_at varchar(20),
    accepted_term_policy_data text,
    frontpage_id int,
    system_unit_id int REFERENCES system_unit(id),
    active char(1),
    custom_code varchar(256),
    otp_secret varchar(256),
    FOREIGN KEY(frontpage_id) REFERENCES system_program(id)
);
INSERT INTO system_users VALUES(1,'Administrator','admin','$2y$10$xuR3XEc3J6tpv7myC9gPj.Ab5GacSeHSZoYUTYtOg.cEc22G.iBwa','admin@admin.net','Y','+123 456 789','Admin Street, 123','Administrator','I''m the administrator',NULL,NULL,30,NULL,'Y',NULL,NULL);
INSERT INTO system_users VALUES(2,'User','user','$2y$10$MUYN29LOSHrCSGhrzvYG8O/PtAjbWvCubaUSTJGhVTJhm69WNFJs.','user@user.net','Y','+123 456 789','User Street, 123','End user','I''m the end user',NULL,NULL,30,NULL,'Y',NULL,NULL);
CREATE TABLE system_user_unit (
    id int PRIMARY KEY NOT NULL,
    system_user_id int,
    system_unit_id int,
    FOREIGN KEY(system_user_id) REFERENCES system_users(id),
    FOREIGN KEY(system_unit_id) REFERENCES system_unit(id)
);
INSERT INTO system_user_unit VALUES(3,2,1);
INSERT INTO system_user_unit VALUES(4,2,2);
INSERT INTO system_user_unit VALUES(5,1,1);
INSERT INTO system_user_unit VALUES(6,1,2);
CREATE TABLE system_user_group (
    id int PRIMARY KEY NOT NULL,
    system_user_id int,
    system_group_id int,
    FOREIGN KEY(system_user_id) REFERENCES system_users(id),
    FOREIGN KEY(system_group_id) REFERENCES system_group(id)
);
INSERT INTO system_user_group VALUES(3,2,2);
INSERT INTO system_user_group VALUES(4,1,1);
INSERT INTO system_user_group VALUES(5,1,2);
INSERT INTO system_user_group VALUES(6,1,3);
INSERT INTO system_user_group VALUES(7,1,4);
INSERT INTO system_user_group VALUES(8,1,5);
INSERT INTO system_user_group VALUES(9,1,6);
INSERT INTO system_user_group VALUES(10,1,7);
INSERT INTO system_user_group VALUES(11,1,8);
CREATE TABLE system_user_role (
    id int PRIMARY KEY NOT NULL,
    system_user_id int,
    system_role_id int,
    FOREIGN KEY(system_user_id) REFERENCES system_users(id),
    FOREIGN KEY(system_role_id) REFERENCES system_role(id)
);
CREATE TABLE system_group_program (
    id int PRIMARY KEY NOT NULL,
    system_group_id int,
    system_program_id int,
    FOREIGN KEY(system_group_id) REFERENCES system_group(id),
    FOREIGN KEY(system_program_id) REFERENCES system_program(id)
);
INSERT INTO system_group_program VALUES(1,1,1);
INSERT INTO system_group_program VALUES(2,1,2);
INSERT INTO system_group_program VALUES(3,1,3);
INSERT INTO system_group_program VALUES(4,1,4);
INSERT INTO system_group_program VALUES(5,1,5);
INSERT INTO system_group_program VALUES(6,1,6);
INSERT INTO system_group_program VALUES(7,1,7);
INSERT INTO system_group_program VALUES(8,1,8);
INSERT INTO system_group_program VALUES(9,1,9);
INSERT INTO system_group_program VALUES(10,1,10);
INSERT INTO system_group_program VALUES(11,1,11);
INSERT INTO system_group_program VALUES(12,1,12);
INSERT INTO system_group_program VALUES(13,1,13);
INSERT INTO system_group_program VALUES(14,1,14);
INSERT INTO system_group_program VALUES(15,1,15);
INSERT INTO system_group_program VALUES(16,1,16);
INSERT INTO system_group_program VALUES(17,1,17);
INSERT INTO system_group_program VALUES(18,1,18);
INSERT INTO system_group_program VALUES(19,1,19);
INSERT INTO system_group_program VALUES(20,1,20);
INSERT INTO system_group_program VALUES(21,1,21);
INSERT INTO system_group_program VALUES(22,1,22);
INSERT INTO system_group_program VALUES(23,1,23);
INSERT INTO system_group_program VALUES(24,1,24);
INSERT INTO system_group_program VALUES(25,1,25);
INSERT INTO system_group_program VALUES(26,1,26);
INSERT INTO system_group_program VALUES(27,1,27);
INSERT INTO system_group_program VALUES(28,1,28);
INSERT INTO system_group_program VALUES(29,2,29);
INSERT INTO system_group_program VALUES(30,2,30);
INSERT INTO system_group_program VALUES(31,2,31);
INSERT INTO system_group_program VALUES(32,2,32);
INSERT INTO system_group_program VALUES(33,2,33);
INSERT INTO system_group_program VALUES(34,2,34);
INSERT INTO system_group_program VALUES(35,2,35);
INSERT INTO system_group_program VALUES(36,2,36);
INSERT INTO system_group_program VALUES(37,2,37);
INSERT INTO system_group_program VALUES(38,3,38);
INSERT INTO system_group_program VALUES(39,3,39);
INSERT INTO system_group_program VALUES(40,3,40);
INSERT INTO system_group_program VALUES(41,3,41);
INSERT INTO system_group_program VALUES(42,3,42);
INSERT INTO system_group_program VALUES(43,3,43);
INSERT INTO system_group_program VALUES(44,3,44);
INSERT INTO system_group_program VALUES(45,3,45);
INSERT INTO system_group_program VALUES(46,3,46);
INSERT INTO system_group_program VALUES(47,3,47);
INSERT INTO system_group_program VALUES(48,3,48);
INSERT INTO system_group_program VALUES(49,4,49);
INSERT INTO system_group_program VALUES(50,4,50);
INSERT INTO system_group_program VALUES(51,4,51);
INSERT INTO system_group_program VALUES(52,4,52);
INSERT INTO system_group_program VALUES(53,5,53);
INSERT INTO system_group_program VALUES(54,5,54);
INSERT INTO system_group_program VALUES(55,5,55);
INSERT INTO system_group_program VALUES(56,5,56);
INSERT INTO system_group_program VALUES(57,5,57);
INSERT INTO system_group_program VALUES(58,5,58);
INSERT INTO system_group_program VALUES(59,6,59);
INSERT INTO system_group_program VALUES(60,6,60);
INSERT INTO system_group_program VALUES(61,6,61);
INSERT INTO system_group_program VALUES(62,6,62);
INSERT INTO system_group_program VALUES(63,7,63);
INSERT INTO system_group_program VALUES(64,7,64);
INSERT INTO system_group_program VALUES(65,7,65);
INSERT INTO system_group_program VALUES(66,7,66);
INSERT INTO system_group_program VALUES(67,8,67);
INSERT INTO system_group_program VALUES(68,8,68);
INSERT INTO system_group_program VALUES(69,8,69);
INSERT INTO system_group_program VALUES(70,8,70);
INSERT INTO system_group_program VALUES(71,8,71);
INSERT INTO system_group_program VALUES(72,8,72);
INSERT INTO system_group_program VALUES(73,8,73);
INSERT INTO system_group_program VALUES(74,8,74);
CREATE TABLE system_user_program (
    id int PRIMARY KEY NOT NULL,
    system_user_id int,
    system_program_id int,
    FOREIGN KEY(system_user_id) REFERENCES system_users(id),
    FOREIGN KEY(system_program_id) REFERENCES system_program(id)
);
CREATE TABLE system_user_old_password (
    id int PRIMARY KEY NOT NULL,
    system_user_id int,
    password varchar(256),
    created_at varchar(20),
    FOREIGN KEY(system_user_id) REFERENCES system_users(id)
);
CREATE TABLE system_program_method_role (
    id int PRIMARY KEY NOT NULL,
    system_program_id int,
    system_role_id int,
    method_name varchar(256),
    FOREIGN KEY(system_program_id) REFERENCES system_program(id),
    FOREIGN KEY(system_role_id) REFERENCES system_role(id)
);
CREATE INDEX sys_user_program_idx ON system_users(frontpage_id);
CREATE INDEX sys_user_group_group_idx ON system_user_group(system_group_id);
CREATE INDEX sys_user_group_user_idx ON system_user_group(system_user_id);
CREATE INDEX sys_group_program_program_idx ON system_group_program(system_program_id);
CREATE INDEX sys_group_program_group_idx ON system_group_program(system_group_id);
CREATE INDEX sys_user_program_program_idx ON system_user_program(system_program_id);
CREATE INDEX sys_user_program_user_idx ON system_user_program(system_user_id);
CREATE INDEX sys_users_name_idx ON system_users(name);
CREATE INDEX sys_group_name_idx ON system_group(name);
CREATE INDEX sys_program_name_idx ON system_program(name);
CREATE INDEX sys_program_controller_idx ON system_program(controller);
CREATE INDEX sys_unit_name_idx ON system_unit(name);
CREATE INDEX sys_role_name_idx ON system_role(name);
CREATE INDEX sys_preference_id_idx ON system_preference(id);
CREATE INDEX sys_user_unit_user_idx ON system_user_unit(system_user_id);
CREATE INDEX sys_user_unit_unit_idx ON system_user_unit(system_unit_id);
CREATE INDEX sys_user_role_user_idx ON system_user_role(system_user_id);
CREATE INDEX sys_user_role_role_idx ON system_user_role(system_role_id);
CREATE INDEX sys_user_old_password_user_idx ON system_user_old_password(system_user_id);
CREATE INDEX sys_program_method_role_program_idx ON system_program_method_role(system_program_id);
CREATE INDEX sys_program_method_role_role_idx ON system_program_method_role(system_role_id);
COMMIT;
