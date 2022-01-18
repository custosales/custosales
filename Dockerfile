FROM node:latest
USER root
RUN apt-get update && apt-get install -y npm postgresql postgresql-contrib
RUN ["pg_ctlcluster","13","main","start"]
EXPOSE 3000
RUN ["mkdir","custosales"]
ADD * /custosales/
WORKDIR "/custosales"
USER postgres
RUN psql -c "create user custosales with password 'custosales'";
RUN psql -c 'create database custosales owner custosales;'
RUN psql custosales -f install/custosales_all_pg.sql
USER root
ENTRYPOINT sh "pg_ctlcluster 13 main start && npm start"
