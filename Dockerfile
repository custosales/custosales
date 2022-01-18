FROM postgres:13
ENV POSTGRES_PASSWORD custosales
ENV POSTGRES_DB custosales
RUN ["mkdir","custosales"]
COPY install/custosales_all_pg.sql /docker-entrypoint-initdb.d/
USER postgres
CMD psql -c "create user custosales with password 'custosales'";
CMD psql -c "alter database custosales owner custosales"; 

FROM node:latest
USER root
RUN apt-get update
WORKDIR "/custosales"
ADD * /custosales/

EXPOSE 3000

ENTRYPOINT ["npm","start"]

