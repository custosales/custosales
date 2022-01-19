FROM postgres:14
ENV POSTGRES_PASSWORD custosales
ENV POSTGRES_DB custosales
RUN apt-get update
RUN apt-get install -y postgresql-contrib postgresql-client
RUN ["mkdir","custosales"]
COPY install/custosales_all_pg.sql /custosales/
RUN pg_lsclusters
RUN pg_createcluster 14 'main'
RUN pg_ctlcluster 14 main start
CMD pg_ctlcluster 14 main start
USER postgres
RUN psql -c "create user custosales with password 'custosales'"
RUN psql -c "create database custosales owner custosales"
RUN psql -d custosales -f custosales_all_pg.sql


FROM node:latest
USER root
WORKDIR "/custosales"
ADD * /custosales/

EXPOSE 3000

ENTRYPOINT ["npm","start"]

