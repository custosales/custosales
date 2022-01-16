FROM readytalk/nodejs
EXPOSE 3000
RUN ["mkdir","custosales"]
ADD * /custosales/
RUN ["npm","custosales/install"]
ENTRYPOINT ["npm","custosales/start"]
