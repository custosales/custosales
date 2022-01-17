FROM node:latest
EXPOSE 3000
RUN ["mkdir","custosales"]
ADD * /custosales/
WORKDIR "/custosales"
ENTRYPOINT ["npm","start"]
