FROM node:latest
USER root
RUN ["mkdir","custosales"]
ADD * /custosales/
WORKDIR "/custosales"
EXPOSE 3000


RUN apt-get update
RUN apt-get install -y postgresql postgresql-contrib 
RUN apt-get install -y postgresql-client
RUN pg_lsclusters
RUN pg_createcluster 14 'main'
USER postgres
CMD pg_ctlcluster 14 main start && psql -U postgres -c "create user custosales with password 'custosales'" && psql -U postgres -c "create database custosales owner custosales" && psql -U postgres -d custosales -f custosales_all_pg.sql



ENTRYPOINT ["npm","start"]

