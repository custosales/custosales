FROM node:latest
USER root
RUN apt-get update && apt-get install -y npm postgresql portsgresql-contrib
RUN systemctl enable postgresql
RUN service postgresql start
EXPOSE 3000
RUN ["mkdir","custosales"]
ADD * /custosales/
WORKDIR "/custosales"
USER postgres
RUN psql -c "create user custosales with password 'custo432a'";
RUN psql -c 'create database custosales owner custosales;'
RUN psql custosales -f install/custosales_all_pg.sql
USER root
ENTRYPOINT ["npm","start"]
