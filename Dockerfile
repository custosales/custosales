FROM readytalk/nodejs
EXPOSE 3000
RUN ["mkdir","custosales"]
ADD * /custosales/
RUN ["/custosales/npm","install"]
ENTRYPOINT ["/custosales/npm","start"]
