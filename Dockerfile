FROM readytalk/nodejs
EXPOSE 3000
ADD custosales-0.0.10.tgz custosales-0.0.10.tgz
ENTRYPOINT ["tar","xzf","/custosales-0.0.10.tgz"]
