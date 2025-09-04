--- Create system_notification table
CREATE TABLE system_notification (
    id int PRIMARY KEY NOT NULL,
    system_user_id int,
    system_user_to_id int,
    subject varchar(256),
    message text,
    dt_message varchar(20),
    action_url text,
    action_label varchar(256),
    icon varchar(100),
    checked char(1)
);

--- Create indexes
CREATE INDEX sys_notification_user_id_idx ON system_notification(system_user_id);
CREATE INDEX sys_notification_user_to_idx ON system_notification(system_user_to_id);

