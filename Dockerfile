FROM readytalk/nodejs
EXPOSE 3000
RUN ["mkdir","custosales"]
ADD * /custosales/
WORKDIR "/custosales"
ENTRYPOINT ["npm","start"]
