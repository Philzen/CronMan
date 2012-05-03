
CREATE TABLE config (
                key_name VARCHAR NOT NULL,
                value VARCHAR NOT NULL,
                PRIMARY KEY (key_name)
);


CREATE TABLE job (
                id INT AUTO_INCREMENT NOT NULL,
                type SMALLINT NOT NULL,
                display_name VARCHAR NOT NULL,
                description VARCHAR NOT NULL,
                cron_times VARCHAR NOT NULL,
                exec_path VARCHAR NOT NULL,
                max_exec_time SMALLINT NOT NULL,
                max_retry SMALLINT DEFAULT 0 NOT NULL,
                panic_threshold SMALLINT NOT NULL,
                created_on DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL,
                changed_on DATETIME,
                PRIMARY KEY (id)
);

ALTER TABLE job MODIFY COLUMN type SMALLINT COMMENT 'Hardcoded Job-Types
0: LOCAL, 1: SSH, 2: HTTP';

ALTER TABLE job MODIFY COLUMN cron_times VARCHAR COMMENT 'Schedule in Cron Definition format (http://www.wikipedia.org/wiki/Cron)';

ALTER TABLE job MODIFY COLUMN max_exec_time SMALLINT COMMENT 'Maximum allowed script execution time in seconds';

ALTER TABLE job MODIFY COLUMN max_retry SMALLINT COMMENT 'Retries after job failure before it''s considered broken';

ALTER TABLE job MODIFY COLUMN panic_threshold SMALLINT COMMENT 'Seconds of continuous job failure after which admins will be alarmed';

ALTER TABLE job MODIFY COLUMN created_on TIMESTAMP COMMENT 'Date this job was created';

ALTER TABLE job MODIFY COLUMN changed_on TIMESTAMP COMMENT 'Timestamp the job setup was last modified';


CREATE TABLE job_run (
                id BIGINT AUTO_INCREMENT NOT NULL,
                job_id INT NOT NULL,
                start_time DATETIME NOT NULL,
                end_time DATETIME NOT NULL,
                running_flag BOOLEAN NOT NULL,
                success_flag BOOLEAN NOT NULL,
                output VARCHAR NOT NULL,
                exit_code SMALLINT NOT NULL,
                PRIMARY KEY (id)
);


ALTER TABLE job_run ADD CONSTRAINT cronjob_log_fk
FOREIGN KEY (job_id)
REFERENCES job (id)
ON DELETE NO ACTION
ON UPDATE NO ACTION;
