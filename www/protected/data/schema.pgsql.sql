
CREATE TABLE config (
                key_name VARCHAR NOT NULL,
                value VARCHAR NOT NULL,
                CONSTRAINT config_pk PRIMARY KEY (key_name)
);


CREATE SEQUENCE job_id_seq;

CREATE TABLE job (
                id INTEGER NOT NULL DEFAULT nextval('job_id_seq'),
                type SMALLINT NOT NULL,
                display_name VARCHAR NOT NULL,
                description VARCHAR NOT NULL,
                cron_times VARCHAR NOT NULL,
                exec_path VARCHAR NOT NULL,
                max_exec_time SMALLINT NOT NULL,
                max_retry SMALLINT DEFAULT 0 NOT NULL,
                panic_threshold SMALLINT NOT NULL,
                created_on TIMESTAMP DEFAULT CURRENT_TIMESTAMP NOT NULL,
                changed_on TIMESTAMP,
                CONSTRAINT job_pk PRIMARY KEY (id)
);
COMMENT ON COLUMN job.type IS 'Hardcoded Job-Types
0: LOCAL, 1: SSH, 2: HTTP';
COMMENT ON COLUMN job.cron_times IS 'Schedule in Cron Definition format (http://www.wikipedia.org/wiki/Cron)';
COMMENT ON COLUMN job.max_exec_time IS 'Maximum allowed script execution time in seconds';
COMMENT ON COLUMN job.max_retry IS 'Retries after job failure before it''s considered broken';
COMMENT ON COLUMN job.panic_threshold IS 'Seconds of continuous job failure after which admins will be alarmed';
COMMENT ON COLUMN job.created_on IS 'Date this job was created';
COMMENT ON COLUMN job.changed_on IS 'Timestamp the job setup was last modified';


ALTER SEQUENCE job_id_seq OWNED BY job.id;

CREATE SEQUENCE job_run_id_seq;

CREATE TABLE job_run (
                id BIGINT NOT NULL DEFAULT nextval('job_run_id_seq'),
                job_id INTEGER NOT NULL,
                start_time TIMESTAMP NOT NULL,
                end_time TIMESTAMP NOT NULL,
                running_flag BOOLEAN NOT NULL,
                success_flag BOOLEAN NOT NULL,
                output VARCHAR NOT NULL,
                exit_code SMALLINT NOT NULL,
                CONSTRAINT job_run_pk PRIMARY KEY (id)
);


ALTER SEQUENCE job_run_id_seq OWNED BY job_run.id;

ALTER TABLE job_run ADD CONSTRAINT cronjob_log_fk
FOREIGN KEY (job_id)
REFERENCES job (id)
ON DELETE NO ACTION
ON UPDATE NO ACTION
NOT DEFERRABLE;
