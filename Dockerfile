FROM readytalk/nodejs
EXPOSE 3000
ADD custosales-0.0.10.tgz custosales-0.0.10.tgz
RUN ["tar","xzf","custosales-0.0.10.tgz"]
RUN ['cd','custosales']
RUN ['npm','i']
ENTRYPOINT ['/custosales/npm','start']
