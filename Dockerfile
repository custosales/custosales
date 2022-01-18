FROM node:latest
USER root
RUN apt-get update
RUN apt install -y postgresql
EXPOSE 3000
RUN ["mkdir","custosales"]
ADD * /custosales/
WORKDIR "/custosales"
RUN pg_ctlcluster 13 main start
USER postgres
RUN psql -c create user custosales with password 'custosales'
RUN psql -c create database custosales owner custosales
RUN psql custosales -f install/custosales_all_pg.sql
USER root
ENTRYPOINT pg_ctlcluster 13 main start && npm start
