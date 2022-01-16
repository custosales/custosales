FROM readytalk/nodejs
EXPOSE 3000
RUN ["mkdir","custosales"]
ADD * /custosales
RUN ["cd","custosales"]
RUN ["npm","install"]
ENTRYPOINT ["/custosales/npm","start"]
