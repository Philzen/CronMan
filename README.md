CronMan
=======

A CronJob Management Dashboard Application
------------------------------------------
The Project aims at building a complete solution to handle jobs on the local as well as any remote machines, for instance local bash & php scripts or remote execution via HTTP & SSH. 

Requirements:
- framework to handle all aspects of cronjob activity, including logic to handle failures, maximum allowed concurrent job instances and collecting log output and runtime statistics (total run time, memory usage, etc...)
- frontend with complete dashboard functionality, including GANTT-chart-like overview of job concurrency for resource planning purposes
- installation as self-contained as possible (SQLite or outher Local Storage Mechanism would be great to increase on this aspect)
- multiple database backend support
- based on Yii 1.1.x Framework



Requirements:
=============
WebServer with PHP 5.3, PostgreSql (MySQL and SQLite support on Roadmap)


