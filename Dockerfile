FROM postgres:14
ENV POSTGRES_PASSWORD custosales
ENV POSTGRES_DB custosales
RUN apt-get update
RUN apt-get install -y postgresql-contrib postgresql-client
RUN ["mkdir","custosales"]
COPY install/custosales_all_pg.sql /custosales/
RUN pg_lsclusters
RUN pg_createcluster 14 'main'
USER postgres
CMD pg_ctlcluster 14 main start && psql -U postgres -c "create user custosales with password 'custosales'" && psql -U postgres -c "create database custosales owner custosales" && psql -U postgres -d custosales -f custosales_all_pg.sql



FROM node:latest
USER root
WORKDIR "/custosales"
ADD * /custosales/

EXPOSE 3000

ENTRYPOINT ["npm","start"]

