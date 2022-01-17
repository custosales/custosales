FROM node:latest
EXPOSE 3000
RUN ["mkdir","custosales"]
ADD * /custosales/
ADD /home/felles/.env /custosales/
WORKDIR "/custosales"
ENTRYPOINT ["npm","start"]
