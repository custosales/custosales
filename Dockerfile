FROM postgres:13
ENV POSTGRES_PASSWORD custosales
ENV POSTGRES_DB custosales
RUN apt-get update
RUN apt-get install -y postgresql-contrib postgresql-client
RUN ["mkdir","custosales"]
COPY install/custosales_all_pg.sql /custosales/
RUN pg_ctlcluster 13 main start
USER postgres
RUN psql -c create user custosales with password 'custosales'
RUN create database custosales owner custosales
RUN psql -d custosales -f custosales_all_pg.sql


FROM node:latest
USER root
WORKDIR "/custosales"
ADD * /custosales/

EXPOSE 3000

ENTRYPOINT ["npm","start"]

